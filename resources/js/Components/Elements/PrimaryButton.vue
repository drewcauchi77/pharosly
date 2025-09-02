<script setup>
defineProps({
    type: {
        type: String,
        default: 'button'
    },
    isSecondary: {
        type: Boolean,
        default: false
    }
});
</script>

<template>
    <button
        :type="type"
        class="cursor-pointer w-full inline-flex items-center justify-center px-6 py-2.5 rounded-sm  text-sm transition-all duration-200  focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:cursor-not-allowed shadow-sm hover:shadow-md"
        :class="[
            { 'bg-primary text-white hover:bg-primary-hover focus:ring-primary active:bg-primary disabled:bg-slate-300 disabled:text-slate-500' : !isSecondary },
            { 'bg-button-secondary text-alternate hover:bg-button-secondary-hover focus:ring-button-secondary active:bg-button-secondary disabled:bg-slate-300 disabled:text-slate-500' : isSecondary }
        ]"
    >
        <slot/>
    </button>
</template>
