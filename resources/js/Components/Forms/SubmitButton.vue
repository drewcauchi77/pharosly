<script setup>
import Loading from "@/Components/Icons/Loading.vue";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";

defineProps({
    isDisabled: Boolean
});
</script>

<template>
    <PrimaryButton type="submit" :disabled="isDisabled" class="mb-5">
        <span v-if="isDisabled" class="inline-flex items-center !font-medium">
            <Loading />
            <slot name="disable" />
        </span>

        <span v-else class="!font-medium">
            <slot name="able" />
        </span>
    </PrimaryButton>
</template>
