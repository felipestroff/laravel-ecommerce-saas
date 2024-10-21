<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, watch, onMounted } from 'vue';

// Obtenha as props da página, incluindo dados da loja se estiver no modo de edição
const { props } = usePage();
const baseUrl = props.baseUrl;  // Obtém a URL base passada do Laravel
const storeData = props.store || {};  // Dados da loja no modo de edição (vazio no cadastro)

const isEditing = storeData.id !== undefined;  // Verifica se está no modo de edição

// Inicializa o formulário com dados para cadastro ou edição
const form = useForm({
    name: storeData.name || '',
    email: storeData.email || '',
    password: '',
    password_confirmation: '',
    store_name: storeData?.store_settings?.name || '',
    subdomain: storeData?.store_settings?.subdomain || '',
});

const passwordInput = ref(null);

// Função para enviar o formulário (diferente para cadastro e edição)
const submitStore = () => {
    const url = isEditing ? `/admin/stores/${storeData.id}` : '/admin/stores';
    const method = isEditing ? 'patch' : 'post';

    form[method](url, {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
        },
    });
};

// Função para gerar a URL da loja
const storeUrl = ref(`${baseUrl}/minha-loja`);

watch(() => form.subdomain, (newValue) => {
    if (newValue) {
        // Se o valor não estiver vazio, formata a URL
        const formattedStorePath = newValue.toLowerCase().replace(/\s+/g, '-');
        storeUrl.value = `${baseUrl}/${formattedStorePath}`;
        form.subdomain = formattedStorePath;
    }
    else {
        // Se estiver vazio, atualiza somente a URL, sem modificar form.subdomain
        storeUrl.value = `${baseUrl}/minha-loja`;
    }
});

// No modo de edição, preenche os dados no formulário
onMounted(() => {
    if (isEditing) {
        form.name = storeData.name;
        form.email = storeData.email;
        form.store_name = storeData?.store_settings?.name;
        form.subdomain = storeData?.store_settings?.subdomain;
        storeUrl.value = `${baseUrl}/${storeData?.store_settings?.subdomain}`;
    }
});
</script>

<template>
    <Head :title="isEditing ? 'Editar Loja' : 'Cadastrar Nova Loja'" />

    <AdminLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ isEditing ? 'Editar Loja' : 'Cadastrar Loja' }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <form @submit.prevent="submitStore" class="mt-6 space-y-6">
                        <div>
                            <InputLabel for="name" value="Responsável" />

                            <TextInput
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                                autocomplete="off"
                                :autofocus="!isEditing"
                                required
                            />

                            <InputError :message="form.errors.name" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="email" value="Email" />

                            <TextInput
                                id="email"
                                v-model="form.email"
                                type="email"
                                class="mt-1 block w-full"
                                autocomplete="off"
                                required
                            />

                            <InputError :message="form.errors.email" class="mt-2" />
                        </div>

                        <div v-if="!isEditing">
                            <InputLabel for="password" value="Senha" />

                            <TextInput
                                id="password"
                                v-model="form.password"
                                type="password"
                                class="mt-1 block w-full"
                                autocomplete="new-password"
                                ref="passwordInput"
                                required
                            />

                            <InputError :message="form.errors.password" class="mt-2" />
                        </div>

                        <div v-if="!isEditing">
                            <InputLabel for="password_confirmation" value="Confirme a Senha" />

                            <TextInput
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                class="mt-1 block w-full"
                                autocomplete="new-password"
                                required
                            />

                            <InputError :message="form.errors.password_confirmation" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="store_name" value="Nome da Loja" />

                            <TextInput
                                id="store_name"
                                v-model="form.store_name"
                                type="text"
                                class="mt-1 block w-full"
                                autocomplete="off"
                                required
                            />

                            <InputError :message="form.errors.store_name" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="subdomain" value="Subdomínio da Loja" />

                            <!-- Campo de Subdomínio com Tooltip -->
                            <div class="relative">
                                <TextInput id="subdomain" v-model="form.subdomain" type="text" class="mt-1 block w-full" autocomplete="off" required />

                                <!-- Tooltip -->
                                <p class="text-sm text-gray-500">
                                    A loja será acessível em: {{ storeUrl }}
                                </p>
                            </div>

                            <InputError :message="form.errors.subdomain" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing">
                                {{ isEditing ? 'Salvar Alterações' : 'Cadastrar Loja' }}
                            </PrimaryButton>

                            <Transition
                                enter-active-class="transition ease-in-out"
                                enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out"
                                leave-to-class="opacity-0"
                            >
                                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                                    {{ isEditing ? 'Loja atualizada com sucesso!' : 'Loja cadastrada com sucesso!' }}
                                </p>
                            </Transition>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
