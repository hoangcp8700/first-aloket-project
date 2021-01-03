<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email'           => 'required',
            'password'           => 'required',
        ],[
            'email.required' => 'Vui lòng nhập địa chỉ email',
            'password.required'=> 'Vui lòng nhập mật khẩu',
        ]);
        if ($validator->fails()) {
            return back()
                ->with('statuscode','error')
                ->with('formPage','error')
                ->with('status',$validator->messages()->all()[0])
                ->withInput();
        }

        if(Auth::attempt(['email' => $request['email'], 'password' => $request['password']]))
        {
            return redirect()->route('page.profile.index');
        }else{
            return redirect()->back()
                ->with('statuscode','error')
                ->with('formPage','error')
                ->with('status','Tài khoản hoặc mật khẩu không chính xác');
        }

    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
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

    public function redirectToProvider($driver)
    {
        if( ! $this->isProviderAllowed($driver) ) {
            return $this->sendFailedResponse("{$driver} is not currently supported");
        }

        try {
            return Socialite::driver($driver)->redirect();
        } catch (Exception $e) {
            // You should show something simple fail message
            return $this->sendFailedResponse($e->getMessage());
        }
    }

    public function handleProviderCallback( $driver )
    {
        try {
            $user = Socialite::driver($driver)->user();
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

        // check for email in returned user
        return empty( $user->email )
            ? $this->sendFailedResponse("No email id returned from {$driver} provider.")
            : $this->loginOrCreateAccount($user, $driver);
    }

    protected function sendSuccessResponse()
    {
        return redirect()->intended();
    }

    protected function sendFailedResponse($msg = null)
    {
        return redirect()->route('login')
            ->withErrors(['msg' => $msg ?: 'Unable to login, try with another provider to login.']);
    }

    protected function loginOrCreateAccount($providerUser, $driver)
    {
        // check for already has account
        $user = User::where('email', $providerUser->getEmail())->first();

        $socialite = Socialite::where('user_id',$user->id)->first();
        // if user already found
        if( $user ) {
            // update the avatar and provider that might have changed
            $socialite->update([

                'provider' => $driver,
                'provider_id' => $providerUser->id,
                'access_token' => $providerUser->token
            ]);
        } else {
            // create a new user
            if($providerUser->getEmail()){ //Check email exists or not. If exists create a new users
                $user = User::create([
                    'name' => $providerUser->getName(),
                    'email' => $providerUser->getEmail(),
                    'image' => $providerUser->getAvatar(),
                    // user can use reset password to create a password
                    'password' => ''
                ]);
                $getUserID = User::orderBy('id','desc')->first();

                $socialite = Socialite::create([
                    'user_id' => $getUserID->id,
                    'provider' => $driver,
                    'provider_id' => $providerUser->getId(),
                    'access_token' => $providerUser->token,
                ]);
            }else{
                echo "<Script>alert('Chúng tối không chấp nhận {$driver} dùng số tài khoản để đăng ký! Vui lòng tạo tài khoản hoặc dùng mạng xã hội khác. Xin cảm ơn!')</script>";
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
