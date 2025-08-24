<script setup>
import PageTitle from "@/Components/Elements/PageTitle.vue";
import LinkItem from "@/Components/Elements/LinkItem.vue";
import TableBody from "@/Components/Lists/TableBody.vue";
import PaginationLinks from "@/Components/Lists/PaginationLinks.vue";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import { router } from "@inertiajs/vue3";

defineProps({
    workspaces: Object
});

const columns = [
    { key: 'name' },
    { key: 'episodes' },
    { key: 'series' },
    { key: 'users' },
    { key: 'labels' },
    { key: 'actions' }
];

const switchWorkspace = (episodeId) => {
    router.post(route('workspaces.switch', episodeId));
}
</script>

<template>
    {{ console.log(workspaces) }}
    <Head title="Workspaces" />

    <PageTitle title="Workspaces" description="A list of workspaces that you have created." class="text-left" />

    <LinkItem routeName="workspaces.create">New Workspace</LinkItem>

    <table class="w-full mt-5 rounded-t-lg border-separate border border-light-blue border-spacing-0">
        <thead class="bg-light-blue">
            <tr class="text-sm text-left">
                <th class="p-3 border border-light-blue">Name</th>
                <th class="p-3 border border-light-blue">Episodes</th>
                <th class="p-3 border border-light-blue">Series</th>
                <th class="p-3 border border-light-blue">Users</th>
                <th class="p-3 border border-light-blue">Labels</th>
                <th class="p-3 border border-light-blue">Actions</th>
            </tr>
        </thead>

        <TableBody
            :items="workspaces.data"
            :columns="columns"
        >
            <template #cell-name="{ item }">
                <div class="flex items-center gap-3">
                    <div class="relative rounded-full ring-2 ring-offset-1 ring-text bg-white p-0.25">
                        <img :src="item.image" :alt="item.name" class="rounded-full w-10 h-10 bg-gray-400"/>
                    </div>

                    <span class="text-sm">{{ item.name }}</span>
                </div>
            </template>

            <template #cell-episodes="{ item }">
                <span class="text-sm">{{ item.episodesCount }}</span>
            </template>

            <template #cell-series="{ item }">
                <span class="text-sm">-</span>
            </template>

            <template #cell-users="{ item }">
                <span class="text-sm">{{ item.usersCount }}</span>
            </template>

            <template #cell-labels="{ value }">
                <span class="text-sm">Labels</span>
            </template>

            <template #cell-actions="{ item }">
                <div class="flex gap-3 items-center">
                    <PrimaryButton class="!w-fit" v-if="item.isCurrent" disabled>
                        Current Workspace
                    </PrimaryButton>

                    <PrimaryButton class="!w-fit" @click="switchWorkspace(item.id)" v-else>
                        Switch Workspace
                    </PrimaryButton>

                    <LinkItem routeName="workspaces.edit" :routeValue="item.id">
                        <i class="fa-solid fa-pencil"></i>
                    </LinkItem>

                    <i class="fa-solid fa-trash text-primary cursor-pointer hover:text-primary-hover"></i>
                </div>
            </template>

            <template #empty>
                Nothing to show yet.
            </template>
        </TableBody>
    </table>

    <PaginationLinks :paginator="workspaces" />
</template>
