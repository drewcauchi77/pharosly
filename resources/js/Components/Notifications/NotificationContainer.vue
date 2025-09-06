<script setup>
import NotificationMessage from "@/Components/Notifications/NotificationMessage.vue";
import {watch} from "vue";
import {usePage} from "@inertiajs/vue3";
import {useNotificationStore} from "@/State/notification.store.js";

const notificationStore = useNotificationStore();

const $page = usePage();

watch($page, () => {
    if ($page.props?.flash?.notification) {
        const notifications = Array.isArray($page.props.flash.notification)
            ? $page.props.flash.notification
            : [$page.props.flash.notification];

        notifications.forEach(notification => {
            notificationStore.pushNotification(
                Object.assign(
                    {},
                    notification,
                    { id: Date.now() + Math.random() }
                )
            );
        });
    }
});
</script>

<template>
    <div class="fixed bottom-4 right-4 mx-4 sm:m-0 flex flex-col gap-2 items-stretch sm:items-end z-500">
        <transition-group
            enter-active-class="transition transform duration-300 ease-out"
            leave-active-class="transition transform duration-200 ease-in"
            enter-from-class="translate-y-full sm:translate-y-0 sm:translate-x-full opacity-0"
            enter-to-class="translate-y-0 sm:translate-x-0 opacity-100"
            leave-from-class="translate-y-0 sm:translate-x-0 opacity-100"
            leave-to-class="translate-y-full sm:translate-y-0 sm:translate-x-full opacity-0"
        >
            <NotificationMessage
                v-for="(notification, index) in notificationStore.notifications"
                :key="index"
                :is-error="notification.isError ?? false"
                :title="notification.title"
                :description="notification.description"
                @click="notificationStore.removeNotification(notification.id)"
            />
        </transition-group>
    </div>
</template>
