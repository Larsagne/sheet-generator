<script setup>
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot} from "@headlessui/vue";
import {
    ClipboardDocumentIcon,
    DocumentDuplicateIcon,
    ExclamationTriangleIcon,
    MinusCircleIcon,
    XMarkIcon
} from "@heroicons/vue/24/outline";
import {ChevronDownIcon, ChevronUpIcon, PlusIcon} from "@heroicons/vue/20/solid";
import Input from "@/Components/Form/Input.vue";
import {ref} from "vue";
import Modal from "@/Components/Modal.vue";

const props = defineProps({
    parts: Array,
    showCloseDismissModal: Boolean,
    time_signature: String|null
});
const emits = defineEmits([
    'closeCloseDismissModal',
    'redirectBack'
]);

// ToDo: Change to Vue is() method (https://vuejs.org/guide/essentials/component-basics.html#dynamic-components)
const currentPart = ref(null);
const copiedSequence = ref(null);
const refs = ref({});

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
    copiedPart.name = copiedPart.name + ' - Kopie';
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

function addSequence(partKey) {
    props.parts[partKey]['sequences'].push(getNewSequence());
}

function removeSequence(partKey, sequenceKey) {
    props.parts[partKey]['sequences'].splice(sequenceKey, 1);
}

function copySequence(partKey, sequenceKey) {
    props.copiedSequence = JSON.parse(JSON.stringify(props.parts[partKey]['sequences'][sequenceKey]));
}

function pasteSequence(partKey, sequenceKey) {
    props.parts[partKey]['sequences'][sequenceKey] = copiedSequence.value;
}

function openPart(partKey) {
    currentPart.value = partKey;
}

function addMeasure(partKey, sequenceKey) {
    props.parts[partKey]['sequences'][sequenceKey]['measures'].push(getNewMeasure());
}

function removeMeasure(partKey, sequenceKey, measureKey) {
    props.parts[partKey]['sequences'][sequenceKey]['measures'].splice(measureKey, 1);
}

function getNewMeasure() {
    return {
        'chords': '',
        'time_signature': props.time_signature
    };
}

function chordSpace(event, partKey, sequenceKey, measureKey) {
    let chordString = props.parts[partKey]['sequences'][sequenceKey]['measures'][measureKey]['chords'];
    const lastChar = chordString.slice(-1);
    props.parts[partKey]['sequences'][sequenceKey]['measures'][measureKey]['chords'] = chordString.replaceAll(' ', '');

    if (lastChar !== ' ') {
        return;
    }

    props.parts[partKey]['sequences'][sequenceKey]['measures'][measureKey]['chords'] = chordString.slice(0, -1);

    let isLastChord = props.parts[partKey]['sequences'][sequenceKey]['measures'][measureKey + 1] === undefined;

    if (isLastChord) {
        addMeasure(partKey, sequenceKey);
    }

    // ToDo: Refactor (maybe nextTick?)
    setTimeout(function () {
        focusMeasure(partKey, sequenceKey, measureKey + 1);
    }, 10);
}

function chordLeft(event, partKey, sequenceKey, measureKey) {
    if (event.target.selectionStart === 0) {
        setTimeout(function () {
            focusMeasure(partKey, sequenceKey, measureKey - 1, true)
        }, 10);
    }
}

function chordRight(event, partKey, sequenceKey, measureKey) {
    if (event.target.selectionStart === props.parts[partKey]['sequences'][sequenceKey]['measures'][measureKey]['chords'].length) {
        setTimeout(function () {
            focusMeasure(partKey, sequenceKey, measureKey + 1)
        }, 10);
    }
}

function chordDelete(event, partKey, sequenceKey, measureKey) {
    if (event.target.value !== '') {
        return;
    }

    // Focus last element
    setTimeout(function () {
        removeMeasure(partKey, sequenceKey, measureKey);
        focusMeasure(partKey, sequenceKey, measureKey - 1, true)
    });
}

function getRefName(partKey, sequenceKey, measureKey) {
    return 'measure-' + partKey + '-' + sequenceKey + '-' + measureKey;
}

