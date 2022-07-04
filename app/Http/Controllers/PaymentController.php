<?php

namespace App\Http\Controllers;
use App\Mail\Stream_Token;
use App\Models\Package;
use App\Models\User;

use App\Models\UserPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isEmpty;

class PaymentController extends Controller
{
    public function makePayment(Request $request){
        $validator = Validator::make($request->all(), [
            'validation_period' => 'required',
            'package' => 'required',
            'package_id' => 'required',
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
            }elseif ($validator->errors()->has('package_id')){
                return redirect()->back()->with([
                    'package_error' => 'Please Click on valid package',
                ]);
            }
        }
        $validated = $validator->validated();
        $old_package = UserPackage::where('user_id', '=', session()->get('auth_user')->id)
            ->first();
        $device_count = 0;
        if ($old_package != null){
            UserPackage::where('user_id', '=', session()->get('auth_user')->id)->delete();
        }
            $user_package = new UserPackage();
            $user_package->user_id =  session()->get('auth_user')->id;
            $package = Package::where('name', '=', $validated['package'])->where('package_id', '=', $validated['package_id'])->first();
            $user_package->period =  $validated['validation_period'];
            $user_package->package =  $validated['package'];
            $user_package->payment_date = date("Y-m-d");
            $price = 0;
            if ( $validated['validation_period'] == '1-month'){
                $price = $package->one_month_price;
                $user_package->expire_date = date('Y-m-d', strtotime('+1 months'));
            }elseif( $validated['validation_period'] == '1-year'){
                $price = $package->one_year_price;
                $user_package->expire_date = date('Y-m-d', strtotime('+1 years'));
            }
            $payment_status = $this->getpayment($price);
            switch ($payment_status){
                case 'success':
                    $user_package->payment_state = 'success';
                    $user_package->payment = $price;
                    $user_package->status = 'active';
                    break;
                default:
                    $user_package->payment_state = 'failed';
                    $user_package->payment = 0;
                    $user_package->status = 'deactive';
                    break;
            }
            $device_count = $package->device_count;;
//            if ($validated['validation_period'] == '1-month'){
//                $user_package->expire_date = date('Y-m-d', strtotime('+1 months'));
//                switch ($validated['package']){
//                    case 'basic':
//                        $payment_status = $this->getpayment(0.99);
//                        switch ($payment_status){
//                            case 'success':
//                                $user_package->payment_state = 'success';
//                                $user_package->payment = 0.99;
//                                $user_package->status = 'active';
//                                break;
//                            default:
//                                $user_package->payment_state = 'failed';
//                                $user_package->payment = 0;
//                                $user_package->status = 'deactive';
//                                break;
//                        }
//                        $device_count = 1;
//                        break;
//                   case 'standard':
//                       $payment_status = $this->getpayment(1.99);
//                       switch ($payment_status){
//                           case 'success':
//                               $user_package->payment_state = 'success';
//                               $user_package->payment = 1.99;
//                               $user_package->status = 'active';
//                               break;
//                           default:
//                               $user_package->payment_state = 'failed';
//                               $user_package->payment = 0;
//                               $user_package->status = 'deactive';
//                               break;
//                       }
//                       $device_count = 3;
//                       break;
//                   case 'premium':
//                       $payment_status = $this->getpayment(9.99);
//                       switch ($payment_status){
//                           case 'success':
//                               $user_package->payment_state = 'success';
//                               $user_package->payment = 9.99;
//                               $user_package->status = 'active';
//                               break;
//                           default:
//                               $user_package->payment_state = 'failed';
//                               $user_package->payment = 0;
//                               $user_package->status = 'deactive';
//                               break;
//                       }
//                       $device_count = 10;
//                       break;
//                    default:
//                        $user_package->payment_state = 'failed';
//                        $user_package->payment = 0;
//                        $user_package->status = 'deactive';
//                        break;
//                }
//            }elseif ($validated['validation_period'] == '1-year'){
//                $user_package->expire_date = date('Y-m-d', strtotime('+1 years'));
//                switch ($validated['package']){
//                    case 'basic':
//                        $payment_status = $this->getpayment(9.99);
//                        switch ($payment_status){
//                            case 'success':
//                                $user_package->payment_state = 'success';
//                                $user_package->payment = 9.99;
//                                $user_package->status = 'active';
//                                break;
//                            default:
//                                $user_package->payment_state = 'failed';
//                                $user_package->payment = 0;
//                                $user_package->status = 'deactive';
//                                break;
//                        }
//                        $device_count = 1;
//                        break;
//                    case 'standard':
//                        $payment_status = $this->getpayment(19.99);
//                        switch ($payment_status){
//                            case 'success':
//                                $user_package->payment_state = 'success';
//                                $user_package->payment = 19.99;
//                                $user_package->status = 'active';
//                                break;
//                            default:
//                                $user_package->payment_state = 'failed';
//                                $user_package->payment = 0;
//                                $user_package->status = 'deactive';
//                                break;
//                        }
//                        $device_count = 3;
//                        break;
//                    case 'premium':
//                        $payment_status = $this->getpayment(99.99);
//                        switch ($payment_status){
//                            case 'success':
//                                $user_package->payment_state = 'success';
//                                $user_package->payment = 99.99;
//                                $user_package->status = 'active';
//                                break;
//                            default:
//                                $user_package->payment_state = 'failed';
//                                $user_package->payment = 0;
//                                $user_package->status = 'deactive';
//                                break;
//                        }
//                        $device_count = 10;
//                        break;
//                    default:
//                        $user_package->payment_state = 'failed';
//                        $user_package->payment = 0;
//                        $user_package->status = 'deactive';
//                        break;
//                }
//            }
            $user_package->save();
            $saved_package = UserPackage::where('user_id', '=', session()->get('auth_user')->id)->first();
            if ($saved_package != null){
                if ($saved_package->status == 'active'){
                    if ($saved_package->payment_state == 'success'){
                        $user = User::find(session()->get('auth_user')['id']);
                        $stream_token = md5(date("Y-m-d h:i:sa"));
                        $stream_token = substr($stream_token,0,5);
                        $user->stream_token = $stream_token;
                        $user->device_count = $device_count;
                        $user->payment_date = date("Y-m-d");
                        $user->save();
                        session()->put('stream_token', $stream_token);
                        Mail::to($user->email)->send(new Stream_Token());
                        if (Mail::failures()) {
                            $mail_status_message = 'Stream token sent failed to your email | Email:'.$user->email;
                            $mail_status = 1;
                        }else{
                            $mail_status_message = 'Please check your email and submit the stream token in the box below. (If you are unable to locate it please make sure to check your spam/ junk mail folders.)| Email:'.$user->email;
                            $mail_status = 0;
                        }
                        session()->put('auth_user', $user);
                        return redirect()->route('my_account')->with([
                            'mail_status_message' => $mail_status_message,
                            'mail_status' => $mail_status,

                        ]);
                    }
           }
            }




    }
    public function getpayment($payment){
        return 'success';
    }
}
