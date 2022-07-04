<?php

namespace App\Http\Controllers;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyMail;
class RegistationController extends Controller
{
    public function register_validate(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'email|required',
            'password' => 'required',
//            'phone' => 'required',
        ]);


        try{
            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
//          $user->mobile_number = $validated['phone'];
            $user->password = Hash::make($validated['password']);
            $verify_token = rand(1000,9999);
            $user->verification = $verify_token;
            $user->save();
            $request->session()->put('reg_user', $user);
            Mail::to($user->email)->send(new VerifyMail());
            if (Mail::failures()) {
                $mail_status = 'Verification code sent failed to your email | Email:'.$user->email;
            }else{
                $mail_status = 'Please check your email and submit the Verification code in the box below. (If you are unable to locate it please make sure to check your spam/ junk mail folders.) | Email:'.$user->email;
            }
            return redirect()->route('verification')->with([
                'mail_status' => $mail_status,
                ]);
        }catch (Exception $e){
            $error = "";
            if($e->getCode() == 23000){
                $error = "Email already use";
            }
            else{
                $error = "try again later";
            }
            return redirect()->route('register')->with(['error'=> $error]);
        }
    }

    public function account_verification(Request $request){
        if(session()->get('reg_user') != null){
            $user = User::find(session()->get('reg_user')['id']);
        }else{
            $user = User::find(session()->get('auth_user')['id']);
        }
        if ($user->verification == 'verified'){
            $request->session()->put('auth_user', $user);
            return redirect()->route('my_account')->with([
                'verified' => $user->name.' Your account already verified...!'
            ]);
        }
        elseif($user->verification == $request->verification_code){
            $user->verification = 'verified';
            //reg user session eka clear karanna.
            $request->session()->put('auth_user', $user);
            $user->save();
            return redirect()->route('my_account')->with([
                'verified' => $user->name.' Your account verified successfully...!'
            ]);
        }
        return redirect()->route('verification')->with([
            'token_error' => $user->name.' Your entered verification code is wrong...! please try again'
        ]);
    }
     public function resent_verification(Request $request){

        if(session()->get('reg_user') != null){
            $user = User::find(session()->get('reg_user')['id']);
        }else{
            $user = User::find(session()->get('auth_user')['id']);
        }
        if ($user->verification == 'verified'){
            $request->session()->put('auth_user', $user);
            return redirect()->route('my_account')->with([
                'verified' => $user->name.' Your account already verified...!'
            ]);
        }else{
            $verify_token = rand(1000,9999);
            $user->verification = $verify_token;
            $user->save();
            $request->session()->put('reg_user', $user);
            Mail::to($user->email)->send(new VerifyMail());
            if (Mail::failures()) {
                $mail_status = 'Verification code sent failed to your email | Email:'.$user->email;
            }else{
                $mail_status = 'Please check your email again and submit the Verification code in the box below. (If you are unable to locate it please make sure to check your spam/ junk mail folders.) | Email:'.$user->email;
            }
            return redirect()->route('verification')->with([
                'mail_status' => $mail_status,
            ]);
        }
    }
}
