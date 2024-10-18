<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Detalhes do Usuário" />

    <AdminLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
            Detalhes do Usuário
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Informações do Responsável
                            </h2>
                        </header>

                        <div class="card mt-6 space-y-6">
                            <div class="card-body">
                                <p><strong>Nome:</strong> {{ store.name }}</p>
                                <p><strong>Email:</strong> {{ store.email }}</p>
                                <p><strong>Status:</strong> {{ store.is_active ? 'Ativa' : 'Inativa' }}</p>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Informações da Loja
                            </h2>
                        </header>

                        <div class="card mt-6 space-y-6">
                            <div class="card-body">
                                <p><strong>Nome:</strong> {{ store.store_settings?.name ?? 'N/A' }}</p>
                                <p><strong>Subdomínio:</strong> {{ store.store_settings?.subdomain ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Categorias
                            </h2>
                        </header>

                        <div class="card mt-6 space-y-6">
                            <div class="card-body">
                                <ul v-if="store.categories && store.categories.length > 0" class="list-group mt-3">
                                    <li v-for="category in store.categories" :key="category.id" class="list-group-item">
                                        {{ category.name }}
                                    </li>
                                </ul>
                                <p v-else class="text-gray-500">Nenhuma categoria cadastrada.</p>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Produtos
                            </h2>
                        </header>

                        <div class="card mt-6 space-y-6">
                            <div class="card-body">
                                <ul v-if="store.products && store.products.length > 0" class="list-group mt-3">
                                    <li v-for="product in store.products" :key="product.id" class="list-group-item">
                                        {{ product.name }} - R$ {{ product.price.toFixed(2).replace('.', ',') }}
                                    </li>
                                </ul>
                                <p v-else class="text-gray-500">Nenhum produto cadastrado.</p>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script>
  import AdminLayout from '@/Layouts/AdminLayout.vue';

  export default {
    props: {
        store: Object,
    },
    components: {
        AdminLayout,
    },
  };
</script>
