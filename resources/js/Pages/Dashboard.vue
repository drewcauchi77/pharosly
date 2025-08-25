<script setup>
import { useSuccessProps } from "@/Composables/success.js";

const props = defineProps({
    auth: Object,
    success: Object
});

useSuccessProps(props.success);
</script>

<template>
    <Head title="Dashboard" />

    <h1 class="text-3xl font-bold underline mb-5">
        Home!
    </h1>

    <template v-if="auth && auth.user">
        You are logged in as {{ auth.user.email }}
    </template>
</template>
