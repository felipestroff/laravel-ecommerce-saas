<script setup>
import StoreLayout from '@/Layouts/StoreLayout.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faList } from '@fortawesome/free-solid-svg-icons';
import { computed } from 'vue';

// Obtém os dados do usuário a partir da página
const { props } = usePage();
const user = props.auth.user;

const { categoryCount } = defineProps({
    categoryCount: {
        type: Number,
        required: true,
    },
});

// Verifica se o usuário está inativo (is_active == false)
const isActive = computed(() => user.is_active);

// Função para fechar a modal e deslogar o usuário
const closeModal = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <Head title="Dashboard" />

    <!-- Exibe a modal caso o usuário esteja inativo -->
    <Modal :show="!isActive" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Cadastro Inativo
            </h2>
            <p class="mt-4 text-sm text-gray-600">
                Seu cadastro ainda está inativo. Aguarde a aprovação para poder acessar a plataforma. Você será deslogado ao fechar esta mensagem.
            </p>
            <div class="mt-6 flex justify-end">
                <PrimaryButton @click="closeModal">
                    Ok
                </PrimaryButton>
            </div>
        </div>
    </Modal>

    <StoreLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <!-- Conteúdo Principal -->
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Card de Categorias Cadastradas -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                            <Link href="/store/categories">
                                <div class="bg-white shadow-md rounded-lg p-4 flex items-center">
                                    <!-- Ícone de Categoria -->
                                    <FontAwesomeIcon :icon="faList" class="mr-2 text-gray-700" />
                                    <div>
                                        <h5 class="font-bold text-gray-700">Categorias Cadastradas</h5>
                                        <p class="text-gray-500">{{ categoryCount }} categorias</p>
                                    </div>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </StoreLayout>
</template>
