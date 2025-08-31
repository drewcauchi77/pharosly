<script setup>
import {onMounted} from "vue";
import {usePage} from "@inertiajs/vue3";

defineProps({
    auth: Object,
});

const $page = usePage();

onMounted(() => {
    console.log($page.props)
});
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
