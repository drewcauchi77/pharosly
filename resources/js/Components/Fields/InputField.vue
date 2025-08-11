<script setup>
const model = defineModel();

defineProps({
    label: String,
    placeholder: String,
    type: {
        type: String,
        default: 'text'
    },
    icon: {
        type: String,
        default: 'account'
    }
});
</script>

<template>
    <div class="w-full">
        <label :for="label" class="block text-sm font-medium text-slate-700 mb-2">
            {{ label }}
        </label>

        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <span class="grid place-content-center text-sm text-slate-400">
                    <i :class="`fa-solid fa-${icon}`"></i>
                </span>
            </div>

            <input
                :id="label"
                :type="type"
                :name="label"
                :placeholder="placeholder"
                v-model="model"
                class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 pl-9 pr-3 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:border-indigo-500 transition-colors duration-200 hover:border-slate-400"
                :aria-describedby="`${label}-description`"
            />
        </div>
        
        <div :id="`${label}-description`" class="sr-only">
            {{ label }} input field
        </div>
    </div>
</template>