function focusMeasure(partKey, sequenceKey, measureKey, setToEnd = false) {
    let refName = getRefName(partKey, sequenceKey, measureKey);
    let measure = refs.value[refName] ?? null;

    if (!measure) {
        return;
    }
    measure.focus();

    if (setToEnd) {
        measure.selectionEnd = measure.value.length;
        measure.selectionStart = measure.value.length;
    } else {
        measure.selectionEnd = 0;
        measure.selectionStart = 0;
    }
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
                                        Kopieren
                                    </span>
                                <span
                                    class="cursor-pointer text-red-800 bg-red-100 inline-flex px-2 text-xs font-semibold leading-5 hover:text-white hover:bg-red-700"
                                    @click="deletePart(partKey)">
                                        Löschen
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
        <button type="button"
                @click="addPart"
                class="inline-flex items-center rounded-md border border-gray-400 px-4 py-2 text-base font-medium text-gray-700 shadow-sm  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 hover:bg-gray-600 hover:border-gray-600 hover:text-white"
        >
            Part hinzufügen
        </button>
    </div>

    <TransitionRoot as="template" :show="currentPart !== null">
        <Dialog as="div" class="relative z-10" @close="currentPart = null">
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
                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-7xl sm:p-6">
                            <div v-if="parts[currentPart]">

                                <div>
                                    <div class="grid lg:grid-cols-12 mt-8 divide-x">
                                        <div class="lg:pr-4 col-span-5">
                                            <h3 class="text-2xl text-gray-800 font-bold mb-2">Part bearbeiten</h3>
                                            <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing
                                                elit. Adipisci aperiam doloribus eos, fugit modi nobis quos sed
                                                ullam veritatis voluptate. Ab debitis pariatur placeat recusandae
                                                veritatis? Amet nemo quia ut.</p>
                                            <div class="mb-4">
                                                <label for="name"
                                                       class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                                <div>
                                                    <input type="text" name="name"
                                                           v-model="parts[currentPart].name"
                                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"/>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label for="description"
                                                       class="block text-sm font-medium text-gray-700 mb-1">Beschreibung</label>
                                                <textarea rows="4" name="description"
                                                          v-model="parts[currentPart].description"
                                                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"/>
                                            </div>
                                            <div>
                                                <label for="lyrics"
                                                       class="block text-sm font-medium text-gray-700 mb-1">Lyrics</label>
                                                <textarea rows="4" name="lyrics"
                                                          v-model="parts[currentPart].lyrics"
                                                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"/>
                                            </div>
                                        </div>
                                        <div class="lg:pl-4 col-span-7">
                                            <h3 class="font-bold text-2xl mb-2">Akkordfolgen</h3>
                                            <div
                                                v-for="(sequence, sequenceKey) in parts[currentPart].sequences"
                                                :key="sequence.id"
                                                class="border border-0 p-3 border-gray-300"
                                                :class="{
                                                        'pt-6': parts[currentPart].sequences[sequenceKey - 1] !== undefined,
                                                        // 'border-t-2': parts[currentPart].sequences[sequenceKey - 1] !== undefined,
                                                        'pb-6': parts[currentPart].sequences[sequenceKey + 1] !== undefined,
                                                        // 'border-b-2': parts[currentPart].sequences[sequenceKey + 1] !== undefined,
                                                        'bg-gray-50': sequenceKey % 2 === 0,
                                                        'bg-gray-200': sequenceKey % 2 === 1,
                                                    }"
                                            >
                                                <div class="flex mb-4">
                                                    <div class="flex-none ">
                                                        <div class="flex justify-end text-xs leading-none">
                                                            <div
                                                                class="text-indigo-500 border-2 border-transparent border-b-0 flex-none leading-none">
                                                                <input type="text"
                                                                       class="w-6 p-0 inline text-right leading-none border-0 bg-transparent border-transparent focus:border-transparent focus:ring-0 text-xs"
                                                                       style="visibility: hidden">
                                                            </div>
                                                        </div>
                                                        <div class="border border-2 border-indigo-200 relative">
                                                            <input type="number"
                                                                   class="w-16 block border-0 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm pr-1"
                                                                   v-model="sequence.quantity"/>
                                                            <div
                                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-6">
                                                                    <span class="text-gray-500 sm:text-sm"
                                                                          id="price-currency">
                                                                        <XMarkIcon class="h-4 w-4" aria-hidden="true"/>
                                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex-1">
                                                        <div class="flex">
                                                            <div v-for="(measure, measureKey) in sequence.measures"
                                                                 :key="measureKey" class="w-full">
                                                                <div>
                                                                    <div
                                                                        class="flex justify-end text-xs leading-none">
                                                                        <div
                                                                            class="text-indigo-500 border-2 border-indigo-200 border-b-0 flex-none leading-none">
                                                                            <input type="text"
                                                                                   class="w-8 p-0 inline leading-none border-0 bg-transparent border-transparent focus:border-transparent focus:ring-0 text-xs text-center"
                                                                                   v-model="measure.time_signature">
                                                                        </div>
                                                                    </div>

                                                                    <div
                                                                        class="border-indigo-200 focus:border-indigo-500 focus:ring-indigo-500 border-2 border-l-0">
                                                                        <input type="text"
                                                                               class="block w-full border-0 sm:text-sm"
                                                                               v-model="measure.chords"
                                                                               :ref="(el) => {refs[getRefName(currentPart, sequenceKey, measureKey)] = el}"
                                                                               @keyup.space="event => chordSpace(event, currentPart, sequenceKey, measureKey)"
                                                                               @keydown.left="event => chordLeft(event, currentPart, sequenceKey, measureKey)"
                                                                               @keydown.right="event => chordRight(event, currentPart, sequenceKey, measureKey)"
                                                                               @keydown.delete="event => chordDelete(event, currentPart, sequenceKey, measureKey)"
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-end mb-1">
                                                        <button type="button"
                                                                @click="copySequence(currentPart, sequenceKey)"
                                                                class="inline-flex items-center rounded-md bg-indigo-50 text-indigo-700 hover:text-white hover:bg-indigo-700 border-none px-1 py-1 ml-1 text-sm font-medium leading-4 text-gray-700 shadow-sm">
                                                            <DocumentDuplicateIcon class="h-5 w-5"
                                                                                   aria-hidden="true"/>
                                                        </button>
                                                        <button type="button"
                                                                @click="pasteSequence(currentPart, sequenceKey)"
                                                                class="inline-flex items-center rounded-md bg-indigo-50 text-indigo-700 hover:text-white hover:bg-indigo-700 border-none px-1 py-1 ml-1 text-sm font-medium leading-4 text-gray-700 shadow-sm">
                                                            <ClipboardDocumentIcon class="h-5 w-5"
                                                                                   aria-hidden="true"/>
                                                        </button>
                                                        <button type="button"
                                                                @click="removeSequence(currentPart, sequenceKey)"
                                                                class="inline-flex items-center rounded-md border  px-1 py-1 ml-1 text-sm font-medium leading-4 border-none text-red-600 bg-red-200 shadow-sm hover:bg-red-600 hover:text-white">
                                                            <MinusCircleIcon class="h-5 w-5" aria-hidden="true"/>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="grid grid-cols-2 gap-4">
                                                        <div class="col-span-1">
                                                            <label for="lyrics"
                                                                   class="block text-sm font-medium text-gray-700 mb-1">Beschreibung</label>
                                                            <textarea rows="2" name="lyrics"
                                                                      v-model="sequence.description"
                                                                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"/>
                                                        </div>
                                                        <div class="col-span-1">
                                                            <div
                                                                class="flex rounded-md border-2 border-dashed border-gray-300 w-full pt-5 pb-6">
                                                                <div class="text-center flex justify-center w-full">
                                                                    <div class="mr-4">
                                                                        <svg class="mx-auto h-8 w-12 text-gray-400"
                                                                             stroke="currentColor" fill="none"
                                                                             viewBox="0 0 48 48" aria-hidden="true">
                                                                            <path
                                                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                                                stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"/>
                                                                        </svg>
                                                                    </div>
                                                                    <div>
                                                                        <div
                                                                            class="flex text-sm text-gray-600 justify-center">
                                                                            <label for="file-upload"
                                                                                   class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
                                                                                <span>Upload a file</span>
                                                                                <input id="file-upload"
                                                                                       name="file-upload"
                                                                                       type="file"
                                                                                       class="sr-only"/>
                                                                            </label>
                                                                            <p class="pl-1">or drag and drop</p>
                                                                        </div>
                                                                        <p class="text-xs text-gray-500">PNG, JPG,
                                                                            GIF
                                                                            up to 10MB</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="relative mt-8">
                                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                                    <div class="w-full border-t border-gray-300"/>
                                                </div>
                                                <div class="relative flex justify-center">
                                                    <button type="button"
                                                            @click="addSequence(currentPart)"
                                                            class="inline-flex items-center rounded-full border border-gray-300 bg-white px-4 py-1.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                        <PlusIcon class="-ml-1.5 mr-1 h-5 w-5 text-gray-400"
                                                                  aria-hidden="true"/>
                                                        <span>Akkordfolge hinzufügen</span>
                                                    </button>
                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                                <div class="mt-5 sm:mt-6 grid grid-cols-2">
                                    <div>
                                        <button type="button"
                                                v-if="parts[currentPart - 1] !== undefined"
                                                @click="currentPart = currentPart - 1"
                                                class="inline-flex items-center rounded-md border border-gray-400 px-4 py-2 font-medium text-gray-700 shadow-sm text-sm focus:outline-none hover:bg-gray-600 hover:border-gray-600 hover:text-white"
                                        >
                                            Letzter Part
                                        </button>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="button"
                                                @click="currentPart = null"
                                                class="inline-flex items-center rounded-md border border-gray-400 px-4 py-2 font-medium text-gray-700 shadow-sm text-sm focus:outline-none mr-2 hover:bg-gray-600 hover:border-gray-600 hover:text-white"
                                        >
                                            Schließen
                                        </button>
                                        <div>
                                            <button type="button"
                                                    v-if="parts[currentPart + 1] !== undefined"
                                                    @click="currentPart = currentPart + 1"
                                                    class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                Nächster Part
                                            </button>
                                            <button type="button"
                                                    v-else
                                                    @click="addPart"
                                                    class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                Part hinzufügen
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <Modal
        @close="$emit('closeCloseDismissModal')"
        :show="showCloseDismissModal"
        max-width="lg"
        title="sheet.unsaved_changes"
    >
        <p class="text-sm text-gray-500">{{ __('sheet.confirm_dismiss') }}</p>

        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
            <button type="button"
                    class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                    @click="$emit('redirectBack')">
                {{ __('general.dismiss') }}
            </button>
            <button type="button"
                    class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm"
                    @click="$emit('closeCloseDismissModal')" ref="cancelButtonRef">
                {{ __('general.cancel') }}
            </button>
        </div>
    </Modal>
</template>
