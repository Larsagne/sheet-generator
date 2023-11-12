<script setup>
import {ExclamationCircleIcon} from "@heroicons/vue/20/solid";

const props = defineProps({
    name: String,
    label: String,
    error: String,
    rows: {
        type: String,
        default: "4"
    },
    type: {
        type: String,
        default: "text"
    },
    disabled: {
        type: Boolean,
        default: false
    },
    modelValue: String,
})


defineEmits(['update:modelValue'])
</script>

<template>
    <div class="sm:col-span-12">
        <label :for="name" class="block text-sm font-medium leading-6 text-gray-700">{{ __(label) }}</label>
        <div class="relative">

            <textarea
                :name="name"
                :id="name"
                :value="modelValue"
                :rows="rows"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm disabled:opacity-50"
               :class="error ? 'text-red-900 ring-1 ring-inset border-0 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'"
               :aria-invalid="error"
               :aria-describedby="error ? 'title-error' : 'title'"
               :disabled="disabled"
               @input="$emit('update:modelValue', $event.target.value)"
            />

            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3" v-if="error">
                <ExclamationCircleIcon class="h-5 w-5 text-red-500" aria-hidden="true" />
            </div>
        </div>
        <p class="mt-2 text-sm text-red-600" id="title-error" v-if="error">{{ error }}</p>
    </div>
</template>
