<script setup>
import {onMounted} from "vue";
import {usePage} from "@inertiajs/vue3";
import {useNotificationStore} from "@/State/notification.store.js";

const notificationStore = useNotificationStore();
const $page = usePage();

defineProps({
    auth: Object,
});

onMounted(() => {
    if ($page.props?.flash?.notification) {
        notificationStore.pushNotification(
            Object.assign(
                {},
                $page.props?.flash?.notification,
                { id: Date.now() + Math.random() }
            )
        );
    }
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
