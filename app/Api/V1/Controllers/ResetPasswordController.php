<?php

namespace App\Api\V1\Controllers;

use Config;
use App\User;
use JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Api\V1\Requests\ResetPasswordRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function resetPassword(ResetPasswordRequest $request, JWTAuth $JWTAuth)
    {
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->reset($user, $password);
            }
        );


        if($response !== Password::PASSWORD_RESET) {
            throw new HttpException(500);
        }

        if(!Config::get('boilerplate.reset_password.release_token')) {
            return response()->json([
                'status' => 'ok',
            ]);
        }

        $user = User::where('email', '=', $request->get('email'))->first();

        return response()->json([
            'status' => 'ok',
            'token' => $JWTAuth->fromUser($user)
        ]);
    }

    public function changesPassword(Request $request){
        //validate
        if ($request->password != $request->password_confirmation ) {
            throw new HttpException(500);
        }
        
        $user = JWTAuth::parseToken()->authenticate();

        if( Hash::check( $request->old_password , $user->password)){
            $message = 'Ok';
            $user->password = $request->password;
            $user->save();   
        }else{
            $message='Email or Password is wrong!';
        }

        return [
            '_meta' => [
                'message' => $message
            ],
            'data' => $user
        ];

    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  ResetPasswordRequest  $request
     * @return array
     */
    protected function credentials(ResetPasswordRequest $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function reset($user, $password)
    {
        $user->password = $password;
        $user->save();
    }
}
