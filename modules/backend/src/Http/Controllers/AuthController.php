<?php namespace Hourglass\Backend\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/backend';

    public function showBackendLoginForm()
    {
        return view('Backend::backend.login');
    }

    public function backendLogin(Request $request)
    {
        // Try logging the user in
        $loginResponse = $this->login($request);

        $user = Auth::user();
        if ($user && !$user->can('backend.access')) {
            return $this->sendUnauthorizedForBackendResponse($request);
        }

        return $loginResponse;
    }

    protected function sendUnauthorizedForBackendResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => Lang::get('auth.failed'),
            ]);
    }
}