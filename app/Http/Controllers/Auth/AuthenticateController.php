<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthenticateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticateController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function authenticate(AuthenticateRequest $request)
    {
        $entry = $request->only(['email', 'phone_number']);
        $arrayEntry = UserService::getArrayEntry($entry);

        $userExistence = UserService::checkUserExists($entry);

        if ($userExistence) {
            $fetchUser = UserService::fetchUser($entry);
            /*
            * check user provided password already.
            */

            if (UserService::checkUserHasPassword($fetchUser)) {
                $password = $request->get('password');
                $validator = Validator::make(['password' => $password], [
                    'password' => [
                        'required',
                    ],
                ]);
                if ($validator->fails()) {
                    return $this->jsonResponse(false, $validator->errors(), 422);
                }

                $credentials = [
                    $arrayEntry['key'] => $arrayEntry['value'],
                    'password' => $password,
                ];

                if (Auth::attempt($credentials)) {
                    $token = Auth::user()->createToken('Token Name')->accessToken->token;

                    return $this->jsonResponse(true, [
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                    ]);
                }

                return $this->jsonResponse(false, __('auth.failed'), 401);
            }

            $fetchUser->notify(new UserAuthenticateNotification());

            return $this->jsonResponse(data:__('auth.verificationCodeSentToEmail'));
        }
        /*
        * Create user by given data.
        */
        $user = UserService::createNewUser($arrayEntry);

        return $this->jsonResponse(data: $user, statusCode: 201);
    }

    public function verify(User $user, Request $request)
    {
        if (! UserService::isUserVerified($user)) {
            if (! $request->hasValidSignature()) {
                return $this->jsonResponse(false, __('auth.verificationExpired'), 403);
            }

            $user->update([
                'email_verified_at' => $user->freshTimestamp(),
                'role_id' => Role::where('name', \App\Enums\Role::VERIFIED_USER->value)->first()->id,
            ]);
            $user->refresh();

            return $this->jsonResponse(data:$user, statusCode: 201);
        }

        return $this->jsonResponse(success:false, data:__('auth.alreadyVerified'), statusCode: 422);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
