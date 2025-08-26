<script setup>
import TableBody from "@/Components/Lists/TableBody.vue";
import LinkItem from "@/Components/Elements/LinkItem.vue";
import PageTitle from "@/Components/Elements/PageTitle.vue";
import PaginationLinks from "@/Components/Lists/PaginationLinks.vue";
import {useSuccessProps} from "@/Composables/success.js";

const props = defineProps({
    episodes: Object,
    workspace: String,
    success: Object
});

const columns = [
    { key: 'title' },
    { key: 'description' },
    {
        key: 'updated_at',
        formatter: (v) => new Date(v).toLocaleDateString(),
    },
];

useSuccessProps(props.success);
</script>

<template>
    <Head title="Episodes" />
<!--    <Link :href="route('modules.create')" class="block mb-8 text-indigo-700">Create Episode</Link>-->

    <PageTitle title="Episodes" description="A list of episodes that you have created." class="text-left" />

    <table class="w-full mt-5 rounded-t-lg border-separate border border-light-blue border-spacing-0">
        <thead class="bg-light-blue">
            <tr class="text-sm text-left">
                <th class="p-3 border border-light-blue">Title</th>
                <th class="p-3 border border-light-blue">Description</th>
                <th class="p-3 border border-light-blue">Last Updated</th>
            </tr>
        </thead>

        <TableBody
            :items="episodes.data"
            :columns="columns"
        >
            <template #cell-title="{ item }">
                <LinkItem routeName="episodes.show" :routeValue="item.id">{{ item.title }}</LinkItem>
            </template>

            <template #cell-description="{ value }">
                <span class="line-clamp-2 text-sm">{{ value }}</span>
            </template>

            <template #cell-updated_at="{ value }">
                <span class="text-sm">{{ new Date(value).toLocaleString() }}</span>
            </template>

            <template #empty>
                Nothing to show yet.
            </template>
        </TableBody>
    </table>

    <PaginationLinks :paginator="episodes" />
</template>
