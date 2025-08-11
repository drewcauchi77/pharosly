<script setup>
defineProps({
    title: String,
    description: String
})
</script>

<template>
    <div class="text-center">
        <h2 class="mt-6 text-3xl font-bold tracking-tight text-slate-900">
            {{ title }}
        </h2>
        <p class="mt-2 text-sm text-slate-600">
            {{ description }}
        </p>
    </div>
</template>
