<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Intervention\Image\Facades\Image as InterImage;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Redirect the user to the Discord authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('discord')->redirect();
    }

    /**
     * Obtain the user information from Discord.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request)
    {
        session()->put('state', $request->input('state'));

        $user = Socialite::driver('discord')->user();

        $foundUser = User::where('email', '=', $user->email)->first();

        if (! $foundUser) {
            if ($user->avatar != null) {
                $url = $user->avatar.'?size=256';
                $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
                $contents = file_get_contents($url);
                $name = 'avatars/'.strtolower($user->name.$user->user['discriminator']).".${extension}";
                Storage::disk('public')->put($name, $contents);
                $avatar = $name;
            } else {
                $avatar = 'avatars/default.png';
            }

            $user->verified = ($user->user['verified']) ? Date::now() : null;

            $foundUser = User::create([
                'username' => $user->name.$user->user['discriminator'],
                'email' => $user->email,
                'email_verified_at' => $user->verified,
                'avatar' => $avatar,
                'api_token' => Str::random(20)
            ]);

            if ($user->avatar != null) {
                $location = storage_path('app/public/avatars/'.strtolower($user->name.$user->user['discriminator']).".${extension}");
                InterImage::make($location)->resize(150, 150)->save($location);
                $foundUser->avatar = $avatar;
                $foundUser->save();
            }
        }

        Auth::login($foundUser, true);

        toast('Login Successfully With Discord!','success');

        return redirect($this->redirectPath());
    }

    protected function authenticated(Request $request)
    {
        // toast('Login Successfully!','success');
        
        return Redirect::back();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = $this->findUsername();
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function findUsername()
    {
        $login = request()->input('login');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }

    /**
     * Get username property.
     *
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

    public function logout()
    {
        Auth::logout();

        toast('Logout Successfully!','success');

        return Redirect::route('home');
    }
}
