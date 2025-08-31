<script setup>
import SideMenu from "@/Components/Menus/SideMenu.vue";
import SuccessMessage from "@/Components/Statuses/SuccessMessage.vue";
import TopBar from "@/Components/Menus/TopBar.vue";
import {usePage} from "@inertiajs/vue3";
import {useNotificationStore} from "@/State/notification.store.js";
import {watch} from "vue";
import {useStatusStore} from "@/State/status.store.js";

const notificationStore = useNotificationStore();
const statusStore = useStatusStore();
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
    <main>
        <TopBar />

        <div class="grid pt-[30px]">
            <div
                class="fixed bg-overlay w-full h-full lg:hidden transition-opacity duration-300 ease-in-out"
                :class="{ 'hidden' : !statusStore.isMenuOpen }"
                @click="statusStore.setIsMenuOpen(!statusStore.isMenuOpen)"
            ></div>

            <div
                class="fixed border-r-1 border-light-blue bg-white h-full w-95 max-w-3xs top-[30px]
                   transition-transform duration-300 ease-in-out transform z-50"
                :class="{
                    '-translate-x-full lg:translate-x-0' : !statusStore.isMenuOpen,
                    'translate-x-0' : statusStore.isMenuOpen
                }"
            >
                <SideMenu />
            </div>

            <div class="lg:ml-[256px]">
            <span
                @click="statusStore.setIsMenuOpen(!statusStore.isMenuOpen)"
                class="cursor-pointer"
            >
                Open Menu
            </span>
                <div class="p-5 max-w-[1680px] mx-auto">
                    <slot />
                </div>
            </div>
        </div>
    </main>

    <div class="fixed bottom-4 right-4 mx-4 sm:m-0 flex flex-col gap-2 items-stretch sm:items-end">
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
