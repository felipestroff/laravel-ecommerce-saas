<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const { props } = usePage();
const baseUrl = props.baseUrl;  // Obtém a URL base passada do Laravel

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    store_name: '',
    subdomain: '',
});

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

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Cadastra sua Loja" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Seu Nome" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Senha" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirme a Senha" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="mt-4">
                <InputLabel for="store_name" value="Nome da sua Loja" />

                <TextInput
                    id="store_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.store_name"
                    required
                    autocomplete="store_name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="subdomain" value="Subdomínio da Loja" />

                <TextInput
                    id="subdomain"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.subdomain"
                    required
                    autocomplete="off"
                />

                <!-- Tooltip -->
                <p class="text-sm text-gray-500">
                    A loja será acessível em: {{ storeUrl }}
                </p>

                <InputError class="mt-2" :message="form.errors.subdomain" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Já cadastrado?
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Cadastrar
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
