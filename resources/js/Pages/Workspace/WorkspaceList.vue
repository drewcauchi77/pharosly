<script setup>
defineProps({
    workspaces: Object
});
</script>

<template>
    <Head title="Workspaces" />
    {{ console.log(workspaces) }}
</template>
