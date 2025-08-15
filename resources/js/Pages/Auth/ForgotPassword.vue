<script setup>
import AuthLayout from "@/Layouts/AuthLayout.vue";
import FormTitle from "@/Components/Forms/FormTitle.vue";
import { useForm } from "@inertiajs/vue3";
import InputField from "@/Components/Fields/InputField.vue";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import Loading from "@/Components/Icons/Loading.vue";
import ErrorMessages from "@/Components/Elements/ErrorMessages.vue";
import LinkItem from "@/Components/Elements/LinkItem.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";

defineProps({
    errors: Object
});

const form = useForm({
    email: ''
});

const submit = () => {
    form.post(route('forgot-password.store'));
};
</script>

<template>
    <Head title="Forgot Password" />

    <AuthLayout>
        <FormTitle title="No Problem!" description="Enter your email and you will receive a new password." />

        <form @submit.prevent="submit">
            <div class="space-y-4">
                <InputField
                    v-model="form.email"
                    label="Email"
                    type="email"
                    placeholder="john.doe@example.com"
                    icon="envelope"
                    :isRequired="true"
                />
            </div>

            <ErrorMessages :errors="errors" />

            <SubmitButton :is-disabled="form.processing">
                <template v-slot:disable>
                    Sending...
                </template>
                <template v-slot:able>
                    Send
                </template>
            </SubmitButton>

            <LinkItem route-name="login.create" class="block text-center">
                Back to login
            </LinkItem>
        </form>
    </AuthLayout>
</template>
