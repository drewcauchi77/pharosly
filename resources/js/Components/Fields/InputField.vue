<script setup>
import {ref, watch} from "vue";

const withErrorFocus = ref(false);
const model = defineModel();

const props = defineProps({
    label: String,
    id: String,
    placeholder: String,
    hasError: Boolean,
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

watch(() => props.hasError, (newValue) => {
    withErrorFocus.value = newValue;
});
</script>

<template>
    <div class="w-full mb-5">
        <label :for="id" class="block text-sm text-text mb-2">
            {{ label }}
        </label>

        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-3 rounded-l-sm bg-input-icon-color border border-alternate-opaque">
                <span class="grid place-content-center text-sm text-slate-400">
                    <i :class="`fa-solid fa-${icon}`"></i>
                </span>
            </div>

            <input
                @focus="withErrorFocus = false"
                :required="isRequired"
                :id="id"
                :type="type"
                :name="id"
                :placeholder="placeholder"
                v-model="model"
                class="block w-full rounded-sm bg-white pr-3 pl-13 py-2.5 border-alternate-opaque text-sm text-text placeholder:text-alternate focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-primary transition-colors duration-200"
                :class="{ 'ring-2 ring-offset-1 ring-error-text' : withErrorFocus }"
                :aria-describedby="`${id}-description`"
            />
        </div>

        <div :id="`${id}-description`" class="sr-only">
            {{ label.toLowerCase() }} input field
        </div>
    </div>
</template>
