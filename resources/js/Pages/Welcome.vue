<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';

const { props } = usePage();
let successMessage = ref(props.success); // Obter a mensagem flash, se houver

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}

const closeModal = () => {
    successMessage.value = null;
};
</script>

<template>
    <Head title="Bem-vindo" />

    <!-- Exibe uma modal de sucesso quando a loja se cadastrar com sucesso -->
    <Modal :show="successMessage" @close="closeModal">
        <div class="p-6">
            <h2
                class="text-lg font-medium text-gray-900"
            >
                {{ successMessage }}
            </h2>

            <div class="mt-6 flex justify-end">
                <PrimaryButton @click="closeModal">
                    Ok
                </PrimaryButton>
            </div>
        </div>
    </Modal>

    <!-- Background -->
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen">
        <!-- Navbar -->
        <nav class="bg-white dark:bg-gray-800 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div class="text-xl font-bold text-indigo-600 dark:text-indigo-400">E-commerce SaaS</div>
                <div class="space-x-4">
                    <Link href="#features" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600">Recursos</Link>
                    <Link href="#pricing" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600">Preços</Link>
                    <Link href="/login" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600" v-if="canLogin">Login</Link>
                    <Link href="/register" class="bg-indigo-600 text-white px-4 py-2 rounded-md" v-if="canRegister">Cadastre-se</Link>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative bg-white dark:bg-gray-800 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white">Construa sua loja online com facilidade</h1>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">Nossa plataforma oferece todas as ferramentas para gerenciar e expandir seu negócio online.</p>
                <div class="mt-6">
                    <Link href="/register" class="bg-indigo-600 text-white px-6 py-3 rounded-md">Comece Agora</Link>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="bg-gray-100 dark:bg-gray-800 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Recursos da Plataforma</h2>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">Tudo que você precisa para administrar sua loja online.</p>
                <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Gerenciamento de Produtos</h3>
                        <p class="mt-4 text-gray-600 dark:text-gray-300">Adicione, edite e organize seus produtos com facilidade.</p>
                    </div>
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Análise de Vendas</h3>
                        <p class="mt-4 text-gray-600 dark:text-gray-300">Acompanhe suas vendas e tenha insights poderosos sobre o desempenho da sua loja.</p>
                    </div>
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Customização de Loja</h3>
                        <p class="mt-4 text-gray-600 dark:text-gray-300">Personalize sua loja online para atender às suas necessidades.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="pricing" class="bg-white dark:bg-gray-900 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Escolha seu plano</h2>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">Preços flexíveis para atender ao seu negócio.</p>
                <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Plano Básico</h3>
                        <p class="mt-4 text-gray-600 dark:text-gray-300">Ideal para iniciantes.</p>
                        <p class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">R$/mês</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Plano Profissional</h3>
                        <p class="mt-4 text-gray-600 dark:text-gray-300">Para lojas em crescimento.</p>
                        <p class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">R$/mês</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Plano Premium</h3>
                        <p class="mt-4 text-gray-600 dark:text-gray-300">Para empresas estabelecidas.</p>
                        <p class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">R$/mês</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-800 py-8 text-center text-white">
            <p>&copy; 2024 E-commerce. Todos os direitos reservados.</p>
            <p>Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})</p>
        </footer>
    </div>
</template>
