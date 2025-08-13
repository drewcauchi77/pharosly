<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    modules: Object
});
</script>

<template>
    <Head title="Modules" />
    <Link :href="route('modules.create')" class="block mb-8 text-indigo-700">Create Module</Link>

    <div v-for="module in modules.data" :key="module.id" class="mb-4">
        <h1>{{ module.title }}</h1>
        <p>{{ module.description }}</p>
        <span>{{ module.video_link }}</span><br>
        <Link :href="route('modules.show', module.id)">Go To Module</Link>
    </div>
</template>
