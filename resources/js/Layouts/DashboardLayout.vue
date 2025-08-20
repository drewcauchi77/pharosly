<script setup>

import SideMenu from "@/Components/Menus/SideMenu.vue";
</script>

<template>
    <main class="grid">
        <div class="fixed border-r-1 border-light-blue h-full w-3xs">
            <SideMenu />
        </div>

        <div class="ml-[256px]">
            <slot />
        </div>
    </main>
</template>
