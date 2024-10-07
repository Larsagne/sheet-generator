<script setup>
import Input from "@/Components/Form/Input.vue";
import {ref} from "vue";

const image = ref(null);
const imageUrl = ref(null);

defineProps({
    id: String,
    accept: String
});

function onFilePicked (event) {
    const files = event.target.files
    const fileReader = new FileReader()
    fileReader.addEventListener('load', () => {
        imageUrl.value = fileReader.result
    })
    fileReader.readAsDataURL(files[0])
    image.value = files[0]
}
</script>

<template>
    <div
        class="flex rounded-md border-2 border-dashed border-gray-300 w-full pt-5 pb-6">
        <div class="text-center flex justify-center w-full">
            <div class="mr-4">
                <svg class="mx-auto h-8 w-12 text-gray-400"
                     stroke="currentColor" fill="none"
                     viewBox="0 0 48 48" aria-hidden="true"
                     v-if="!imageUrl"
                >
                    <path
                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"/>
                </svg>
                <img :src="imageUrl" v-else class="max-h-10">
            </div>
            <div>
                <div class="flex text-sm text-gray-600 justify-center">
                    <label :for="'file-upload-' + id"
                           class="px-1 relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500"
                    >
                        <span>Upload a file</span>
                        <input :id="'file-upload-' + id"
                               :name="'file-upload-' + id"
                               type="file"
                               class="sr-only"
                               @change="onFilePicked"
                               :accept="accept"
                        />
                    </label>
                    <p class="pl-1">or drag and drop</p>
                </div>
                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
            </div>
        </div>
    </div>
</template>
