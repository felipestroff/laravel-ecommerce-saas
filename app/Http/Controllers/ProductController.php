<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        // Obtém os produtos da loja logada (user_id)
        $products = Product::where('user_id', Auth::id())->orderBy('order')->get();

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        // Obtém as categorias da loja para o formulário de produto
        $categories = Category::where('user_id', Auth::id())->get();

        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        // Valida os dados da requisição
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'order' => 'nullable|integer',
            'active' => 'boolean',
        ]);

        // Cria o produto para o usuário logado (loja)
        Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'order' => $validated['order'] ?? 0,
            'active' => $validated['active'] ?? true,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        // Obtém as categorias da loja para o formulário de edição
        $categories = Category::where('user_id', Auth::id())->get();

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        // Valida os dados da requisição
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'order' => 'nullable|integer',
            'active' => 'boolean',
        ]);

        // Atualiza o produto
        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        // Deleta o produto
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    /**
     * Reorder products by changing their order value.
     */
    public function reorder(Request $request)
    {
        $orderData = $request->input('order');

        foreach ($orderData as $id => $order) {
            Product::where('id', $id)->update(['order' => $order]);
        }

        return response()->json(['success' => true]);
    }
}
