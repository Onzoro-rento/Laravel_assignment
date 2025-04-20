<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('posts.index', absolute: false));
    }
    public function storeTemp(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        Session::put('register_data',$validated);
        
        return redirect(route('register.confirm', absolute: false));

    }
    public function showConfirm(): Response
    {
        $data = Session::get('register_data');

        if (!$data) {
            return redirect()->route('register')->withErrors(['error' => 'セッションが無効です。再度入力してください。']);
        }

        return Inertia::render('Auth/RegisterConfirm', [
            'userInput' => $data,
        ]);
    }
    public function finalRegister(Request $request): RedirectResponse
    {
        $data = Session::get('register_data');

        if (!$data) {
            return redirect()->route('register')->withErrors(['error' => 'セッションが無効です。再度入力してください。']);
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        event(new Registered($user));

        Auth::login($user);

        Session::forget('register_data');

        return redirect(route('posts.index', absolute: false));
    }
}
