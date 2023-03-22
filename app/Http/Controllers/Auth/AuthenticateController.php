<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthenticateRequest;
use App\Http\Requests\Auth\SetPasswordRequest;
use App\Http\Requests\Auth\VerifyCodeRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserEntry;
use App\Notifications\UserAuthenticateNotification;
use App\Services\EmailVerifyService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
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

        //create user
        if (!$fetchUser) {
            $user = UserService::create($entry);
            $user->notify(new UserAuthenticateNotification($user->latestEntry()));
            return $this->loginUser($user, __('auth.createdAndSendVerification'));
        }

        //login user

        //no password
        if (!UserService::hasPassword($fetchUser)) {
            $fetchUser->notify(new UserAuthenticateNotification($fetchUser->latestEntry));
            return $this->loginUser($fetchUser, __('auth.verificationCodeSentToEmail'));
        }

        //has password
        $password = $request->get('password');
        $validator = Validator::make(['password' => $password], [
            'password' => [
                'required',
            ],
        ]);
        if ($validator->fails()) {
            return $this->jsonResponse(success: false, data: $validator->errors(), statusCode: ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (UserService::checkPassword($fetchUser, $password)) {
            return $this->loginUser($fetchUser);
        }

        return $this->jsonResponse(success: false, data: __('auth.failed'), statusCode: ResponseAlias::HTTP_UNAUTHORIZED);
//            todo i need to create a token and check that very token in $this->verify method.



    }

    public function loginUser(User $user, $message = null): \Illuminate\Http\JsonResponse
    {
        $user->token = $user->createToken('Token Name')->accessToken;
        return $this->jsonResponse(data: UserResource::make($user), message: $message, statusCode: ResponseAlias::HTTP_ACCEPTED);
    }

    public function verify(VerifyCodeRequest $request)
    {
        $user = UserService::findById($request->user_id);
        if (UserService::isEntryVerified($user->latestEntry)) {
//            todo login user at this point
            return $this->jsonResponse(success: false, data: __('auth.alreadyVerified'), statusCode: ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!EmailVerifyService::checkCodeIsValid($user, $request->code)) {
            return $this->jsonResponse(false, __('auth.verificationExpired'), ResponseAlias::HTTP_FORBIDDEN);
        }

        UserService::verifyUser($user);
        UserService::verifyEntry($user->latestEntry);

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
