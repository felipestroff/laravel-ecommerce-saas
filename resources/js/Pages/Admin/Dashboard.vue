<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Painel Administrativo" />

    <AdminLayout>
        <!-- Header do Painel Administrativo -->
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Painel Administrativo
            </h2>
        </template>

        <!-- Conteúdo Principal -->
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Card de Lojas Cadastradas -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            <Link href="/admin/stores">
                                <div class="bg-white shadow-md rounded-lg p-4">
                                    <h5 class="font-bold text-gray-700">Lojas Cadastradas</h5>
                                    <p class="text-gray-500">{{ storeCount }} lojas</p>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script>
    export default {
        props: {
            storeCount: Number,  // Propriedade que traz a contagem de lojas
        },
    };
</script>
