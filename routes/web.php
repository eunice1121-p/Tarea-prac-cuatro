<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use App\Http\Controllers\PalindromeController;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/fanid', function () {
    return view('auth.fanid');
})->name('fanid');

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', function (Request $request) {
        return view('profile.edit', ['user' => $request->user()]);
    })->name('profile.edit');

    Route::put('/profile', function (Request $request) {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'handle' => ['nullable', 'string', 'max:30', Rule::unique('users', 'handle')->ignore($user)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'bio' => ['nullable', 'string', 'max:280'],
            'city' => ['nullable', 'string', 'max:100'],
        ]);

        $user->update($validated);

        return redirect()->route('profile.edit')->with('status', 'Perfil actualizado.');
    })->name('profile.update');
});

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    return back()
        ->withErrors(['email' => 'El correo electrónico o la contraseña no son correctos.'])
        ->onlyInput('email');
})->name('login.store');

Route::get('/', function () {
    return view('palindrome');
});

Route::post('/api/check-palindrome', [PalindromeController::class, 'check']);
