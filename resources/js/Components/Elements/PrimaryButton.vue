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
        class="cursor-pointer w-full inline-flex items-center justify-center px-6 py-2.5 rounded-sm bg-primary text-white text-sm transition-all duration-200 hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 active:bg-primary disabled:bg-slate-300 disabled:text-slate-500 disabled:cursor-not-allowed shadow-sm hover:shadow-md"
    >
        <slot/>
    </button>
</template>
