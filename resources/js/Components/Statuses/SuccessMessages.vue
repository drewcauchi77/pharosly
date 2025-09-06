<script setup>
defineProps({
    status: String
});
</script>

<template>
    <div class="mb-5" v-if="status && status !== ''">
        <span class="text-sm text-green-500 mb-2">{{ status }}</span>
    </div>
</template>
