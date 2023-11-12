<script setup>
import Input from "@/Components/Form/Input.vue";
import {ClipboardDocumentIcon, DocumentDuplicateIcon, MinusCircleIcon, XMarkIcon} from "@heroicons/vue/24/outline";
import {PlusIcon} from "@heroicons/vue/20/solid";
import FileUpload from "@/Components/Form/FileUpload.vue";
import TextArea from "@/Components/Form/TextArea.vue";
import {ref} from "vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import MutedButton from "@/Components/Form/MutedButton.vue";

const copiedSequence = ref(null);
const refs = ref({});
const props = defineProps({
    part: Object,
    previousPart: Object | null,
    nextPart: Object | null,
    getNewSequence: Function
});

defineEmits([
    'moveToPreviousPart',
    'moveToNextPart',
    'closePart',
    'addPart'
]);

function addSequence() {
    props.part.sequences.push(props.getNewSequence());
}

function removeSequence(sequenceKey) {
    props.part.sequences.splice(sequenceKey, 1);
}

function copySequence(sequenceKey) {
    copiedSequence.value = JSON.parse(JSON.stringify(props.part.sequences[sequenceKey]));
}

function pasteSequence(sequenceKey) {
    props.part.sequences[sequenceKey] = copiedSequence.value;
}

function addMeasure(sequenceKey) {
    props.part.sequences[sequenceKey]['measures'].push({
        'chords': '',
        'time_signature': props.time_signature
    });
}

function removeMeasure(sequenceKey, measureKey) {
    props.part.sequences[sequenceKey]['measures'].splice(measureKey, 1);
}


function chordSpace(event, sequenceKey, measureKey) {
    let chordString = props.part.sequences[sequenceKey]['measures'][measureKey]['chords'];
    const lastChar = chordString.slice(-1);
    props.part.sequences[sequenceKey]['measures'][measureKey]['chords'] = chordString.replaceAll(' ', '');

    if (lastChar !== ' ') {
        return;
    }

    props.part.sequences[sequenceKey]['measures'][measureKey]['chords'] = chordString.slice(0, -1);

    let isLastChord = props.part.sequences[sequenceKey]['measures'][measureKey + 1] === undefined;

    if (isLastChord) {
        addMeasure(sequenceKey);
    }

    // ToDo: Refactor (maybe nextTick?)
    setTimeout(function () {
        focusMeasure(sequenceKey, measureKey + 1);
    }, 10);
}

function chordLeft(event, sequenceKey, measureKey) {
    if (event.target.selectionStart === 0) {
        setTimeout(function () {
            focusMeasure(sequenceKey, measureKey - 1, true)
        }, 10);
    }
}

function chordRight(event, sequenceKey, measureKey) {
    if (event.target.selectionStart === props.part.sequences[sequenceKey]['measures'][measureKey]['chords'].length) {
        setTimeout(function () {
            focusMeasure(sequenceKey, measureKey + 1)
        }, 10);
    }
}

function chordDelete(event, sequenceKey, measureKey) {
    if (event.target.value !== '') {
        return;
    }

    // Focus last element
    setTimeout(function () {
        removeMeasure(sequenceKey, measureKey);
        focusMeasure(sequenceKey, measureKey - 1, true)
    });
}

function getRefName(sequenceKey, measureKey) {
    return 'measure-' + sequenceKey + '-' + measureKey;
}

