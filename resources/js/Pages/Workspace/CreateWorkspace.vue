<script setup>
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import InputField from "@/Components/Fields/InputField.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    name: '',
    labels: '',
    internal_domain: '',
    domain: '',
    path: ''
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

        <InputField
            v-model="form.labels"
            label="Workspace Labels (Optional)"
            id="labels"
            type="text"
            placeholder="AI, E-commerce, Certification"
            icon="tags"
        />

        <InputField
            v-model="form.internal_domain"
            label="Workspace Internal Domain"
            id="domain"
            type="text"
            placeholder="acme-space.pharosly.com"
            icon="globe"
        />

        <InputField
            v-model="form.domain"
            label="Your Domain"
            id="domain"
            type="text"
            placeholder="acme.com"
            icon="globe"
        />

        <InputField
            v-model="form.path"
            label="Your Domain Path"
            id="path"
            type="text"
            placeholder="/academy/"
            icon="sitemap"
        />

        <PrimaryButton type="submit">
            Create
        </PrimaryButton>
    </form>
</template>
