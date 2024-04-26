<?php

namespace App\Http\Controllers\Auth;

use App\Enums\IsUser;
use App\Enums\OAuth;
use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\LifeGauge;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'kana' => ['required', 'string', 'regex:/\A[ァ-ヴー]+\z/u', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'target_lifespan' => ['required', 'regex:/^[0-9]+$/i', 'between:0, 150'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'kana' => $request->kana,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'oauth' => OAuth::AppAuth->value,
                'status' => UserStatus::RegularMember->value,
            ]);

            $user->lifeGauges()->create([
                'user_id' => $user->id,
                'name' => $user->name,
                'date_of_birth' => $request->date_of_birth,
                'target_lifespan' => $request->target_lifespan,
                'is_user' => IsUser::User->value,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/register');
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
