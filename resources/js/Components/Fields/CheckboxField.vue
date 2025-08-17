<script setup>
const model = defineModel();

defineProps({
    label: String,
    id: String
});
</script>

<template>
    <div class="flex items-center">
        <input
            v-model="model"
            :id="id"
            :name="id"
            type="checkbox"
            class="h-4 w-4 rounded-sm border-slate-300 text-primary focus:ring-2 focus:ring-offset-1 focus:ring-primary"
        >

        <label :for="id" class="ml-2 block text-sm text-text">
            {{ label }}
        </label>
    </div>
</template>
