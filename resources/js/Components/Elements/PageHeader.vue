<script setup>
import PageTitle from "@/Components/Elements/PageTitle.vue";
import LinkItem from "@/Components/Elements/LinkItem.vue";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";

defineProps({
    title: String,
    description: String,
    routeName: String
});
</script>

<template>
    <div class="md:flex gap-4">
        <PageTitle :title="title" :description="description" class="text-left grow" />

        <LinkItem :routeName="routeName" class="h-fit">
            <PrimaryButton class="flex gap-2 max-w-fit" tabindex="-1">
                <slot />
            </PrimaryButton>
        </LinkItem>
    </div>
</template>
