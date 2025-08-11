<script setup>
defineProps({
    errors: Object
});
</script>

<template>
    <div class="mb-4" v-if="Object.keys(errors).length">
        <ul class="list-none">
            <li v-for="(error, index) in errors" class="text-sm text-red-500 mb-2" :key="index">{{ error }}</li>
        </ul>
    </div>
</template>
