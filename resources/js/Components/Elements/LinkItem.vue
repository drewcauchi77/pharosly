<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    routeName: String,
    routeValue: Number,
    method: String,
    isPrimary: {
        type: Boolean,
        default: true
    }
});
</script>

<template>
    <Link
        :href="route(routeName, routeValue ?? null)"
        :method="method"
        class="text-sm  outline-offset-2 transition-colors duration-200 cursor-pointer hover:text-primary-hover"
        :class="[
            { 'text-primary outline-primary' : isPrimary },
            { 'text-text-alternate outline-text-alternate' : !isPrimary }
        ]"
    >
        <slot />
    </Link>
</template>
