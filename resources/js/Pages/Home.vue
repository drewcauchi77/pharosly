<script setup>
import { Link, router } from "@inertiajs/vue3";

defineProps({
    auth: Object
});
</script>

<template>
    <Head title="About" />
    <h1 class="text-3xl font-bold underline mb-5">
        Home!
    </h1>

    <template v-if="auth && auth.user">
        <Link as="button" method="delete" :href="route('login.destroy')" class="block w-full px-6 py-3 hover:bg-slare-700 text-left">Logout</Link>
    </template>
</template>
