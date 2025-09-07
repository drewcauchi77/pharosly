<script setup>
import SideMenu from "@/Components/Menus/SideMenu.vue";
import TopBar from "@/Components/Menus/TopBar.vue";
import NotificationContainer from "@/Components/Notifications/NotificationContainer.vue";
import {useStatusStore} from "@/State/status.store.js";

const statusStore = useStatusStore();
</script>

<template>
    <main>
        <TopBar />

        <div class="grid pt-[30px]">
            <div
                class="fixed bg-overlay w-full h-full lg:hidden transition-opacity duration-300 ease-in-out z-10"
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

            <div class="lg:ml-[256px] overflow-hidden">
                <span
                    @click="statusStore.setIsMenuOpen(!statusStore.isMenuOpen)"
                    class="cursor-pointer"
                >
                    Open Menu
                </span>
                <div class="p-5 max-w-[1680px] mx-auto w-screen lg:w-full">
                    <slot />
                </div>
            </div>
        </div>
    </main>

    <NotificationContainer />
</template>
