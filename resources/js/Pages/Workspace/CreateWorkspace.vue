<script setup>
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import InputField from "@/Components/Fields/InputField.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    name: ''
});

const submit = () => {
    form.post(route('workspaces.store'));
};
</script>

<template>
    <Head title="New Workspace" />

    <form @submit.prevent="submit">
        <InputField
            v-model="form.name"
            label="Workspace Name"
            id="workspace"
            type="text"
            placeholder="Acme Space"
            icon="briefcase"
            :isRequired="true"
        />

        <PrimaryButton type="submit">
            Create
        </PrimaryButton>
    </form>
</template>
