<script setup>
import LinkItem from "@/Components/Elements/LinkItem.vue";

defineProps({
    title: String,
    items: Array
});
</script>

<template>
    <div>
        <div>
            <span class="uppercase text-[11px] !font-medium py-2 block text-[#919da9]">{{ title }}</span>
            <span class="hidden">...</span>
        </div>

        <ul>
            <li v-for="(item, index) in items" :key="index" class="py-3">
                <LinkItem :routeName="item.route" :method="item.method" class="flex gap-3 items-center !text-[#6d7080] !font-normal">
                    <i :class="`fa-solid fa-${item.icon} text-[#6d7080]`"></i>
                    <span>{{ item.name }}</span>
                </LinkItem>
            </li>
        </ul>
    </div>
</template>
