<script setup>
defineProps({
   module: Object
});
</script>

<template>
    <h1>{{ module.title }}</h1>
    <p>{{ module.description }}</p>
    <span>{{ module.video_link }}</span>
</template>
