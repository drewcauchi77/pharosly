<script setup>
import InputField from "@/Components/Fields/InputField.vue";
import ErrorMessages from "@/Components/Statuses/ErrorMessages.vue";
import PageTitle from "@/Components/Elements/PageTitle.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import LinkItem from "@/Components/Elements/LinkItem.vue";
import { useForm } from "@inertiajs/vue3";

defineProps({
    errors: Object
});

const form = useForm({
    email: '',
    workspace: '',
    password: '',
    password_confirmation: ''
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation')
    });
};
</script>

<template>
    <Head title="Register" />

    <PageTitle title="Join Us!" description="Sign up to get started with Pharosly." />

    <form @submit.prevent="submit">
        <div class="space-y-4">
            <InputField
                v-model="form.email"
                label="Email"
                id="email"
                type="email"
                placeholder="john.doe@gmail.com"
                icon="envelope"
                :isRequired="true"
            />

            <InputField
                v-model="form.workspace"
                label="Workspace"
                id="workspace"
                type="text"
                placeholder="Acme Space"
                icon="briefcase"
                :isRequired="true"
            />

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
                Signing up...
            </template>
            <template v-slot:able>
                Sign up
            </template>
        </SubmitButton>

        <div class="text-center">
            <p class="text-sm text-slate-600">
                Already have an account?
                <LinkItem route-name="login">
                    Sign in
                </LinkItem>
            </p>
        </div>
    </form>
</template>
