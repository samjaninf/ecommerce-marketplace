<?php namespace Koolbeans\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Koolbeans\Http\Controllers\Controller;
use Koolbeans\User;
use Validator;
use Koolbeans\Http\Controllers\Auth\URL;
use Illuminate\Contracts\Auth\Guard;
class AuthController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers {
        AuthenticatesAndRegistersUsers::postRegister as private _postRegister;
    }

    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illumina|te\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    public function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    public function authenticate(Request $request, Guard $auth)
    {
        if ($auth->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
                    echo '<pre>';
        var_dump(\Session());
        echo '</pre>';
            // Authentication passed...
            return 'cunt';
        }
    }

    /**
     * @return User
     */
    protected function getUser()
    {
        return current_user();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $redirection = $this->_postRegister($request);

        \Mail::send('emails.registration', ['user' => current_user()], function (Message $m) use ($request) {
            $m->to($request->input('email'), $request->input('name'))
              ->subject('Thank you for registering to Koolbeans!');
        });

        return $redirection;
    }
}
