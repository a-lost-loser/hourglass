<?php

namespace Hourglass\Http\Controllers\Backend;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthorizationController extends Controller
{
    use ValidatesRequests;
    use RedirectsUsers;

    protected $loginFormView = 'Hourglass.Backend::login';

    /**
     * Path to redirect to when the user is logged in.
     * @var string
     */
    protected $redirectTo = 'backend';

    public function showLoginForm()
    {
        return view($this->loginFormView);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        $credentials = $this->credentials($request);

        if ($this->getGuard()->attempt($credentials, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        return redirect()->intended($this->redirectPath());
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Auth failed',
            ]);
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    }

    protected function credentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    /**
     * @return Guard
     */
    protected function getGuard()
    {
        return Auth::guard();
    }
}