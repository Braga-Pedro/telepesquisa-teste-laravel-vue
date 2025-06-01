<!-- eslint-disable -->
<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps({
    empresas: Array,
    segmentos: Array
})

const page = usePage()
const flash = computed(() => page.props.flash)

const segmento_options = computed(() => {
    if (!props.segmentos || props.segmentos.length === 0) {
        return [{ id: 0, nome: 'Outro' }]
    }
    return [{ id: 0, nome: 'Outro' }, ...props.segmentos]
})

const showAlert = ref(true)

const form = useForm({
    nome: '',
    cep: '',
    rua: '',
    numero_casa: '',
    bairro: '',
    estado: '',
    telefone: '',
    cpf_cnpj: '',
    segmento_id: null,
    segmento: ''
})

const submit = () => {
    convertSeguimentoIdToNull()
    form.post(route('empresas.store'), {
        onSuccess: () => {
            resetForm()
            handleAlert()
        },
        onError: () => {
            console.error('Erro ao criar empresa: ', form.errors)
            handleAlert()
        }
    })
}

const resetForm = () => {
    form.reset()
}

const convertSeguimentoIdToNull = () => {
    if (form.segmento_id === 0) {
        form.segmento_id = null
    }
}

const handleGetEndereco = async () => {
    if (form.cep.length !== 8 && form.cep.length !== 0) {
      console.error('CEP com formato errado!');
      return;
    }

    try {
      const response = await fetch(`https://viacep.com.br/ws/${form.cep}/json/`);
      const data = await response.json();

      form.rua = data.logradouro;
      form.bairro = data.bairro;
      form.estado = data.uf;
    } catch (error) {
      console.error('Erro ao buscar o CEP:', error);
    }
}

const handleAlert = () => {
    if (flash.value && flash.value.message) {
        showAlert.value = true
        setTimeout(() => showAlert.value = false, 4000)
    }
}
</script>

<template>
    <Head title="Cadastro de Empresas" />

    <GuestLayout>
        <div
            v-if="flash && flash.message && showAlert"
            :class="[
                'fixed top-4 right-4 z-50 px-6 py-4 rounded shadow-lg text-white transition-all',
                flash.type === 'success' ? 'bg-green-600' : 'bg-red-600'
            ]"
        >
            {{ flash.message }}
        </div>

        <div>
            <h1
                class="mb-4 text-2xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Sistema de Cadastro de Empresas
            </h1>
        </div>

        <form @submit.prevent="submit" class="space-y-4">

            <div>
                <InputLabel for="nome" value="Nome" />

                <TextInput
                    id="nome"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.nome"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.nome" />
            </div>


            <div>
                <InputLabel value="CEP" />

                <TextInput
                    id="cep"
                    type="text"
                    pattern="\d*"
                    inputmode="numeric"
                    maxlength="8"
                    class="mt-1 block w-full"
                    v-model="form.cep"
                    required
                    autofocus
                    @blur="handleGetEndereco"
                />

                <InputError class="mt-2" :message="form.errors.cep" />
            </div>

            <div>
                <InputLabel value="Rua" />

                <TextInput
                    id="rua"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.rua"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.rua" />
            </div>

            <div>
                <InputLabel value="Número da Casa" />

                <TextInput
                    id="numero_casa"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.numero_casa"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.numero_casa" />
            </div>

            <div>
                <InputLabel value="Bairro" />

                <TextInput
                    id="bairro"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.bairro"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.bairro" />
            </div>

            <div>
                <InputLabel value="Estado (sigla)" />

                <TextInput
                    id="estado"
                    type="text"
                    maxlength="2"
                    class="mt-1 block w-full"
                    v-model="form.estado"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.estado" />
            </div>

            <div>
                <InputLabel value="Telefone (whatsapp)" />

                <TextInput
                    id="telefone"
                    type="text"
                    pattern="\d*"
                    inputmode="numeric"
                    maxlength="13"
                    class="mt-1 block w-full"
                    v-model="form.telefone"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.telefone" />
            </div>

            <div>
                <InputLabel value="CNPJ ou CPF" />

                <TextInput
                    id="cpf_cnpj"
                    type="text"
                    pattern="\d*"
                    inputmode="numeric"
                    maxlength="14"
                    class="mt-1 block w-full"
                    v-model="form.cpf_cnpj"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.cpf_cnpj" />
            </div>

            <div>
                <InputLabel value="Segmento" />

                <select id="segmento_id" v-model="form.segmento_id" class="mt-1 block w-full border rounded p-2">
                    <option v-for="segmento in segmento_options" :key="segmento.id" :value="segmento.id">
                        {{ segmento.nome }}
                    </option>
                </select>

                <p v-if="form.errors.segmento_id" class="text-red-500 text-sm">{{ form.errors.segmento_id }}</p>
            </div>

            <div v-if="form.segmento_id === 0">
                <InputLabel value="Novo Segmento" />

                <TextInput
                    id="segmento"
                    type="text"
                    class="mt-1 block w-full p-2 bg-gray-800 text-white"
                    v-model="form.segmento"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.segmento" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <DangerButton @click="resetForm">
                    Limpar
                </DangerButton>

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
