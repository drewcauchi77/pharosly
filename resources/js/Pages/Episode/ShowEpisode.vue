<script setup>
defineProps({
   episode: Object
});
</script>

<template>
    <Head :title="episode.title" />

    <h1>{{ episode.title }}</h1>
    <p>{{ episode.description }}</p>
    <span>{{ episode.video_link }}</span>
</template>
