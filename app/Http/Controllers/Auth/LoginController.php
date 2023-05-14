<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        // parameter status loign
        $credentials['is_active'] = env('IS_ACTIVE_TRUE');

        return Auth::attempt($credentials, $request->filled('remember'));
    
    }

    protected function authenticated(Request $request, $user)
    {
       return $this->redirectToBasedOnRole($user);
    }

    private function redirectToBasedOnRole($user)
    {
        if(Auth::check()) {
            if ($user->hasRole(['superadmin', 'admin'])) {
                return redirect()->route('adm.dashboard');
            } elseif ($user->hasRole('user')) {
                return redirect()->route('user.absen');
            } 
        }
        return redirect('/login');
    }

}
