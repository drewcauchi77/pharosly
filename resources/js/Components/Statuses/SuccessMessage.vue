<script setup>
defineProps({
    title: String,
    description: String,
});

const emit = defineEmits(['close']);

const closeMessage = () => {
    emit('close');
}
</script>

<template>
    <div
        class="flex gap-4 cursor-pointer bg-success rounded-sm shadow-lg px-4 py-3 w-[calc(100%-32px)] text-success-text sm:w-fit sm:max-w-md hover:bg-success-hover"
        @click="closeMessage"
    >
        <div>
            <strong v-if="title" class="block font-semibold mb-1">{{ title }}</strong>
            <span class="text-sm">{{ description }}</span>
        </div>

        <i class="fa-solid fa-xmark text-sm h-fit hover:opacity-80"></i>
    </div>
</template>
