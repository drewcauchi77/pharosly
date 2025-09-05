<script setup>
defineProps({
    paginator: Object,
});

const makeLabel = (label) => {
    if (label.includes("Previous")) {
        return "Previous";
    } else if (label.includes("Next")) {
        return "Next";
    } else {
        return label;
    }
};
</script>

<template>
    <div class="flex justify-center items-start p-3 flex-col-reverse md:flex-row md:justify-between border-b-2 border-x-2 rounded-b-sm border-light-blue">
        <p v-if="(paginator.total && paginator.total <= 1) || !paginator.total" class="text-alternate text-sm self-center text-center">
            Showing <strong class="!font-medium">{{ paginator.total }}</strong> {{ paginator.total == 1 ? 'result' : 'results' }}
        </p>
        <p v-else class="text-alternate text-sm self-center text-center">
            Showing <strong class="!font-medium">{{ paginator.from }}</strong> to <strong class="!font-medium">{{ paginator.to }}</strong> of <strong class="!font-medium">{{ paginator.total }}</strong> results
        </p>

        <div class="flex items-center text-sm self-center mb-3 md:mb-0 flex-wrap justify-center">
            <div v-for="(link, i) in paginator.links" :key="i" class="m-1">
                <component
                    :is="link.url ? 'Link' : 'span'"
                    :href="link.url"
                    v-html="makeLabel(link.label)"
                    class="h-8 grid place-items-center rounded-sm  border-1 border-light-blue px-3 text-center"
                    :class="{
                        'text-primary hover:bg-light-blue': link.url && !link.active,
                        'text-alternate': !link.url,
                        '!font-bold text-white bg-primary cursor-default pointer-events-none': link.active,
                    }"
                />
            </div>
        </div>
    </div>
</template>
