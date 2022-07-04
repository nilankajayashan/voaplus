<?php
namespace App\Http\Controllers;
use App\Mail\PasswordReset;
use App\Mail\PasswordResetStatus;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function login_validate(Request $request){
        $validated = $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);
        try{
            $user = User::where('email','=',$request->email)->first();
            if(Hash::check(request('password'), $user->password)){
                if($request->remeber == 'on'){
                    setcookie('email',$request->email,time()+60*60*24*30,'/');
                    setcookie('password',$request->password,time()+60*60*24*30,'/');
                }
                $request->session()->put('auth_user', $user);
                return redirect()->route('my_account');
            }else{
                return redirect()->route('login')
                    ->withErrors([
                        'invalid_password' => 'Dear '. $user->name .' you entered password is invalid.',
                    ]);
            }
        }catch (Exception $e){
            if($e->getMessage() == 'Attempt to read property "password" on null' || $e->getMessage() == "Trying to get property 'password' of non-object"){
                return redirect()->route('login')
                    ->withErrors([
                        'invalid_email' => 'Dear user you entered e-mail is unavailable.',
                    ]);
            }else{
                dd($e->getMessage());
            }
        }
    }

    public function reset_login_state(){
        $user = User::find(session()->get('auth_user')['id']);
        $user->browser_token = null;
        $user->stream_counter = 0;
        $user->save();
        setcookie('browser_token', null, time() + (86400 * 30), "/");
        session()->forget(['auth_user']);
        session()->flush();

        return redirect()->route('login')->with([
            'clear_state' => 'Logout all sessions success',
            'reset_status' => session()->has('reset_status')?session()->get('reset_status'):null,
            'reset_status_message' => session()->has('reset_status_message')?session()->get('reset_status_message'):null,
        ]);
    }

    public function logout(){
        session()->forget(['auth_user']);
        session()->flush();
        return redirect()->route('login');
    }
    public function remove_device(){
        $user = User::find(session()->get('auth_user')['id']);
        $browser_token = $_COOKIE['browser_token'];;
        $token_list= explode("|",$user->browser_token);
        $token_state = in_array($browser_token, $token_list);
        if($token_state){
            if(count($token_list) == 1){
                $user->browser_token = null;
            }
            else{
                $token_index = array_search($browser_token,$token_list);
                unset($token_list[$token_index]);
                $user->browser_token = implode("|",$token_list);
            }
        }
        if (($user->stream_counter - 1)< 0){
            $user->stream_counter = 0;
        }else{
            $user->stream_counter = $user->stream_counter - 1;
        }
        $user->save();
        session()->forget(['auth_user']);
        session()->flush();
        setcookie('browser_token', null, time() + (86400 * 30), "/");
        return redirect()->route('login')->with([
            'clear_state' => 'Logout this device successfully',
        ]);
    }

    public function forgot_mail(Request $request){
        if(isset($request->email) || $request->email != null){
            $user = User::where('email','=',$request->email)->first();
            session()->put('password_reset_mail',$request->email);
        }else{
            $user = User::where('email','=',session()->get('password_reset_mail'))->first();

        }


        if ($user == null){
            return redirect()->route('forgot_password')->with([
                'not_available' => 'You entered email ['. $request->email .'] is not available in our system you can register with us now...'
            ]);
        }else{
            $reset_token = rand(1000,9999);
            setcookie('reset_code_status', 'send', time() + (600), "/");
            session()->put('password_reset_code',$reset_token);
            Mail::to($user->email)->send(new PasswordReset());
            if (Mail::failures()) {
                $mail_status_message = 'Password reset code sent failed to your email, please try again | Email:'.$user->email;
                return redirect()->route('forgot_password')->with([
                    'mail_status_message' => $mail_status_message,
                ]);
            }else{
                $mail_status_message = 'Please check your email and submit the password reset code in the box below. (If you are unable to locate it please make sure to check your spam/ junk mail folders.) | Email:'.$user->email;
                return redirect()->route('get_password_reset_code')->with([
                    'mail_status_message' => $mail_status_message,
                ]);
            }

        }
    }

    public function verify_password_reset_code(Request $request){
        $validated = $request->validate([
            'reset_code' => 'required',
        ]);
        if(isset($_COOKIE['reset_code_status']) && $_COOKIE['reset_code_status'] == 'send'){
            if($request->reset_code == session()->get('password_reset_code')){
                session()->put('password_reset_code','verified');
                return redirect()->route('update_password');
            }else{
                return redirect()->route('get_password_reset_code')->with([
                    'reset_code_error' => 'You entered code is not valid please try again',
                ]);
            }
        }else{
            setcookie('reset_code_status', null, time()-1, "/");
            session()->forget(['password_reset_code', 'password_reset_mail']);
            session()->flush();
            return redirect()->route('forgot_password')->with([
                'reset_timeout' => 'Your password reset timeout...! please try again',
            ]);
        }

    }

    public function change_password(Request $request){
        try{
            $user = User::where('email','=',session()->get('password_reset_mail'))->first();
            $user->password = Hash::make($request->password);
            $user->save();
            session()->put('password_reset_status','success');
            $reset_status = 1;
            $reset_status_message = 'Your password reset successfully...! please try to login now';
        }catch (Exception $e){
            session()->put('password_reset_status','fail');
            $reset_status = 0;
            $reset_status_message = 'Your password reset fail...! please try again later';

        } finally {

            $user = User::where('email','=',session()->get('password_reset_mail'))->first();
            Mail::to($user->email)->send(new PasswordResetStatus());
            setcookie('reset_code_status', null, time()-1, "/");
            session()->forget(['password_reset_code', 'password_reset_mail']);
            session()->flush();
            return redirect()->route('login')->with([
                'reset_status' => $reset_status,
                'reset_status_message' => $reset_status_message,
            ]);
        }

    }
}
