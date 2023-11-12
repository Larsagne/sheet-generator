<script setup>
import {ChevronDownIcon, ChevronUpIcon} from "@heroicons/vue/20/solid";
import {ref} from "vue";
import Modal from "@/Components/Modal.vue";
import EditPart from "@/Pages/Sheet/Partials/Edit/EditPart.vue";
import MutedButton from "@/Components/Form/MutedButton.vue";
import DangerButton from "@/Components/Form/DangerButton.vue";
import __ from "@/lang";

const props = defineProps({
    parts: Array,
    showCloseDismissModal: Boolean,
    time_signature: String|null
});
defineEmits([
    'closeCloseDismissModal',
    'redirectBack'
]);

// ToDo: Change to Vue is() method (https://vuejs.org/guide/essentials/component-basics.html#dynamic-components)
const currentPart = ref(null);

function getChordSequence(sequence) {
    return sequence.measures.map(measure => measure.chords).join(" ");
}

function movePartUp(key) {
    if (props.parts[key - 1] === undefined) {
        return;
    }

    const temp = props.parts[key];
    props.parts[key] = props.parts[key - 1];
    props.parts[key - 1] = temp;
}

function movePartDown(key) {
    if (props.parts[key + 1] === undefined) {
        return;
    }

    const temp = props.parts[key];
    props.parts[key] = props.parts[key + 1];
    props.parts[key + 1] = temp;
}

function deletePart(key) {
    props.parts.splice(key, 1);
}

function copyPart(part) {
    let copiedPart = JSON.parse(JSON.stringify(part));
    copiedPart.name = copiedPart.name + ' - ' +  __('general.copy_noun');
    props.parts.push(copiedPart);
}

function addPart() {
    props.parts.push({
        sequences: [getNewSequence()],
        name: 'Part ' + (props.parts.length + 1),
        description: '',
    });

    openPart(props.parts.length - 1);
}
function getNewSequence() {
    return {
        'measures': [getNewMeasure()],
        'quantity': 1
    };
}
function getNewMeasure() {
    return {
        'chords': '',
        'time_signature': props.time_signature
    };
}
function openPart(partKey) {
    currentPart.value = partKey;
}

</script>

<template>

    <h3 class="text-3xl text-gray-800 font-bold mb-2">{{ __('sheet.parts') }}</h3>
    <p class="mb-4">{{ __('sheet.parts_description') }}</p>
    <div class="overflow-hidden bg-white shadow sm:rounded-md">

        <ul role="list" class="divide-y divide-gray-200">
            <li v-for="(part, partKey) in parts" :key="part.id">
                <div class="block hover:bg-gray-50">
                    <div class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <p class="truncate text-sm font-medium text-indigo-600 cursor-pointer"
                               @click="openPart(partKey)">{{ part.name }}</p>
                            <div class="ml-2 flex flex-shrink-0">
                                <span
                                    class="cursor-pointer text-gray-800 border border-gray-300 inline-flex px-1 text-xs font-semibold leading-5 hover:bg-gray-600 hover:border-gray-600 hover:text-white"
                                    @click="movePartDown(partKey)">
                                    <ChevronDownIcon class="h-4 w-4"></ChevronDownIcon>
                                </span>
                                <span
                                    class="cursor-pointer text-gray-800 border border-gray-300 inline-flex px-1 text-xs font-semibold leading-5 hover:bg-gray-600 hover:border-gray-600 hover:text-white"
                                    @click="movePartUp(partKey)">
                                        <ChevronUpIcon class="h-4 w-4"></ChevronUpIcon>
                                </span>
                                <span
                                    class="cursor-pointer text-green text-green-800 bg-green-100 inline-flex px-2 text-xs font-semibold leading-5 hover:text-white hover:bg-green-700"
                                    @click="copyPart(part)">
                                        {{ __('general.copy') }}
                                </span>
                                <span
                                    class="cursor-pointer text-red-800 bg-red-100 inline-flex px-2 text-xs font-semibold leading-5 hover:text-white hover:bg-red-700"
                                    @click="deletePart(partKey)">
                                        {{ __('general.delete') }}
                                </span>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <p class="flex items-center text-sm text-gray-500"
                                   v-html='part.description ? part.description.replaceAll("\n", "<br />", part.description) : ""'></p>

                                <div v-for="sequence in part.sequences" :key="sequence.id">
                                    <div v-if="sequence.description" class=" text-sm text-gray-500">
                                        <span class="mr-1 italic">{{ sequence.position + 1 }}. Akkordfolge</span>
                                        <span
                                            v-html='sequence.description.replaceAll("\n", "<br />", sequence.description)'></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-1">
                                <div v-for="sequence in part.sequences" :key="sequence.id">
                                    <p class="flex items-center text-sm text-gray-500">
                                        <strong class="mr-1">{{ sequence.quantity }}x:</strong>
                                        <span>{{ getChordSequence(sequence) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <div class="flex justify-center mt-4">
        <MutedButton @click="addPart">{{ __('sheet.add_part') }}</MutedButton>
    </div>

    <Modal
        max-width="7xl"
        :show="currentPart !== null"
        @close="currentPart = null"
    >
        <EditPart
            v-if="parts[currentPart]"
            :part="parts[currentPart]"
            :previous-part="parts[currentPart - 1] ?? null"
            :next-part="parts[currentPart + 1] ?? null"
            :get-new-sequence="getNewSequence"
            @add-part="addPart"
            @move-to-previous-part="currentPart--"
            @move-to-next-part="currentPart++"
            @close-part="currentPart = null"
        />
    </Modal>

    <Modal
        @close="$emit('closeCloseDismissModal')"
        :show="showCloseDismissModal"
        max-width="lg"
        title="sheet.unsaved_changes"
    >
        <p class="text-sm text-gray-500">{{ __('sheet.confirm_dismiss') }}</p>
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
            <DangerButton @click="$emit('redirectBack')" class="ml-2">{{ __('general.dismiss') }}</DangerButton>
            <MutedButton @click="$emit('closeCloseDismissModal')" ref="cancelButtonRef">{{ __('general.cancel') }}</MutedButton>
        </div>
    </Modal>
</template>
