<script>

export default {
    components: {
    },
    props: {
        sheet: Object,
    },
    data() {
        return {
        }
    },
    mounted() {
    },
    methods: {
    }
}
</script>


<template>
    <div class="min-h-screen bg-gray-900">
        <div class="min-h-screen mx-auto max-w-5xl bg-gray-100">
            <div class="py-2 px-4 sm:px-6 lg:px-8 border-gray-900 border-b">
                <div class="text-md font-bold">{{sheet.title}}</div>
                <div class="text-xs">{{sheet.artist}}</div>
            </div>
            <div class="py-6 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2" v-for="part in sheet.parts" :key="part.id">
                    <div>L</div>
                    <div>R</div>
                </div>
                <h1>Test 123</h1>
            </div>
        </div>
    </div>
</template>
