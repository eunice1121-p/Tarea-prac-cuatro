<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Http\Controllers\PalindromeController;
use App\Models\User;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/fanid', function () {
    return view('auth.fanid');
})->name('fanid');

Route::post('/fanid', function (Request $request) {
    $favoriteDrivers = [
        'Max Verstappen',
        'Franco Colapinto',
        'Sergio Pérez',
        'Fernando Alonso',
        'Charles Leclerc',
        'Lando Norris',
    ];

    $validated = $request->validate([
        'nickname' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'country' => ['required', Rule::in(['mexico', 'argentina', 'colombia', 'chile'])],
        'favorite_drivers' => ['required', 'array', 'min:1'],
        'favorite_drivers.*' => ['required', 'string', Rule::in($favoriteDrivers)],
        'terms' => ['accepted'],
    ]);

    $user = User::create([
        'name' => $validated['nickname'],
        'email' => $validated['email'],
        'password' => $validated['password'],
        'country' => $validated['country'],
        'favorite_drivers' => $validated['favorite_drivers'],
    ]);

    Auth::login($user);
    $request->session()->regenerate();

    return redirect()->route('profile.edit')->with('status', 'Cuenta Paddock creada correctamente.');
})->name('fanid.store');

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
            'country' => ['required', Rule::in(['mexico', 'argentina', 'colombia', 'chile'])],
            'favorite_drivers' => ['required', 'array', 'min:1'],
            'favorite_drivers.*' => ['required', 'string', Rule::in([
                'Max Verstappen',
                'Franco Colapinto',
                'Sergio Pérez',
                'Fernando Alonso',
                'Charles Leclerc',
                'Lando Norris',
            ])],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $previousAvatar = $user->avatar_path;

        if ($request->hasFile('avatar')) {
            $validated['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        if (isset($validated['avatar_path']) && $previousAvatar) {
            Storage::disk('public')->delete($previousAvatar);
        }

        return redirect()->route('profile.edit')->with('status', 'Perfil actualizado.');
    })->name('profile.update');

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');
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
