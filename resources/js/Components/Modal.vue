<script setup>
import { computed, onMounted, onUnmounted, watch } from 'vue';
import {Dialog, DialogDescription, DialogPanel, DialogTitle, TransitionChild, TransitionRoot} from "@headlessui/vue";

// ToDo: Scrolling bar should be forced

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    title: {
        type: String,
        default: null
    }
});

const emit = defineEmits(['close']);

watch(
    () => props.show,
    () => {
        if (props.show) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = null;
        }
    }
);

const close = () => {
    if (props.closeable) {
        emit('close');
    }
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = null;
});

const maxWidthClass = computed(() => {
    return {
        sm: 'sm:max-w-sm',
        md: 'sm:max-w-md',
        lg: 'sm:max-w-lg',
        xl: 'sm:max-w-xl',
        '2xl': 'sm:max-w-2xl',
        '3xl': 'sm:max-w-3xl',
        '4xl': 'sm:max-w-4xl',
        '5xl': 'sm:max-w-5xl',
        '6xl': 'sm:max-w-6xl',
        '7xl': 'sm:max-w-7xl',
        '8xl': 'sm:max-w-8xl',
    }[props.maxWidth];
});
</script>

<template>
    <teleport to="body">
        <TransitionRoot as="template" :show="show">
            <Dialog as="div" class="relative z-10" @close="close">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0"
                                 enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100"
                                 leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"/>
                </TransitionChild>

                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center text-center sm:items-center sm:p-0">
                        <TransitionChild as="template" enter="ease-out duration-300"
                                         enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                         enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                                         leave-from="opacity-100 translate-y-0 sm:scale-100"
                                         leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                            <DialogPanel
                                class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:p-6 w-full"
                                :class="maxWidthClass"
                            >
                                <DialogTitle v-if="show && title" class="text-xl">{{ __(title) }}</DialogTitle>
                                <DialogDescription class="pt-4">
                                    <slot v-if="show" />
                                </DialogDescription>

                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </teleport>
</template>
