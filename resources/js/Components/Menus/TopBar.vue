<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

const locale = 'en-US';

const now = ref(new Date());
let timerId = null;

const dateFmt = new Intl.DateTimeFormat(locale, {
    weekday: 'short',
    day: '2-digit',
    month: 'short'
});

const timeFmt = new Intl.DateTimeFormat(locale, {
    hour: '2-digit',
    minute: '2-digit',
    hour12: true
});

const formatted = computed(() => `${dateFmt.format(now.value)} | ${timeFmt.format(now.value)}`);

const tick = () => {
    now.value = new Date();
    const msUntilNextSecond = 1000 - (Date.now() % 1000);
    timerId = setTimeout(tick, msUntilNextSecond);
};

onMounted(() => {
    tick();
});

onUnmounted(() => {
    if (timerId) clearTimeout(timerId);
});
</script>

<template>
    <div class="text-xs fixed flex px-4 w-full bg-[#31404a] text-white h-[30px] justify-between items-center z-100">
        <span class="opacity-70">{{ formatted }}</span>
        <span class="opacity-70 hidden md:flex">support@pharosly.com</span>
        <span class="opacity-70">English</span>
    </div>
</template>
