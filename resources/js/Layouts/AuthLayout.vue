<script setup>
import {watch} from "vue";
import {useNotificationStore} from "@/State/notification.store.js";
import {usePage} from "@inertiajs/vue3";
import SuccessMessage from "@/Components/Statuses/SuccessMessage.vue";

const notificationStore = useNotificationStore();
const $page = usePage();

watch($page, () => {
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
    <main class="min-h-screen flex items-center justify-center bg-light-blue p-4">
        <div class="w-full max-w-full md:max-w-xl shadow-md">
            <div>
                <div class=" bg-white p-6 sm:p-8 md:p-10 rounded-sm">
                    <slot />
                </div>
            </div>
        </div>
    </main>

    <div class="fixed bottom-4 right-4 mx-4 sm:m-0 flex flex-col gap-2 items-stretch sm:items-end w-[calc(100%-32px)] sm:w-auto">
        <transition-group
            enter-active-class="transition transform duration-300 ease-out"
            leave-active-class="transition transform duration-200 ease-in"
            enter-from-class="translate-y-full sm:translate-y-0 sm:translate-x-full opacity-0"
            enter-to-class="translate-y-0 sm:translate-x-0 opacity-100"
            leave-from-class="translate-y-0 sm:translate-x-0 opacity-100"
            leave-to-class="translate-y-full sm:translate-y-0 sm:translate-x-full opacity-0"
        >
            <SuccessMessage
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
