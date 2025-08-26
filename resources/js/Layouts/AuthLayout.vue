<script setup>
import SuccessMessage from "@/Components/Statuses/SuccessMessage.vue";
import { ref, watch } from "vue";

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
                v-for="m in messages"
                :key="m.id"
                :title="m.title"
                :description="m.description"
                @close="removeMessage(m.id)"
            />
        </transition-group>
    </div>
</template>
