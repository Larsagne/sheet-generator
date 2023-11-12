<script setup>
import {MenuItem, MenuItems} from "@headlessui/vue";
import {onMounted, ref} from "vue";

const isDragging = ref(false);
const draggingIndex = ref(null);
const offsetX = ref(0);
const offsetY = ref(0);
const texts = ref([
    { content: 'Text 1', x: 50, y: 50 },
    { content: 'Text 2', x: 200, y: 100 },
]);
const isContextMenuVisible = ref(false);
const contextMenuPosition = ref({ x: 0, y: 0 });

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
function showContextMenu(event) {
    event.preventDefault();
    isContextMenuVisible.value = true;
    contextMenuPosition.value = { x: event.clientX, y: event.clientY };

    document.addEventListener('click', closeContextMenu);
}
function closeContextMenu() {
    isContextMenuVisible.value = false;
    document.removeEventListener('click', closeContextMenu);
}
</script>

<template>
    <div @contextmenu.prevent="showContextMenu($event)" class="absolute bg-red-100">

        <MenuItems v-if="isContextMenuVisible" class="absolute right-0 z-10 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
            <div class="py-1">
                <MenuItem>
                    <a href="#" >Edit</a>
                </MenuItem>
                <MenuItem>
                    <a href="#" >Duplicate</a>
                </MenuItem>
            </div>
        </MenuItems>


        <div
            v-for="(text, index) in texts"
            :key="index"
            @mousedown="startDragging($event, index)"
            :style="{ left: text.x + 'px', top: text.y + 'px' }"
            class="draggable-text"
        >
            {{ text.content }}
        </div>
    </div>
</template>

<style scoped>
.draggable-text {
    position: absolute;
    cursor: move;
    padding: 10px;
    background-color: #3498db;
    color: #fff;
    border-radius: 5px;
}
.context-menu-trigger {
    padding: 10px;
    background-color: #3498db;
    color: #fff;
    cursor: context-menu;
}

.context-menu {
    position: fixed;
    top: 0;
    left: 0;
    background-color: #fff;
    border: 1px solid #ddd;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 8px;
    z-index: 1000;
}

.context-menu div {
    padding: 8px;
    cursor: pointer;
    transition: background-color 0.2s;
}

.context-menu div:hover {
    background-color: #f0f0f0;
}
</style>
