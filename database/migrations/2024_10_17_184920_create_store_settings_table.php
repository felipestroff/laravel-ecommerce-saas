<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relacionamento com a loja (usuário)
            $table->string('name');
            $table->string('subdomain')->unique(); // Subdomínio único para cada loja
            $table->string('logo')->nullable(); // Caminho para o logotipo da loja
            $table->text('description')->nullable(); // Descrição da loja
            $table->string('main_categories')->nullable(); // Principais categorias da loja (opcional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_settings');
    }
};
