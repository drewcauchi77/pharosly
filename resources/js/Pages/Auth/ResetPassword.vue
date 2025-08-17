<script setup>
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import PageTitle from "@/Components/Elements/PageTitle.vue";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import InputField from "@/Components/Fields/InputField.vue";
import ErrorMessages from "@/Components/Elements/ErrorMessages.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    errors: Object,
    token: String,
    email: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: ''
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation')
    });
};
</script>

<template>
    <Head title="Reset Password" />

    <AuthLayout>
        <PageTitle title="Reset password!" description="Enter your new password here." />

        <form @submit.prevent="submit">
            <div class="space-y-4">
                <InputField
                    v-model="form.password"
                    label="Password"
                    id="password"
                    type="password"
                    placeholder="••••••••"
                    icon="lock"
                    :isRequired="true"
                />

                <InputField
                    v-model="form.password_confirmation"
                    label="Confirm Password"
                    id="confirm-password"
                    type="password"
                    placeholder="••••••••"
                    icon="lock"
                    :isRequired="true"
                />
            </div>

            <ErrorMessages :errors="errors" />

            <SubmitButton :is-disabled="form.processing">
                <template v-slot:disable>
                    Resetting password...
                </template>
                <template v-slot:able>
                    Reset
                </template>
            </SubmitButton>
        </form>
    </AuthLayout>
</template>
