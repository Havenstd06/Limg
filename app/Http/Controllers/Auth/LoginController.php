<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
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

        if (!$foundUser) {
            $url = $user->avatar . "?size=256";
            $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
            $contents = file_get_contents($url);
            $name = 'avatars/' . strtolower($user->name . $user->user['discriminator']) . ".${extension}";
            Storage::disk('public')->put($name, $contents);
            $avatar = $name;

            $foundUser = User::create([
                'username' => $user->name . $user->user['discriminator'],
                'email' => $user->email,
                'avatar' => $avatar,
            ]);
            
            $location = storage_path('app/public/avatars/' . strtolower($user->name . $user->user['discriminator']) . ".${extension}");
            InterImage::make($location)->resize(150, 150)->save($location);
            $foundUser->avatar = $avatar;
            $foundUser->save();
        }

        Auth::login($foundUser, true);

        connectify('success', 'Success!', 'Login Successfully With Discord!');
        
        return redirect($this->redirectPath());

    }

    protected function authenticated(Request $request, $user)
    {
        connectify('success', 'Success!', 'Login Successfully!');
        
        return Redirect::route('home');
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
}
