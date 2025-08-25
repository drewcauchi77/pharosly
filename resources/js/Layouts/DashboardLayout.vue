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
    ([t, d]) => {
        if (t && d) {
            shownTitle.value = t;
            shownDescription.value = d;
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

    <SuccessMessage v-if="shownTitle && shownDescription" :title="shownTitle" :description="shownDescription" />
</template>
