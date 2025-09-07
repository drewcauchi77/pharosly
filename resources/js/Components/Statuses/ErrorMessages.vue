<script setup>
defineProps({
    errors: Object
});
</script>

<template>
    <div class="mb-4" v-if="Object.keys(errors).length">
        <ul class="list-none">
            <li v-for="(error, index) in errors" class="flex items-center text-sm text-error-text mb-2 bg-error py-2 px-4 rounded-sm !font-medium" :key="index">
                <i class="fa-solid fa-circle-exclamation pr-6"></i>
                <span>{{ error }}</span>
            </li>
        </ul>
    </div>
</template>
