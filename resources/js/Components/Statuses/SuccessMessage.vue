<script setup>
defineProps({
    title: String,
    description: String,
});
</script>

<template>
    <div class="fixed bottom-4 right-4 bg-emerald-600 text-white rounded shadow-lg px-4 py-3 max-w-sm">
        <strong v-if="title" class="block font-semibold mb-1">{{ title }}</strong>
        <span>{{ description }}</span>
    </div>
</template>
