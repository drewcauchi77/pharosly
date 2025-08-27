<script setup>
import { ref, watch } from "vue";
import SideMenu from "@/Components/Menus/SideMenu.vue";
import SuccessMessage from "@/Components/Statuses/SuccessMessage.vue";
import TopBar from "@/Components/Menus/TopBar.vue";

const props = defineProps({
    title: String,
    description: String
});

const shownTitle = ref(null);
const shownDescription = ref(null);
const messages = ref([]);

const removeMessage = (id) => {
    messages.value = messages.value.filter(m => m.id !== id);
}

const pushMessage = (title, description) => {
    const id = Date.now() + Math.random();
    messages.value.push({ id, title, description });

    return id;
}

const autoHideMessage = (id) => {
    setTimeout(() => {
        removeMessage(id);
        shownTitle.value = null;
        shownDescription.value = null;
    }, 4000);
}

watch(
    () => [props.title, props.description],
    ([title, description]) => {
        if (title && description) {
            shownTitle.value = title;
            shownDescription.value = description;
            autoHideMessage(pushMessage(title, description));
        }
    },
    { immediate: true }
);
</script>

<template>
    <main>
        <TopBar />

        <div class="grid pt-[30px]">
            <div class="fixed h-full w-full lg:w-3xs z-50">
                <div class="bg-overlay w-full h-full lg:hidden"></div>

                <div class="fixed border-r-1 border-light-blue bg-white h-full w-95 max-w-3xs top-[30px]">
                    <SideMenu />
                </div>
            </div>

            <div class="lg:ml-[256px]">
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
                v-for="m in messages"
                :key="m.id"
                :title="m.title"
                :description="m.description"
                @close="removeMessage(m.id)"
            />
        </transition-group>
    </div>
</template>
