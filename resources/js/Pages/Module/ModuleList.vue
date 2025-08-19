<script setup>
import TableBody from "@/Components/Lists/TableBody.vue";
import LinkItem from "@/Components/Elements/LinkItem.vue";
import PageTitle from "@/Components/Elements/PageTitle.vue";
import PaginationLinks from "@/Components/Lists/PaginationLinks.vue";

defineProps({
    modules: Object,
    workspace: String,
});

const columns = [
    { key: 'title' },
    { key: 'description' },
    {
        key: 'updated_at',
        formatter: (v) => new Date(v).toLocaleDateString(),
    },
];
</script>

<template>
    {{ console.log(workspace) }}
    <Head title="Modules" />
<!--    <Link :href="route('modules.create')" class="block mb-8 text-indigo-700">Create Module</Link>-->

    <div class="p-5">
        <PageTitle title="Modules" description="A list of modules that you have created." class="text-left" />

        <table class="w-full mt-5 rounded-t-lg border-separate border border-light-blue border-spacing-0">
            <thead class="bg-light-blue">
                <tr class="text-sm text-left">
                    <th class="p-3 border border-light-blue">Title</th>
                    <th class="p-3 border border-light-blue">Description</th>
                    <th class="p-3 border border-light-blue">Last Updated</th>
                </tr>
            </thead>

            <TableBody
                :items="modules.data"
                :columns="columns"
            >
                <template #cell-title="{ item }">
                    <LinkItem routeName="modules.show" :routeValue="item.id">{{ item.title }}</LinkItem>
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

        <PaginationLinks :paginator="modules" />
    </div>
</template>
