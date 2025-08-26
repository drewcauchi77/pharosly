<script setup>
import { useSuccessProps } from "@/Composables/success.js";

const props = defineProps({
    episode: Object,
    success: Object
});

useSuccessProps(props.success);
</script>

<template>
    <Head :title="episode.title" />

    <h1>{{ episode.title }}</h1>
    <p>{{ episode.description }}</p>
    <span>{{ episode.video_link }}</span>
</template>
