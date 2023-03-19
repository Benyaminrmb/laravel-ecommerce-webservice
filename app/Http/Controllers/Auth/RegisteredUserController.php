<?php
//
//namespace App\Http\Controllers\Auth;
//
//use App\Enums\Role as EnumRole;
//use App\Http\Controllers\Controller;
//use App\Models\Role;
//use App\Models\User;
//use Illuminate\Http\JsonResponse;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;
//use Illuminate\Validation\Rules;
//
//class RegisteredUserController extends Controller
//{
//    /**
//     * Handle an incoming registration request.
//     *
//     * @throws \Illuminate\Validation\ValidationException
//     */
//    public function store(Request $request): JsonResponse
//    {
//        $request->validate([
//            'first_name' => ['required', 'string', 'max:255'],
//            'last_name' => ['string', 'max:255'],
//            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
//            'password' => ['required', Rules\Password::defaults()],
//        ]);
//
//        $role = Role::select('id')->where('name', EnumRole::UNVERIFIED_USER->value)->first();
//
//        $user = User::create([
//            'first_name' => $request->first_name,
//            'last_name' => $request?->last_name,
//            'email' => $request->email,
//            'role_id' => $role->id,
//            'password' => Hash::make($request->password),
//        ]);
//
//        return $this->jsonResponse(true, $user);
//    }
//}
