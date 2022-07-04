<?php
namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;
use App\Mail\PasswordResetStatus;
use App\Mail\Stream_Token;
use App\Models\Package;
use App\Models\User;
use App\Models\UserPackage;
use DateInterval;
use DateTime;
use Exception;
use http\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MyAccountController extends Controller
{
    public function index(){
        $packages = Package::all();
        return view('user/my_account', ['packages' => $packages]);
    }
    public function validate_token(Request $request){
        $validated = $request->validate([
            'stream_key' => 'required',

        ]);
        $user = User::find(session()->get('auth_user')['id']);
        if ($request->input('stream_key') == $user->stream_token){
            $package = UserPackage::where('user_id', '=', session()->get('auth_user')->id)->first();
            $date = new DateTime($package->expire_date);
            if (date("Y-m-d") <= $date->format('Y-m-d')) {
                if ($package->status == 'active') {
                    if ($user->device_count > $user->stream_counter) {
                        if (($user->stream_counter + 1) > 3 || ($user->stream_counter + 1) <= 0) {
                            return redirect()->route('my_account')->with([
                                'system_error' => 'Some thing went wrong...! please report',
                            ]);
                        }
                        $user->stream_counter = $user->stream_counter + 1;
                        $browser_token = md5(date("Y-m-d h:i:sa"));
                        setcookie('browser_token', $browser_token, time() + (86400 * 30), "/");
                        if ($user->browser_token == null) {
                            $user->browser_token = $browser_token;
                        } else {
                            $user->browser_token = $user->browser_token . '|' . $browser_token;
                        }
                        $user->save();
                        return redirect()->route('view_stream');

                    } else {
                        return redirect()->route('my_account')->with([
                            'token_full_error' => 'Your logged device count is full',
                        ]);
                    }
                } else {
                    $request->session()->put('auth_user', $user);
                    return redirect()->route('my_account')->with([
                        'deactivate' => 'Your Stream Package is deactivated yet..., please contact VOA+ administrators',
                    ]);
                }
            }else{
                $user->stream_token = null;
                $user->device_count = 0;

                $user->save();
                $request->session()->put('auth_user', $user);
                return redirect()->route('my_account')->with([
                    'expire' => 'Your Stream duration is expired please update your plan',
                ]);
            }
        }else{
            return redirect()->route('my_account')->with([
                'key_error' => 'You entered stream key is invalid',
            ]);
        }
    }
    public function package(Request $request){
        //$request->session()->put('package',$request->package);
        $validator = Validator::make($request->all(), [
            'validation_period' => 'required',
            'package' => 'required',
        ]);
        if ($validator->fails()){
            if ($validator->errors()->has('validation_period')){
                return redirect()->back()->with([
                    'validation_period_error' => 'Please Select validation Period',
                ]);
            }elseif ($validator->errors()->has('package')){
                return redirect()->back()->with([
                    'package_error' => 'Please Click on valid package',
                ]);
            }
        }
        $validated = $validator->validated();

        return view('payment')->with([
            'package'=> $request->package,
        ]);
    }
    public function free_package(){
        $user = User::find(session()->get('auth_user')['id']);
        $stream_token = md5(date("Y-m-d h:i:sa"));
        $stream_token = substr($stream_token,0,5);
       $user->stream_token = $stream_token;
       $user->device_count = 1;
       $user->payment_date = date("Y-m-d");
       $user->save();
       session()->put('stream_token', $stream_token);
       Mail::to($user->email)->send(new Stream_Token());
        if (Mail::failures()) {
            $mail_status_message = 'Stream token sent failed to your email | Email:'.$user->email;
            $mail_status = 1;
        }else{
            $mail_status_message = 'Please check  your email and submit the Stream Token in the box Below. ( If you are unable to locate it please make sure to check your spam / junk mail folders) | Email:'.$user->email;
            $mail_status = 0;
        }
        session()->put('auth_user', $user);
        return redirect()->route('my_account')->with([
            'mail_status_message' => $mail_status_message,
            'mail_status' => $mail_status,

        ]);
    }
    public function change_password(Request $request){
        try{
            $user = User::find(session()->get('auth_user')['id']);
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
            $user = User::find(session()->get('auth_user')['id']);
            Mail::to($user->email)->send(new PasswordResetStatus());
            return redirect()->route('reset_login_state')->with([
                'reset_status' => $reset_status,
                'reset_status_message' => $reset_status_message,
            ]);
        }
    }
}
