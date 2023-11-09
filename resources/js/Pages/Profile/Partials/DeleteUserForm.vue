<script setup>
import DangerButton from '@/Components/Form/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/Form/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Input from "@/Components/Form/Input.vue";

const confirmingUserDeletion = ref(false);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">{{ __('profile.delete') }}</h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('profile.delete_description') }}
            </p>
        </header>

        <DangerButton @click="confirmUserDeletion">{{ __('profile.delete') }}</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal" max-width="lg">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('profile.delete_confirm') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('profile.delete_confirm_description') }}
            </p>

            <div class="mt-6">
                <Input
                    name="password"
                    v-model="form.password"
                    type="password"
                    :error="form.errors.password"
                />
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <DangerButton @click="deleteUser">
                    Delete Account
                </DangerButton>
            </div>
        </Modal>
    </section>
</template>
