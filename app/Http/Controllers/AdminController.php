<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $storeCount = User::where('role', 'store')->count();
        return Inertia::render('Admin/Dashboard', ['storeCount' => $storeCount]);
    }

    public function listStores()
    {
        $stores = User::with('storeSettings')->where('role', 'store')->paginate(10);
        return Inertia::render('Admin/StoreList', ['stores' => $stores]);
    }

    public function showStore($id)
    {
        $store = User::with(['storeSettings', 'categories', 'products'])->findOrFail($id);
        return Inertia::render('Admin/StoreShow', ['store' => $store]);
    }

    /**
     * Exibe o formulário para cadastrar uma nova loja.
     */
    public function createStore()
    {
        return Inertia::render('Admin/CreateStore', [
            'baseUrl' => config('app.url'),  // Passando a URL base a partir da configuração do Laravel
        ]);
    }

    /**
     * Armazena uma nova loja no banco de dados.
     */
    public function store(Request $request)
    {
        // Validação do formulário
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'store_name' => 'required|string|max:255',
            'subdomain' => 'required|string|unique:store_settings,subdomain',
        ]);

        // Criação do usuário e da loja
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),  // Encrypt the password
            'role' => 'store',  // Define o papel como 'store',
            'is_active' => true, // A loja ja é cadastrada como ativa
        ]);

        // Associa as configurações da loja ao usuário criado
        $user->storeSettings()->create([
            'name' => $request->store_name,
            'subdomain' => $request->subdomain,
        ]);

        return redirect()->route('admin.stores')->with('success', 'Loja cadastrada com sucesso!');
    }

    public function editStore($id)
    {
        // Carrega a loja e suas configurações
        $store = User::with('storeSettings')->where('role', 'store')->findOrFail($id);

        return Inertia::render('Admin/CreateStore', [
            'store' => $store,
            'baseUrl' => config('app.url'),  // Passando a URL base
        ]);
    }

    public function updateStore(Request $request, $id)
    {
        $store = User::where('role', 'store')->findOrFail($id);

        // Validação dos dados enviados
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $store->id,  // Permite o mesmo e-mail para o próprio usuário
            'store_name' => 'required|string|max:255',
            'subdomain' => 'required|string|unique:store_settings,subdomain,' . $store->storeSettings->id,  // Permite o mesmo subdomínio para a própria loja
        ]);

        // Atualização dos dados do usuário (responsável pela loja)
        $store->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Atualização das configurações da loja
        $store->storeSettings->update([
            'name' => $request->store_name,
            'subdomain' => $request->subdomain,
        ]);

        return redirect()->route('admin.stores')->with('success', 'Loja atualizada com sucesso!');
    }

    public function toggleStoreStatus($id)
    {
        $store = User::findOrFail($id);
        $store->is_active = !$store->is_active;  // Toggle the active status
        $store->save();

        // Definir flash message
        $status = $store->is_active ? 'ativada' : 'desativada';
        return redirect()->route('admin.stores')->with('success', "Loja {$status} com sucesso!");
    }

    public function destroyStore($id)
    {
        $store = User::where('role', 'store')->findOrFail($id);
        $store->delete();

        return redirect()->route('admin.stores')->with('success', 'Loja excluída com sucesso!');
    }
}
