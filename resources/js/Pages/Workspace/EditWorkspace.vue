<script setup>
import CreateWorkspace from "@/Pages/Workspace/CreateWorkspace.vue";
import {computed} from "vue";

const props = defineProps({
    workspace: Object
});

const workspaceValues = computed(() => {
    return {
        name: props.workspace.name,
        labels: JSON.parse(props.workspace.labels),
        subdomain: props.workspace.subdomain,
        domain: props.workspace.domain,
        path: props.workspace.path
    }
})
</script>

<template>
    <Head :title="workspace.name" />

    <CreateWorkspace
        title="Update Workspace"
        description="You can update and change some or all of the workspace details."
        button-name="Update"
        disabled-button-name="Updating workspace..."
        :preset-values="workspaceValues"
        :errors="{}"
    />
</template>
