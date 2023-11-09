<script setup>
import { useForm } from 'laravel-precognition-vue-inertia';
import Modal from "@/Components/Modal.vue";
import {ExclamationCircleIcon} from '@heroicons/vue/20/solid'
import Input from "@/Components/Form/Input.vue";

const props = defineProps({
    sheets: Object,
    show: Boolean
})

defineEmits(['close'])

const form = useForm('post', route('sheets.store'), {
    title: null
})


</script>

<template>
    <Modal @close="$emit('close')" :show="show" max-width="lg" title="sheet.create">
        <form @submit.prevent="form.submit">
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-12">
                <Input name="title" v-model="form.title" @input="form.validate('title')" :error="form.errors.title" />
<!--                <div class="sm:col-span-12">-->
<!--                    <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Titel</label>-->
<!--                    <div class="mt-1">-->
<!--                        <input type="text" name="title" v-model="form.title"-->
<!--                               @input="form.validate('title')"-->
<!--                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"/>-->
<!--                        <input-->
<!--                            type="text"-->
<!--                            name="title"-->
<!--                            id="title"-->
<!--                            class="block w-full rounded-md border-0 py-1.5 pr-10 text-red-900 ring-1 ring-inset ring-red-300 placeholder:text-red-300 focus:ring-2 focus:ring-inset focus:ring-red-500 sm:text-sm sm:leading-6"-->
<!--                            placeholder="Let It Be"-->
<!--                            :aria-invalid="form.invalid('title')"-->
<!--                            aria-describedby="title-error"-->
<!--                        />-->
<!--                    </div>-->
<!--                </div>-->

<!--                <div>-->
<!--                    <div class="relative mt-2 rounded-md shadow-sm">-->
<!--                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3" v-if="form.invalid('title')">-->
<!--                            <ExclamationCircleIcon class="h-5 w-5 text-red-500" aria-hidden="true" />-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <p class="mt-2 text-sm text-red-600" id="title-error" v-if="form.invalid('title')">{{ form.errors.title }}</p>-->
<!--                </div>-->

                <div class="sm:col-span-12">
                    <button type="submit"
                            @click="save"
                            :disabled="form.processing || !form.title || form.hasErrors"
                            class="justify-end disabled:opacity-25 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Sheet erstellen
                    </button>
                </div>
            </div>
        </form>
    </Modal>
</template>