function focusMeasure(sequenceKey, measureKey, setToEnd = false) {
    let refName = getRefName(sequenceKey, measureKey);
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
    <div>
        <div>
            <div class="grid lg:grid-cols-12 divide-x">
                <div class="lg:pr-4 col-span-5">
                    <h3 class="text-2xl text-gray-800 font-bold mb-2">{{ __('sheet.edit_part') }}</h3>
                    <p class="mb-4">{{ __('sheet.edit_part_description') }}</p>
                    <div class="mb-4">
                        <Input
                            name="name"
                            v-model="part.name"
                            label="sheet.name"
                        />
                    </div>
                    <div class="mb-4">
                        <TextArea
                            name="description"
                            v-model="part.description"
                            label="sheet.description_label"
                        />
                    </div>
                    <div>
                        <TextArea
                            name="lyrics"
                            v-model="part.lyrics"
                            label="sheet.lyrics"
                        />
                    </div>
                </div>
                <div class="lg:pl-4 col-span-7">
                    <h3 class="font-bold text-2xl mb-2">{{ __('sheet.sequences') }}</h3>
                    <div
                        v-for="(sequence, sequenceKey) in part.sequences"
                        :key="sequence.id"
                        class="border-0 p-3 border-gray-300"
                        :class="{
                            'pt-6': part.sequences[sequenceKey - 1] !== undefined,
                            'pb-6': part.sequences[sequenceKey + 1] !== undefined,
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
                                <div class="border-2 border-indigo-200 relative">
                                    <input type="number"
                                           class="w-16 block border-0 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm pr-1"
                                           v-model="sequence.quantity"
                                    />
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-6">
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

                                            <div class="border-indigo-200 focus:border-indigo-500 focus:ring-indigo-500 border-2 border-l-0">
                                                <input type="text"
                                                       class="block w-full border-0 sm:text-sm"
                                                       v-model="measure.chords"
                                                       :ref="(el) => {refs[getRefName(sequenceKey, measureKey)] = el}"
                                                       @keyup.space="event => chordSpace(event, sequenceKey, measureKey)"
                                                       @keydown.left="event => chordLeft(event, sequenceKey, measureKey)"
                                                       @keydown.right="event => chordRight(event, sequenceKey, measureKey)"
                                                       @keydown.delete="event => chordDelete(event, sequenceKey, measureKey)"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-end mb-1">
                                <button type="button"
                                        @click="copySequence(sequenceKey)"
                                        class="inline-flex items-center rounded-md bg-indigo-50 hover:text-white hover:bg-indigo-700 border-none px-1 py-1 ml-1 text-sm font-medium leading-4 text-gray-700 shadow-sm">
                                    <DocumentDuplicateIcon class="h-5 w-5"
                                                           aria-hidden="true"/>
                                </button>
                                <button type="button"
                                        @click="pasteSequence(sequenceKey)"
                                        class="inline-flex items-center rounded-md bg-indigo-50 hover:text-white hover:bg-indigo-700 border-none px-1 py-1 ml-1 text-sm font-medium leading-4 text-gray-700 shadow-sm">
                                    <ClipboardDocumentIcon class="h-5 w-5"
                                                           aria-hidden="true"/>
                                </button>
                                <button type="button"
                                        @click="removeSequence(sequenceKey)"
                                        class="inline-flex items-center rounded-md border  px-1 py-1 ml-1 text-sm font-medium leading-4 border-none text-red-600 bg-red-200 shadow-sm hover:bg-red-600 hover:text-white">
                                    <MinusCircleIcon class="h-5 w-5" aria-hidden="true"/>
                                </button>
                            </div>
                        </div>
                        <div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="col-span-1">
                                    <TextArea
                                        name="lyrics"
                                        label="sheet.description_label"
                                        rows="2"
                                        v-model="sequence.description"
                                    />
                                </div>
                                <div class="col-span-1">
                                    <FileUpload></FileUpload>
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
                                    @click="addSequence()"
                                    class="inline-flex items-center rounded-full border border-gray-300 bg-white px-4 py-1.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            >
                                <PlusIcon class="-ml-1.5 mr-1 h-5 w-5 text-gray-400" aria-hidden="true"/>
                                <span>{{ __('sheet.add_sequence') }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5 sm:mt-6 grid grid-cols-2">
            <div>
                <MutedButton
                    v-if="previousPart !== null"
                    @click="$emit('moveToPreviousPart')"
                >
                    {{ __('sheet.previous_part') }}
                </MutedButton>
            </div>
            <div class="flex justify-end">
                <MutedButton @click="$emit('closePart')" class="mr-2">
                    {{ __('general.close') }}
                </MutedButton>
                <PrimaryButton @click="nextPart !== null ? $emit('moveToNextPart') : $emit('addPart')">
                    {{ __('sheet.next_part') }}
                </PrimaryButton>
            </div>
        </div>
    </div>
</template>
