<script setup>
import PageTitle from "@/Components/Elements/PageTitle.vue";
import LinkItem from "@/Components/Elements/LinkItem.vue";
import TableBody from "@/Components/Lists/TableBody.vue";
import PaginationLinks from "@/Components/Lists/PaginationLinks.vue";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import {router, useForm} from "@inertiajs/vue3";
import {ref} from "vue";

const openModal = ref(false);

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
};

const form = useForm({
    workspaceId: null,
    password: ''
});

const openDeleteModal = (id) => {
    openModal.value = true;
    form.workspaceId = id;
};

const deleteWorkspace = () => {
    form.delete(route('workspaces.destroy', form.workspaceId));
}
</script>

<template>
    <Head title="Workspaces" />

    <PageTitle title="Workspaces" description="A list of workspaces that you have created and you can also switch workspaces." class="text-left" />

    <LinkItem routeName="workspaces.create">New Workspace</LinkItem>

    <table class="w-full mt-5 rounded-t-lg border-separate border border-light-blue border-spacing-0">
        <thead class="bg-light-blue">
            <tr class="text-sm text-left">
                <th class="p-3 border border-light-blue !font-medium">Name</th>
                <th class="p-3 border border-light-blue !font-medium">Episodes</th>
                <th class="p-3 border border-light-blue !font-medium">Series</th>
                <th class="p-3 border border-light-blue !font-medium">Users</th>
                <th class="p-3 border border-light-blue !font-medium">Labels</th>
                <th class="p-3 border border-light-blue !font-medium">Actions</th>
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

                    <i class="fa-solid fa-trash text-primary cursor-pointer hover:text-primary-hover"
                        @click="openDeleteModal(item.id)"
                    ></i>
                </div>
            </template>

            <template #empty>
                Nothing to show yet.
            </template>
        </TableBody>
    </table>

    <PaginationLinks :paginator="workspaces" />

    <div class="hidden fixed top-0 left-0 w-full h-full z-200 bg-alternate-opaque" :class="{ '!block' : openModal }">
        <div class="bg-white w-95 h-fit p-5 absolute top-0 bottom-0 left-0 right-0 m-auto">
            <h1>Are you sure?</h1>

            <p>
                Deleting a workspace is a <strong>destructive</strong> action. All data that is attributed to this workspace will also be deleted.
                Users will not have access to this workspace any longer.
            </p>

            <form @submit.prevent class="flex flex-col">
                <PrimaryButton @click="openModal = !openModal">Cancel</PrimaryButton>
                <input type="password" placeholder="Enter your password" v-model="form.password">
                <PrimaryButton class="!bg-red-500 !text-white" :disabled="form.password === ''" @click="deleteWorkspace">Delete</PrimaryButton>
            </form>
        </div>
    </div>
</template>
