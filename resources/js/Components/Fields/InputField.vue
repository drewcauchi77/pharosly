<script setup>
import { ref } from "vue";

const model = defineModel();
const isFocused = ref(false);

defineProps({
    label: String,
    placeholder: String,
    isRequired: Boolean,
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
    <div class="w-full mb-5">
        <label :for="label.toLowerCase()" class="block text-sm text-text mb-2">
            {{ label }}
        </label>

        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-3 rounded-l-sm bg-input-icon-color border border-alternate-opaque"
                :class="{ 'border-r-alternate-opaque' : isFocused }">
                <span class="grid place-content-center text-sm text-slate-400">
                    <i :class="`fa-solid fa-${icon}`"></i>
                </span>
            </div>

            <input
                :required="isRequired"
                :id="label.toLowerCase()"
                :type="type"
                :name="label.toLowerCase()"
                :placeholder="placeholder"
                v-model="model"
                class="block w-full rounded-sm bg-white pr-3 pl-13 py-2.5 border-alternate-opaque text-sm text-text placeholder:text-alternate focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-primary transition-colors duration-200"
                @focus="isFocused = true"
                @focusout="isFocused = false"
                :aria-describedby="`${label}-description`"
            />
        </div>

        <div :id="`${label.toLowerCase()}-description`" class="sr-only">
            {{ label.toLowerCase() }} input field
        </div>
    </div>
</template>
