<script setup>
import PageTitle from "@/Components/Elements/PageTitle.vue";
import LinkItem from "@/Components/Elements/LinkItem.vue";
import TableBody from "@/Components/Lists/TableBody.vue";
import PaginationLinks from "@/Components/Lists/PaginationLinks.vue";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import InputField from "@/Components/Fields/InputField.vue";
import {router, useForm} from "@inertiajs/vue3";
import {ref} from "vue";
import ErrorMessages from "@/Components/Statuses/ErrorMessages.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import PageHeader from "@/Components/Elements/PageHeader.vue";

const openModal = ref(false);
const workspaceIdToDelete = ref(null);
const showPasswordSection = ref(false);

defineProps({
    workspaces: Object,
    errors: Object
});

const columns = [
    { key: 'name' },
    { key: 'episodes' },
    { key: 'series' },
    { key: 'labels' },
    { key: 'actions' }
];

const switchWorkspace = (episodeId) => {
    router.post(route('workspaces.switch', episodeId));
};

const form = useForm({
    password: ''
});

const openDeleteModal = (id) => {
    openModal.value = true;
    workspaceIdToDelete.value = id;
};

const closeDeleteModal = () => {
    form.password = '';
    openModal.value = false;
    showPasswordSection.value = false;
    workspaceIdToDelete.value = null;
};

const deleteWorkspace = () => {
    form.delete(route('workspaces.destroy', workspaceIdToDelete.value), {
        onFinish: () => form.reset('password'),
        onSuccess: () => closeDeleteModal()
    });
}
</script>

<template>
    <Head title="Workspaces" />

    <PageHeader
        title="Workspaces"
        description="A list of workspaces that you have created and you can also switch workspaces."
        route-name="workspaces.create"
    >
        <i class="fa-solid fa-plus text-xs"></i>
        <span class="!font-medium whitespace-nowrap">New Workspace</span>
    </PageHeader>

    <div class="w-full overflow-x-auto">
        <table class="w-full mt-5 rounded-t-lg border-separate border border-light-blue border-spacing-0 min-w-3xl">
            <thead class="bg-light-blue">
                <tr class="text-sm text-left">
                    <th class="p-3 border border-light-blue !font-medium">Name</th>
                    <th class="p-3 border border-light-blue !font-medium">Episodes</th>
                    <th class="p-3 border border-light-blue !font-medium">Series</th>
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
                        <div class="relative rounded-full ring-2 ring-offset-1 ring-text bg-white p-0.25 flex-none">
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

                <template #cell-labels="{ item }">
                    <div class="flex flex-wrap gap-1">
                        <template v-if="item.labels && JSON.parse(item.labels).length > 0">
                            <span
                                class="text-xs bg-input-icon-color px-2 py-1 rounded-sm"
                                v-for="(label, index) in JSON.parse(item.labels)"
                                :key="index"
                            >
                                {{ label }}
                            </span>
                        </template>
                        <span v-else class="text-sm text-gray-400">-</span>
                    </div>
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
    </div>

    <PaginationLinks :paginator="workspaces" />

    <div class="hidden fixed top-0 left-0 w-full h-full z-200 bg-alternate-opaque" :class="{ '!block' : openModal }" @click.self="closeDeleteModal">
        <div class="w-full max-w-lg h-fit p-5 absolute top-0 bottom-0 left-0 right-0 m-auto">
            <div class="p-5 bg-white rounded-sm">
                <h3 class="text-center mb-5 !text-lg !font-bold">Are you sure?</h3>

                <p class="mb-5 text-sm">
                    Deleting a workspace is a <strong class="!font-bold">destructive</strong> action. All data that is attributed to this workspace will also be deleted.
                    Users will not have access to this workspace any longer.
                </p>

                <div class="flex gap-4 flex-col sm:flex-row">
                    <PrimaryButton :is-secondary="true" @click="closeDeleteModal">Cancel</PrimaryButton>
                    <PrimaryButton @click="showPasswordSection = true">Yes</PrimaryButton>
                </div>

                <form @submit.prevent="deleteWorkspace" class="flex flex-col mt-5" v-if="showPasswordSection">
                    <p class="mb-4 text-sm">To confirm deletion, please enter your password.</p>

                    <InputField
                        v-model="form.password"
                        label="Password"
                        id="password"
                        type="password"
                        placeholder="••••••••"
                        icon="lock"
                        :isRequired="true"
                    />

                    <ErrorMessages :errors="errors" />

                    <SubmitButton
                        :is-disabled="form.processing"
                        class="!bg-error hover:bg-error-hover !text-error-text !font-bold">
                        <template v-slot:disable>
                            Deleting...
                        </template>
                        <template v-slot:able>
                            Confirm Deletion
                        </template>
                    </SubmitButton>
                </form>
            </div>
        </div>
    </div>
</template>
