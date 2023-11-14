<script setup>
import {ref} from "vue";
import VueResizable from 'vue-resizable';

const isDragging = ref(false);
const draggingIndex = ref(null);
const offsetX = ref(0);
const offsetY = ref(0);
const texts = ref([
    { content: 'Text 1', x: 50, y: 50, width: 150, height: 80 },
    { content: 'Text 2', x: 200, y: 100, width: 150, height: 80 },
]);

const tW = ref(150);
const tH = ref(80);
const handlers = ref(["r", "rb", "b", "lb", "l", "lt", "t", "rt"]);
const left = ref("10%");
const top = ref('40%');
const height = ref(tH);
const width = ref(tW);
const minW = ref(40);
const minH = ref(20);
const fit = ref(true);
const event = ref("");
const dragSelector = ref(".draggable");
const test = ref(null);

const props = defineProps([
    'container'
]);

function startDragging(event, index) {
    isDragging.value = true;
    draggingIndex.value = index;
    offsetX.value = event.clientX - texts.value[index].x;
    offsetY.value = event.clientY - texts.value[index].y;

    window.addEventListener('mousemove', handleDragging);
    window.addEventListener('mouseup', stopDragging);
}
function handleDragging(event) {
    if (isDragging.value) {
        let newX = event.clientX - offsetX.value;
        let newY = event.clientY - offsetY.value;

        let containerLeft = props.container.getBoundingClientRect().left;
        let containerRight = props.container.getBoundingClientRect().right;

        if (newX < containerLeft) {
            texts.value[draggingIndex.value].x = containerLeft;
        } else if (newX > containerRight) {
            // ToDo: Subtract width
            texts.value[draggingIndex.value].x = containerRight;
        } else {
            texts.value[draggingIndex.value].x = newX;
        }

        texts.value[draggingIndex.value].y = newY;
    }
}
function stopDragging() {
    isDragging.value = false;
    draggingIndex.value = null;
    window.removeEventListener('mousemove', handleDragging);
    window.removeEventListener('mouseup', stopDragging);
}


function startResizing(event, index) {
    event.preventDefault();
    event.stopPropagation();

    isDragging.value = true;
    draggingIndex.value = index;
    offsetX.value = event.clientX - texts.value[index].x;
    offsetY.value = event.clientY - texts.value[index].y;

    window.addEventListener('mousemove', handleResizing);
    window.addEventListener('mouseup', stopResizing);
}

function handleResizing(event) {
    if (isDragging.value) {
        let newX = event.clientX - offsetX.value;
        let newY = event.clientY - offsetY.value;

        let containerLeft = props.container.getBoundingClientRect().left;
        let containerRight = props.container.getBoundingClientRect().right;

        if (newX < containerLeft) {
            texts.value[draggingIndex.value].x = containerLeft;
        } else if (newX > containerRight) {
            texts.value[draggingIndex.value].x = containerRight;
        } else {
            texts.value[draggingIndex.value].x = newX;
        }

        texts.value[draggingIndex.value].y = newY;
    }
}
function stopResizing() {
    isDragging.value = false;
    draggingIndex.value = null;
    window.removeEventListener('mousemove', handleResizing);
    window.removeEventListener('mouseup', stopResizing);
}
function dragEnd(data) {
    eHandler(data);
    document.body.style.overflow = 'auto';
}
function eHandler(data) {
    document.body.style.overflow = 'hidden';
    console.log('test');
    width.value = data.width;
    height.value = data.height;
    left.value = data.left;
    top.value = data.top;
    event.value = data.eventName;
}
function focus() {
    const input = test.value;
    input.focus()
    let value = input.value;
    input.value = '';
    input.value = value;
}
function addNote() {
    console.log('addnote');
}
</script>

<template>
    <div @contextmenu.prevent="showContextMenu($event)" class="absolute w-full h-full" @dblclick="addNote">
        <div class="container-test">
            <vue-resizable
                class="resizable bg-gray-100"
                ref="resizableComponent"
                :dragSelector="dragSelector"
                :active="handlers"
                :fit-parent="fit"
                :min-width="minW"
                :min-height="minH"
                :width="width"
                :height="height"
                :left="left"
                :top="top"
                @mount="eHandler"
                @resize:move="eHandler"
                @resize:start="eHandler"
                @resize:end="eHandler"
                @drag:move="eHandler"
                @drag:start="eHandler"
                @drag:end="dragEnd"
                @dblclick="focus"
            >
                <div class="block draggable" style="padding:2px">
                    <textarea
                        ref="test"
                        class="bg-gray-100"
                        style="resize:none; width: 100%; height: 100%; font-size: 12px"
                    >Test 123</textarea>

                </div>
            </vue-resizable>
        </div>
    </div>
</template>

<style scoped>
.block {
    height: 100%;
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    font-size: 12px;
    color: red;
    border: 2px solid red;
    font-weight: 700;
    cursor: move;
}
.block textarea {
    padding: 0;
    line-height: 1;
    cursor: move;
    border: 0;
}
.container-test {
    width: 100%;
    height: 100%;
    display: inline-block;
    color: #333333;
    float: left;
}
</style>
