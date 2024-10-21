<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Requests\CategoryStoreRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        // Mostra as categorias pertencentes ao usuário autenticado (store)
        $categories = Category::where('user_id', Auth::id())->get();
        return Inertia::render('Store/Categories', [
            'categories' => $categories
        ]);
    }

    public function store(CategoryStoreRequest $request)
    {
        // Cria a categoria para a loja autenticada
        Category::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('store.categories.index')->with('success', 'Categoria criada com sucesso!');
    }

    public function update(CategoryStoreRequest $request, Category $category)
    {
        // Atualiza a categoria
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('store.categories.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $category = Category::where('user_id', Auth::id())->findOrFail($id);
        $category->delete();

        return redirect()->route('store.categories.index')->with('success', 'Categoria excluída com sucesso!');
    }
}
