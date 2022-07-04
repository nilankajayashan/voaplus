<?php
namespace App\Http\Controllers;
use App\Models\Package;
use App\Models\User;
use App\Models\UserPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use MongoDB\Driver\Session;

class StreamController extends Controller
{
    public function view_stream(){
        $user_package = UserPackage::where('user_id', '=', session()->get('auth_user')->id)->where('status', '=', 'active')->first();
       $package = Package::where('name', '=', $user_package->package)->first();
        return view('stream', ['stream_link' => $package->siyatha_link]);
    }
    public function changeStream(Request $request){
        $validator = Validator::make($request->all(), [
            'channel' => 'required',
        ]);
        if ($validator->errors()->has('channel')){
            return redirect()->back()->with(['error' => 'Can not identify channel']);
        }
        $validated = $validator->validated();
        $user_package = UserPackage::where('user_id', '=', session()->get('auth_user')->id)->where('status', '=', 'active')->first();
        $package = Package::where('name', '=', $user_package->package)->first();
        switch ($validated['channel']){
            case 'siyatha_tv':
                return view('stream', ['stream_link' => $package->siyatha_link]);
                break;
            case 'startamil_tv':
                return view('stream', ['stream_link' => $package->startamil_link]);
                break;
            default:
                return view('stream');
                break;


        }
    }
    public function check_stream(){
        $user = User::find(session()->get('auth_user')['id']);
        return $user->stream_counter;
    }
    public function logged_stream(Request $request){

        $user = User::find(session()->get('auth_user')['id']);
        $browser_token = $_COOKIE['browser_token'];
        $token_list= explode("|",$user->browser_token);
        $token_state = in_array($browser_token, $token_list);
        if($token_state){
            $user_package = UserPackage::where('user_id', '=', session()->get('auth_user')->id)->where('status', '=', 'active')->first();
            if ($user_package != null){
                $package = Package::where('name', '=', $user_package->package)->first();
                return view('stream', ['stream_link' => $package->siyatha_link]);
            }
            else{
                return view('stream');
            }
        }else{
            setcookie('browser_token', null, time() + (86400 * 30), "/");
            return redirect()->route('my_account');
        }

    }
}
