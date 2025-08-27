<script setup>
defineProps({
    title: String,
    description: String
})
</script>

<template>
    <div class="text-center">
        <h2 class="text-primary text-2xl font-medium mb-2 ">
            {{ title }}
        </h2>
        <p class="text-alternate text-sm mb-4">
            {{ description }}
        </p>
    </div>
</template>
