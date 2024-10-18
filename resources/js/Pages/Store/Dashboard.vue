<script setup>
import StoreLayout from '@/Layouts/StoreLayout.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, usePage } from '@inertiajs/vue3';

// Obtém os dados do usuário a partir da página
const { props } = usePage();
const user = props.auth.user;

// Verifica se o usuário está inativo (is_active == false)
const isActive = user.is_active;

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
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        You're logged in!
                    </div>
                </div>
            </div>
        </div>
    </StoreLayout>
</template>
