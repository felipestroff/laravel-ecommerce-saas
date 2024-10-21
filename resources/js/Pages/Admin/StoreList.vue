<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faEye, faEdit, faTrash, faToggleOn, faToggleOff } from '@fortawesome/free-solid-svg-icons';
</script>

<template>
    <Head title="Lojas" />

    <AdminLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
            Lojas
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Botão de Cadastrar Loja -->
                        <div class="flex justify-end mb-6">
                            <Link href="/admin/stores/create">
                                <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    Cadastrar Loja
                                </button>
                            </Link>
                        </div>

                        <!-- Verifica se há lojas cadastradas -->
                        <div v-if="stores.data && stores.data.length > 0">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsável</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loja</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data de Criação</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <!-- Itera sobre stores.data -->
                                    <tr v-for="(store, index) in stores.data" :key="store?.id" :class="{'bg-red-100': !store.is_active, 'bg-white': store.is_active}">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ store?.name || 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ store?.email || 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <!-- Nome da Loja -->
                                            <span class="font-bold block">
                                                {{ store?.store_settings?.name ?? 'N/A' }}
                                            </span>

                                            <!-- Badge para o Subdomínio (posicionado acima) -->
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-1">
                                                {{ store?.store_settings?.subdomain ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ store?.created_at ? new Date(store.created_at).toLocaleDateString() : 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-4">
                                            <!-- Ícone de Ver -->
                                            <Link :href="`/admin/stores/${store?.id}`" title="Detalhes da Loja" class="text-indigo-600 hover:text-indigo-900">
                                                <FontAwesomeIcon :icon="faEye" class="mr-2"/>
                                            </Link>

                                            <!-- Ícone de Editar -->
                                            <Link :href="`/admin/stores/${store?.id}/edit`" title="Editar Loja" class="text-yellow-600 hover:text-yellow-800">
                                                <FontAwesomeIcon :icon="faEdit" class="mr-2" /> <!-- Certifique-se de importar o ícone faEdit -->
                                            </Link>

                                            <!-- Ícone de Excluir -->
                                            <!--<button @click="deleteStore(store?.id)" title="Excluir Loja" class="ml-4 text-red-600 hover:text-red-900">
                                                <FontAwesomeIcon :icon="faTrash" class="mr-2"/>
                                            </button>-->

                                            <!-- Botão de ativar/inativar loja -->
                                            <button @click="toggleStoreStatus(store?.id)" class="ml-4 text-green-600 hover:text-green-900">
                                                <FontAwesomeIcon :icon="store.is_active ? faToggleOn : faToggleOff" class="mr-2"/>
                                                {{ store.is_active ? 'Desativar' : 'Ativar' }}
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Paginação -->
                            <div class="mt-4">
                                <ul class="pagination">
                                    <li v-if="stores.prev_page_url">
                                        <Link :href="stores.prev_page_url" class="btn">Anterior</Link>
                                    </li>
                                    <li v-if="stores.next_page_url">
                                        <Link :href="stores.next_page_url" class="btn">Próximo</Link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Caso não haja lojas -->
                        <div v-else class="flex justify-center items-center">
                            <p class="text-gray-500 text-center">Nenhuma loja cadastrada.</p>
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
        stores: {
            type: Object,  // Modificado para aceitar o objeto de paginação
            required: true,
        },
    },
    methods: {
        toggleStoreStatus(id) {
            Inertia.patch(`/admin/stores/${id}/toggleStatus`);
        },
        deleteStore(id) {
            if (confirm('Tem certeza que deseja excluir essa loja?')) {
                Inertia.delete(`/admin/stores/${id}`);
            }
        },
    },
};
</script>
