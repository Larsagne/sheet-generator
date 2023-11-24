<template>
    <div v-if="isOpen" class="absolute z-10 bg-white shadow-md rounded py-2 w-48" id="context-menu" :style="{ top: `${menuPosition.y}px`, left: `${menuPosition.x}px` }" @click="handleClickOutside">
        <ul>
            <li v-for="(item, index) in menuItems" :key="index" @click="handleItemClick(item.label)" class="cursor-pointer py-2 px-4">{{ item.label }}</li>
        </ul>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const menuPosition = ref({ x: 0, y: 0 });
const menuItems = ref([]);
defineProps({
    isOpen: Boolean
});

const handleClickOutside = (event) => {
    if (!event.target.closest('#context-menu')) {
        isOpen.value = false;
    }
};

const handleItemClick = (label) => {
    isOpen.value = false;
    // emit('item-click', label);
};

const openContextMenu = ({ x, y, items }) => {
    menuPosition.value = { x, y };
    menuItems.value = items;
    isOpen.value = true;
};
</script>
