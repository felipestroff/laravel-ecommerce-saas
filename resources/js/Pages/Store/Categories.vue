<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import StoreLayout from '@/Layouts/StoreLayout.vue';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faPlusCircle, faPencil, faTrash, faListAlt, faSearch, faTimesCircle } from '@fortawesome/free-solid-svg-icons';
import { ref, computed, nextTick } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const { categories } = defineProps({
    categories: {
        type: Array,
        required: true,
    },
});

const editingCategory = ref(null);
const searchQuery = ref(""); // Campo de pesquisa

const categoryNameInput = ref(null);

// Modal de Adicionar/Editar Categoria
const showCategoryModal = ref(false);

const openCategoryModal = () => {
    resetForm(); // Reseta o formulário para garantir que não está em modo de edição
    showCategoryModal.value = true;

    // Após o modal ser exibido, define o foco no campo de nome da categoria
    nextTick(() => {
        if (categoryNameInput.value) {
            categoryNameInput.value.focus();
        }
    });
};

// Formulário de criação de categoria
const form = useForm({
    name: '',
});

// Modal de confirmação de exclusão
const showDeleteModal = ref(false);
const categoryToDelete = ref(null);

// Função para enviar o formulário de criação/edição
const submitCategory = () => {
    if (editingCategory.value) {
        form.put(route('store.categories.update', editingCategory.value.id), {
            onSuccess: () => {
                form.reset();
                editingCategory.value = null;
                showCategoryModal.value = false;
            },
        });
    }
    else {
        form.post(route('store.categories.store'), {
            onSuccess: () => {
                form.reset();
                showCategoryModal.value = false;
            },
        });
    }
};

const editCategory = (category) => {
    editingCategory.value = category;
    form.name = category.name;
    showCategoryModal.value = true; // Abrir modal para editar

    // Após o modal ser exibido, define o foco no campo de nome da categoria
    nextTick(() => {
        if (categoryNameInput.value) {
            categoryNameInput.value.focus();
        }
    });
};

const resetForm = () => {
    form.reset();
    editingCategory.value = null;
};

// Função para mostrar o modal de confirmação de exclusão
const confirmDelete = (category) => {
    categoryToDelete.value = category;
    showDeleteModal.value = true;
};

// Função para fechar o modal e excluir a categoria
const deleteCategory = () => {
    if (categoryToDelete.value) {
        Inertia.delete(route('store.categories.destroy', categoryToDelete.value.id), {
            onSuccess: () => {
                showDeleteModal.value = false;
                categoryToDelete.value = null;
            },
        });
    }
};

// Computed property para filtrar categorias
const filteredCategories = computed(() => {
    if (searchQuery.value === "") {
        return categories;
    }
    return categories.filter(category =>
        category.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

// Função para limpar a pesquisa
const clearSearch = () => {
    searchQuery.value = "";
};
</script>

<template>
    <Head title="Categorias" />

    <!-- Modal de Adicionar/Editar Categoria -->
    <Modal :show="showCategoryModal" @close="showCategoryModal = false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ editingCategory ? 'Editar Categoria' : 'Adicionar Nova Categoria' }}
            </h2>
            <form @submit.prevent="submitCategory" class="space-y-6 mt-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Nome da Categoria
                    </label>
                    <input
                        v-model="form.name"
                        ref="categoryNameInput"
                        type="text"
                        class="mt-1 block w-full border-gray-300 rounded-md p-2"
                        placeholder="Digite o nome da categoria"
                        required
                    >
                    <InputError :message="form.errors.name" class="mt-2 text-red-600" />
                </div>
                <div class="flex space-x-4">
                    <PrimaryButton type="submit" class="bg-green-500 hover:bg-green-600">
                        {{ editingCategory ? 'Atualizar Categoria' : 'Criar Categoria' }}
                    </PrimaryButton>
                    <PrimaryButton @click="showCategoryModal = false" class="bg-gray-500 hover:bg-gray-600">
                        Cancelar
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>

    <!-- Modal de Confirmação de Exclusão -->
    <Modal :show="showDeleteModal" @close="showDeleteModal = false">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Confirmar Exclusão
            </h2>
            <p class="mt-4 text-sm text-gray-600">
                Tem certeza de que deseja excluir a categoria "{{ categoryToDelete?.name }}"? Esta ação não pode ser desfeita.
            </p>
            <div class="mt-6 flex justify-end">
                <PrimaryButton @click="deleteCategory" class="bg-red-500 hover:bg-red-600 focus:hover:bg-red-600">
                    Sim, Excluir
                </PrimaryButton>
                <PrimaryButton @click="showDeleteModal = false" class="ml-2 bg-gray-500 hover:bg-gray-600">
                    Cancelar
                </PrimaryButton>
            </div>
        </div>
    </Modal>

    <StoreLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Categorias
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Botão de Adicionar Categoria -->
                <div class="bg-white shadow-md sm:rounded-lg p-6">
                    <div class="flex justify-between items-center">
                        <!-- Texto sobre as categorias -->
                        <div>
                            <span v-if="categories.length === 0">Não existem categorias cadastradas.</span>
                            <span v-else>{{ categories.length }} categorias cadastradas.</span>
                        </div>

                        <!-- Botão de adicionar categoria -->
                        <button
                            @click="openCategoryModal"
                            class="bg-green-500 text-white px-4 py-2 rounded-md flex items-center"
                        >
                            <FontAwesomeIcon :icon="faPlusCircle" class="mr-2" /> Adicionar Categoria
                        </button>
                    </div>
                </div>

                <!-- Seção de pesquisa de categorias -->
                <div v-if="categories && categories.length > 0" class="bg-white shadow-md sm:rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-700">
                            <FontAwesomeIcon :icon="faSearch" class="mr-2 text-blue-600" />
                            Pesquisar Categorias
                        </h3>
                    </div>
                    <div>
                        <div class="relative flex items-center">
                            <input
                                v-model="searchQuery"
                                type="text"
                                class="mt-1 block w-full border-gray-300 rounded-md p-2"
                                placeholder="Digite o nome da categoria para pesquisar"
                            />
                            <!-- Botão de Limpar Pesquisa -->
                            <button v-if="searchQuery" @click="clearSearch" class="absolute right-2 text-gray-400 hover:text-gray-600">
                                <FontAwesomeIcon :icon="faTimesCircle" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Lista de categorias cadastradas -->
                <div v-if="categories && categories.length > 0" class="bg-white shadow-md sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-700 mb-4">
                        <FontAwesomeIcon :icon="faListAlt" class="mr-2 text-blue-600" />
                        Categorias Cadastradas
                    </h3>
                    <ul class="mt-4 space-y-2">
                        <li v-for="category in filteredCategories" :key="category.id" class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                            <span class="text-gray-800">{{ category.name }}</span>
                            <div class="flex space-x-4">
                                <button @click="editCategory(category)" class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 flex items-center">
                                    <FontAwesomeIcon :icon="faPencil" class="mr-2" /> Editar
                                </button>
                                <button @click="confirmDelete(category)" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 flex items-center">
                                    <FontAwesomeIcon :icon="faTrash" class="mr-2" /> Excluir
                                </button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </StoreLayout>
</template>
