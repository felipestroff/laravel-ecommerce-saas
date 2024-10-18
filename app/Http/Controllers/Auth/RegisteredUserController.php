<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        return Inertia::render('Auth/Register', [
            'baseUrl' => config('app.url'),
        ]);
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
            'store_name' => 'required|string|unique:store_settings,name',
            'subdomain' => 'required|string|unique:store_settings,subdomain',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Salvar o subdomínio associado à loja
        $user->storeSettings()->create([
            'name' => $request->store_name,
            'subdomain' => $request->subdomain,
        ]);

        //event(new Registered($user));

        //Auth::login($user);

        //return redirect(route('dashboard', absolute: false));

        return redirect()->route('welcome')->with('success', 'Cadastro realizado com sucesso! Seu cadastro será analisado e você receberá um e-mail em breve.');
    }
}
