<?php

namespace App\Http\Controllers;

use App\Models\StoreSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class StoreSettingsController extends Controller
{
    /**
     * Atualiza as configurações da loja.
     */
    public function update(Request $request)
    {
        // Valida os campos do formulário
        $request->validate([
            'subdomain' => 'required|string|max:255|unique:store_settings,subdomain,' . Auth::user()->storeSettings->id,
            // Adicione outros campos que você quer validar
        ]);

        // Pega as configurações da loja associada ao usuário autenticado
        $storeSettings = Auth::user()->storeSettings;

        // Atualiza os dados
        $storeSettings->update([
            'subdomain' => $request->input('subdomain'),
            // Atualize outros campos que você precisa
        ]);

        // Redireciona para a página de edição com uma mensagem de sucesso
        return Redirect::route('profile.edit')->with('success', 'Configurações da loja atualizadas com sucesso!');
    }
}
