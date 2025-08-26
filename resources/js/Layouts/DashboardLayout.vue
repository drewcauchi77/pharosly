<script setup>
import { ref, watch } from "vue";
import SideMenu from "@/Components/Menus/SideMenu.vue";
import SuccessMessage from "@/Components/Statuses/SuccessMessage.vue";

const props = defineProps({
    title: String,
    description: String
});

const shownTitle = ref(null);
const shownDescription = ref(null);

watch(
    () => [props.title, props.description],
    ([title, description]) => {
        if (title && description) {
            shownTitle.value = title;
            shownDescription.value = description;
        }
    },
    { immediate: true }
);
</script>

<template>
    <main class="grid">
        <div class="fixed border-r-1 border-light-blue h-full w-3xs">
            <SideMenu />
        </div>

        <div class="ml-[256px]">
            <div class="p-5 max-w-[1680px] mx-auto">
                <slot />
            </div>
        </div>
    </main>

    <transition
        enter-active-class="transition transform duration-300 ease-out"
        leave-active-class="transition transform duration-200 ease-in"
        enter-from-class="translate-y-full sm:translate-y-0 sm:translate-x-full"
        enter-to-class="translate-y-0 sm:translate-x-0"
        leave-from-class="translate-y-0 sm:translate-x-0"
        leave-to-class="translate-y-full sm:translate-y-0 sm:translate-x-full"
    >
        <SuccessMessage v-if="shownTitle && shownDescription" :title="shownTitle" :description="shownDescription" />
    </transition>
</template>
