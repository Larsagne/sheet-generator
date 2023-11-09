<script setup>
import {ExclamationCircleIcon} from "@heroicons/vue/20/solid";

const props = defineProps({
    name: String,
    label: String,
    error: String,
    type: {
        type: String,
        default: "text"
    },
    placeholder: String,
    modelValue: String,
})


defineEmits(['update:modelValue'])
</script>

<template>
    <div class="sm:col-span-12">
        <label :for="name" class="block text-sm font-medium leading-6 text-gray-900">{{ __(label) }}</label>
        <div class="mt-1 relative">
            <input
                   :name="name"
                   :id="name"
                   :value="modelValue"
                   :placeholder="placeholder"
                   :type="type"
                   @input="$emit('update:modelValue', $event.target.value)"
                   class="block w-full rounded-md shadow-sm sm:text-sm"
                   :class="error ? 'text-red-900 ring-1 ring-inset border-0 ring-red-300 placeholder:text-red-300 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500'"
                   :aria-invalid="error"
                   :aria-describedby="error ? 'title-error' : 'title'"
            />
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3" v-if="error">
                <ExclamationCircleIcon class="h-5 w-5 text-red-500" aria-hidden="true" />
            </div>
        </div>
        <p class="mt-2 text-sm text-red-600" id="title-error" v-if="error">{{ error }}</p>

        <div>
            <div class="relative mt-2 rounded-md shadow-sm">

            </div>
        </div>
    </div>
</template>
