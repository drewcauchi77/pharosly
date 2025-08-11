<script setup>
defineProps({
    type: {
        type: String,
        default: 'button'
    }
});
</script>

<template>
    <button
        :type="type"
        class="cursor-pointer w-full inline-flex items-center justify-center px-6 py-2.5 rounded-lg bg-slate-900 text-white font-medium text-sm transition-all duration-200 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 active:bg-slate-950 disabled:bg-slate-300 disabled:text-slate-500 disabled:cursor-not-allowed shadow-sm hover:shadow-md"
    >
        <slot/>
    </button>
</template>
