<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    routeName: String
});
</script>

<template>
    <Link :href="route(routeName)" class="text-sm text-primary hover:text-primary-hover outline-primary outline-offset-2 transition-colors duration-200">
        <slot />
    </Link>
</template>
