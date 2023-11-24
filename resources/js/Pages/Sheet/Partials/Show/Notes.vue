<script setup>
import {computed, nextTick, ref} from "vue";
import VueResizable from 'vue-resizable';

const texts = ref([
    {content: 'Text 1', x: '10%', y: '20%', width: 80, height: 40, dragging: false, ref: null, editRef: null, isDeleting: false},
    {content: 'Text 2', x: '20%', y: '10%', width: 100, height: 30, dragging: false, ref: null, editRef: null, isDeleting: false},
    {content: 'Text 3', x: '5%', y: '50%', width: 150, height: 80, dragging: false, ref: null, editRef: null, isDeleting: false},
]);

const left = ref("10%");
const top = ref('40%');
const height = ref(80);
const width = ref(150);
const lastTap = ref(0);
const isDragging = ref(false);
const isDeleting = ref(false);

const deleteButtonRef = ref(null);

const props = defineProps([
    'container',
    'header',
]);

const focusDeleting = computed(() => {
    return isDragging.value;
});

function handleDoubleClick(event, callback) {
    const now = new Date().getTime();
    if (now - lastTap.value < 300) {
        callback(event);
    }

    lastTap.value = now;
}

function focus(index) {
    const input = texts.value[index].editRef;
    input.focus()
    let value = input.value;
    input.value = '';
    input.value = value;
}

function dragStart(index, data) {
    eHandler(index, data);
    isDragging.value = true;
    texts.value[index]['dragging'] = true;
    document.body.style.overflow = 'hidden';
}

function dragEnd(index, data) {
    eHandler(index, data);
    isDragging.value = false;
    texts.value[index].dragging = false;

    if (texts.value[index].isDeleting) {
        texts.value.splice(index, 1);
    }

    document.body.style.overflow = 'auto';
}

function eHandler(index, data) {
    const text = texts.value[index];

    text['x'] = data.left;
    text['y'] = data.top;
    text['width'] = data.width;
    text['height'] = data.height;

    const rect1 = text.ref.getBoundingClientRect();
    const rect2 = deleteButtonRef.value.getBoundingClientRect();

    const overlap = !(
        rect1.right < rect2.left ||
        rect1.left > rect2.right ||
        rect1.bottom < rect2.top ||
        rect1.top > rect2.bottom
    );

    if (overlap) {
        text.isDeleting = true;
        isDeleting.value = true;
    } else {
        text.isDeleting = false;
        isDeleting.value = false;
    }
}

function addNote(event) {
    const count = texts.value.push(
        {content: '', x: event.layerX.toString() + 'px', y: event.layerY + 'px', width: 96, height: 40, dragging: false, ref: null, isDeleting: false}
    );

    // texts.value[count - 1].focus();
    nextTick(() => {
        texts.value[count - 1].editRef.focus()
    })
}
</script>

<template>
    <div
        class="h-full"
        @click.stop="(e) => handleDoubleClick(e, addNote)"
    >
        <vue-resizable
            class="bg-gray-100 absolute z-10 border-red-500 border p-1"
            dragSelector=".draggable"
            :active='["r", "rb", "b", "lb", "l", "lt", "t", "rt"]'
            :fit-parent=true
            :min-width=40
            :min-height=20
            :width="text.width"
            :height="text.height"
            :left="text.x"
            :top="text.y"
            @mount="(data) => eHandler(index, data)"
            @resize:move="(data) => eHandler(index, data)"
            @resize:start="(data) => eHandler(index, data)"
            @resize:end="(data) => eHandler(index, data)"
            @drag:move="(data) => eHandler(index, data)"
            @drag:start="(data) => dragStart(index, data)"
            @drag:end="(data) => dragEnd(index, data)"
            @click.stop="(e) => handleDoubleClick(e, () => {focus(index)})"
            v-for="(text, index) in texts"
            :key="index"
            :class="text.isDeleting ? 'opacity-0' : 'opacity-100'"
        >
            <div
                class="h-full cursor-move text-red-500  block draggable"
                :ref="(el) => {text.ref = el}"
            >
                <textarea
                    :ref="(el) => {text.editRef = el}"
                    class="bg-gray-100 resize-none w-full h-full text-xs overflow-hidden"
                    style="box-shadow: none;"
                >{{ text.content }}</textarea>
            </div>
        </vue-resizable>

        <div class="transition-all" :class="isDragging ? 'opacity-100' : 'opacity-0'">
            <button
                class="w-12 h-12 z-50 flex items-center justify-center rounded-full bg-red-600 shadow-2xl shadow-red-900  ring-offset-2 ring-2 ring-red-600 mx-auto inset-x-0 bottom-12 fixed"
                :class="isDeleting ? 'scale-110' : ''"
                ref="deleteButtonRef"
            >
                <!-- Icon oder Symbol für das Löschen hinzufügen -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</template>

<style scoped>
.block {
    //height: 100%;
    //display: flex;
    //flex-direction: column;
    //justify-content: center;
    //align-items: center;
    //font-size: 12px;
    //color: red;
    //border: 2px solid red;
    //font-weight: 700;
    //cursor: move;
}

.block textarea {
    padding: 0;
    line-height: 1;
    cursor: move;
    border: 0;
}

.resizable-component.absolute {
    position: absolute;
}
</style>
