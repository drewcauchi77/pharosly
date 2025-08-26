<script setup>
defineProps({
    title: String,
    description: String,
});
</script>

<template>
    <div
        class="fixed flex gap-4 bottom-4 mx-4 cursor-pointer bg-success text-white rounded-sm shadow-lg px-4 py-3 w-[calc(100%-32px)] sm:w-fit sm:right-4 sm:m-0 sm:max-w-md hover:bg-success-hover">
        <div>
            <strong v-if="title" class="block font-semibold mb-1">{{ title }}</strong>
            <span class="text-sm">{{ description }}</span>
        </div>

        <i class="fa-solid fa-xmark text-sm h-fit hover:opacity-80"></i>
    </div>
</template>
