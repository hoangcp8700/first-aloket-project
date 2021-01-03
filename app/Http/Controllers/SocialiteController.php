<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\Social;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected $providers = [
        'github','facebook','google','twitter'
    ];
    public function show($socialite)
    {
        /// so sanh values co trong mang ko?
        $providers = collect($this->providers);
        $compare= $providers->intersect($socialite);
        if(!$compare->all()){
            return redirect(route('login'));
        }
        return view('auth.login');
    }

    // public function redirectToProvider($driver)
    // {
    //     if( ! $this->isProviderAllowed($driver) ) {
    //         return $this->sendFailedResponse("{$driver} is not currently supported");
    //     }

    //     try {
    //         return Socialite::driver($driver)->redirect();
    //     } catch (Exception $e) {
    //         // You should show something simple fail message
    //         return $this->sendFailedResponse($e->getMessage());
    //     }
    // }

    // public function handleProviderCallback( $driver )
    // {
    //     try {
    //         $user = Socialite::driver($driver)->user();
    //     } catch (Exception $e) {
    //         return $this->sendFailedResponse($e->getMessage());
    //     }

    //     // check for email in returned user
    //     return empty( $user->email )
    //         ? $this->sendFailedResponse("No email id returned from {$driver} provider.")
    //         : $this->loginOrCreateAccount($user, $driver);
    // }

    public function redirectToProvider($driver)
    {

        return Socialite::driver($driver)->redirect();
    }

    protected function sendSuccessResponse()
    {
        return redirect()->intended('profile');
    }

    protected function sendFailedResponse($msg = null)
    {
        return redirect()->route('login')
            ->withErrors(['msg' => $msg ?: 'Unable to login, try with another provider to login.']);
    }

    public function handleProviderCallback($driver)
    {

        $user = Socialite::driver($driver)->user();

        if(!empty($user->email)){
            return $this->loginOrCreateAccount($user, $driver);
        }
    }


    protected function loginOrCreateAccount($providerUser, $driver)
    {

        // check for already has account
        $user = User::where('email', $providerUser->getEmail())->first();

        // if user already found
        if( $user ) {
            $socialite = Social::where('user_id',$user->id)->where('provider',$driver)->first();
            if($socialite){
                // update the avatar and provider that might have changed
                $socialite->update([
                    'provider' => $driver,
                    'provider_id' => $providerUser->id,
                    'access_token' => $providerUser->token,
                ]);
            }else{
                Social::insert([
                    'user_id' => $user->id,
                    'provider' => $driver,
                    'provider_id' => $providerUser->id,
                    'access_token' => $providerUser->token,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

        } else {
            // create a new user
            if($providerUser->getEmail()){ //Check email exists or not. If exists create a new users
                $user = User::create([
                    'name' => $providerUser->getName(),
                    'email' => $providerUser->getEmail(),
                    // user can use reset password to create a password
                    'password' => null,
                ]);
                $getUserID = User::orderBy('id','desc')->first();

                Social::create([
                    'user_id' => $getUserID->id,
                    'provider' => $driver,
                    'provider_id' => $providerUser->getId(),
                    'access_token' => $providerUser->token,
                ]);
            }
        }

        // login the user
        Auth::login($user, true);

        return $this->sendSuccessResponse();
    }

    private function isProviderAllowed($driver)
    {
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }

}
