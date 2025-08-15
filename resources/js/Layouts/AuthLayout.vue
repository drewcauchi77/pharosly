<script setup>
import FormHeader from "@/Components/Forms/FormHeader.vue";
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-light-blue p-4">
        <div class="w-full max-w-full md:max-w-xl shadow-md">
            <div>
                <FormHeader />

                <div class=" bg-white p-6 sm:p-8 md:p-10 rounded-b-sm">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
