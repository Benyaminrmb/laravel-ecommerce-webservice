<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthenticateRequest;
use App\Http\Requests\Auth\SetPasswordRequest;
use App\Http\Requests\Auth\VerifyCodeRequest;
use App\Models\User;
use App\Models\UserEntry;
use App\Notifications\UserAuthenticateNotification;
use App\Services\EmailVerifyService;
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

        $fetchUser = UserService::fetch($entry);

        if (!$fetchUser) {
            $user = UserService::create($entry);
            $user->notify(new UserAuthenticateNotification($user->latestEntry()));

            return $this->jsonResponse(data: $user, statusCode: ResponseAlias::HTTP_CREATED);
        }
        /*
        * check user provided password already.
        */
        if (UserService::hasPassword($fetchUser)) {
            $password = $request->get('password');
            $validator = Validator::make(['password' => $password], [
                'password' => [
                    'required',
                ],
            ]);
            if ($validator->fails()) {
                return $this->jsonResponse(false, $validator->errors(), ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
            }

            if (UserService::checkPassword($fetchUser, $password)) {
                $token = UserService::createToken($fetchUser);

                return $this->jsonResponse(true, [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ]);
            }

            return $this->jsonResponse(false, __('auth.failed'), ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $fetchUser->notify(new UserAuthenticateNotification($fetchUser->latestEntry()));

        return $this->jsonResponse(data: __('auth.verificationCodeSentToEmail'));
    }

    public function verify(VerifyCodeRequest $request)
    {
        $user = UserService::findById($request->user_id);
        if (UserService::isEntryVerified($user->latestEntry())) {
//            todo login user at this point
            return $this->jsonResponse(success: false, data: __('auth.alreadyVerified'), statusCode: ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!EmailVerifyService::checkCodeIsValid($user, $request->code)) {
            return $this->jsonResponse(false, __('auth.verificationExpired'), ResponseAlias::HTTP_FORBIDDEN);
        }

        UserService::verifyUser($user);
        UserService::verifyEntry($user->latestEntry());

        return $this->jsonResponse(data: $user, statusCode: ResponseAlias::HTTP_ACCEPTED);
    }

    public function setPassword(SetPasswordRequest $request, int $id)
    {
        if (!$user = UserService::findById($id)) {
            return $this->jsonResponse(success: false, statusCode: ResponseAlias::HTTP_NOT_FOUND);
        }

        UserService::updateUser($user, ['password' => bcrypt($request->password)]);

        return $this->jsonResponse(success: true, data: __('auth.passwordHasBeenSet'), statusCode: ResponseAlias::HTTP_OK);
    }
}
