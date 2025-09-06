<script setup>
import NotificationContainer from "@/Components/Notifications/NotificationContainer.vue";
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

    <NotificationContainer />
</template>
