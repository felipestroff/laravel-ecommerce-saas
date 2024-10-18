<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const { props } = usePage();
const baseUrl = props.baseUrl;  // Obtém a URL base passada do Laravel

const form = useForm({
    name: props.auth.user.store_settings?.name,
    subdomain: props.auth.user.store_settings?.subdomain,
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
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Informações da sua Loja
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Atualize as informações da sua loja.
            </p>
        </header>

        <form
            @submit.prevent="form.patch(route('store.update'))"
            class="mt-6 space-y-6"
        >
            <div>
                <InputLabel for="name" value="Nome" />

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
                <PrimaryButton :disabled="form.processing">Salvar</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        Salvo.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
