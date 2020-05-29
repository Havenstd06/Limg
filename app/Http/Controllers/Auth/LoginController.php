<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as InterImage;
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
                $name = 'storage/avatars/'.strtolower($user->name.$user->user['discriminator']).".${extension}";
                Storage::disk('public')->put($name, $contents);
                $avatar = $name;
            } else {
                $avatar = 'storage/avatars/default.png';
            }

            $user->verified = ($user->user['verified']) ? Date::now() : null;

            $foundUser = User::create([
                'username' => $user->name.$user->user['discriminator'],
                'email' => $user->email,
                'email_verified_at' => $user->verified,
                'avatar' => $avatar,
                'api_token' => Str::random(20),
            ]);

            if ($user->avatar != null) {
                $location = storage_path('app/public/avatars/'.strtolower($user->name.$user->user['discriminator']).".${extension}");
                InterImage::make($location)->resize(150, 150)->save($location);
                $foundUser->avatar = $avatar;
                $foundUser->save();
            }
        }

        Auth::login($foundUser, true);

        notify()->success('Login Successfully With Discord!');

        return redirect($this->redirectPath());
    }

    protected function authenticated(Request $request)
    {
        notify()->success('Login Successfully!');

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

        notify()->success('Logout Successfully!');

        return Redirect::route('home');
    }
}
