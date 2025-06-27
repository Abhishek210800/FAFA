<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
     * Show the registration form with available roles.
     */
    public function create(): View
    {
        $roles = DB::table('roles')->get(); // Fetch roles without a Role model
        return view('auth.register', compact('roles'));
    }

    /**
     * Handle user registration and login.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'integer', 'exists:roles,id'], 
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return $this->redirectToRoleDashboard($user);
    }

    /**
     * Redirect to appropriate dashboard based on role.
     */
   protected function redirectToRoleDashboard(User $user): RedirectResponse
{
    switch ($user->role_id) {
        case 1:
            return redirect()->route('admin.dashboard');
        case 2:
        case 3:
        case 4:
            return redirect()->route('register.new');
        default:
            return redirect('/login');
    }
}


}
