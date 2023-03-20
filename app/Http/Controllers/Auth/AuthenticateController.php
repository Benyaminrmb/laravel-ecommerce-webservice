<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthenticateRequest;
use App\Models\Role;
use App\Models\User;
use App\Notifications\UserAuthenticateNotification;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthenticateController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function authenticate(AuthenticateRequest $request)
    {
        $entry = $request->only(['email', 'phone_number']);

        $fetchUser = UserService::fetchUser($entry);

        if (!$fetchUser) {
            $user = UserService::createNewUser($entry);
            $user->notify(new UserAuthenticateNotification());
            return $this->jsonResponse(data: $user, statusCode: ResponseAlias::HTTP_CREATED);
        }
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
                return $this->jsonResponse(false, $validator->errors(), ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
            }

            if (UserService::checkUserCredentials($entry, $password)) {
                $token = UserService::createToken($fetchUser);

                return $this->jsonResponse(true, [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ]);
            }
            return $this->jsonResponse(false, __('auth.failed'), ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $fetchUser->notify(new UserAuthenticateNotification());
        return $this->jsonResponse(data: __('auth.verificationCodeSentToEmail'));
    }

    public function verify(User $user, Request $request)
    {
        if (UserService::isUserVerified($user)) {
            return $this->jsonResponse(success: false, data: __('auth.alreadyVerified'), statusCode: ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!$request->hasValidSignature()) {
            return $this->jsonResponse(false, __('auth.verificationExpired'), ResponseAlias::HTTP_FORBIDDEN);
        }

        UserService::updateUser($user, [
            'email_verified_at' => $user->freshTimestamp(),
            'role_id' => Role::where('name', \App\Enums\Role::VERIFIED_USER->value)->first()->id,
        ]);

        return $this->jsonResponse(data: $user, statusCode: ResponseAlias::HTTP_ACCEPTED);
    }

}
