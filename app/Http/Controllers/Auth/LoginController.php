<?php

namespace App\Http\Controllers\Auth;

use App\Events\PlayerLeftQueue;
use App\Http\Controllers\Controller;
use App\Notifications\UserAccountProgressUpdated;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function username()
    {
        return 'name';
    }

    public function logout()
    {
        $user = Auth::user();
        $user->removeFromQueue();
        broadcast(new PlayerLeftQueue($user));
        Auth::logout();
        flash('You have been logged out', 'success');
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }
}
