<script setup>
import AuthLayout from "@/Layouts/AuthLayout.vue";
import PageTitle from "@/Components/Elements/PageTitle.vue";
import InputField from "@/Components/Fields/InputField.vue";
import ErrorMessages from "@/Components/Elements/ErrorMessages.vue";
import LinkItem from "@/Components/Elements/LinkItem.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import { useForm } from "@inertiajs/vue3";
import StatusMessages from "@/Components/Elements/StatusMessages.vue";

defineProps({
    errors: Object,
    status: String
});

const form = useForm({
    email: ''
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Head title="Forgot Password" />

    <PageTitle title="No Problem!" description="Enter your email and you will receive a new password." />

    <form @submit.prevent="submit">
        <div class="space-y-4">
            <InputField
                v-model="form.email"
                label="Email"
                id="email"
                type="email"
                placeholder="john.doe@example.com"
                icon="envelope"
                :isRequired="true"
            />
        </div>

        <ErrorMessages :errors="errors" />

        <StatusMessages :status="status" />

        <SubmitButton :is-disabled="form.processing">
            <template v-slot:disable>
                Sending...
            </template>
            <template v-slot:able>
                Send
            </template>
        </SubmitButton>

        <LinkItem route-name="login" class="block text-center">
            Back to login
        </LinkItem>
    </form>
</template>
