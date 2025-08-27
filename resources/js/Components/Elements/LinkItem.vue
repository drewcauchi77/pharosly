<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    routeName: String,
    routeValue: Number,
    method: String
});
</script>

<template>
    <Link
        :href="route(routeName, routeValue ?? null)"
        :method="method"
        class="text-sm text-primary hover:text-primary-hover outline-primary outline-offset-2 transition-colors duration-200 cursor-pointer"
    >
        <slot />
    </Link>
</template>
