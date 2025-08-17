<script setup>
import AuthLayout from "@/Layouts/AuthLayout.vue";
import InputField from "@/Components/Fields/InputField.vue";
import FormTitle from "@/Components/Forms/FormTitle.vue";
import ErrorMessages from "@/Components/Elements/ErrorMessages.vue";
import LinkItem from "@/Components/Elements/LinkItem.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import CheckboxField from "@/Components/Fields/CheckboxField.vue";
import { useForm } from "@inertiajs/vue3";

defineProps({
    errors: Object
});

const form = useForm({
    email: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post(route('login.store'), {
        onFinish: () => form.reset('password')
    });
};
</script>

<template>
    <Head title="Login" />

    <AuthLayout>
        <FormTitle title="Welcome Back!" description="Sign in to continue to Pharosly." />

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
                    v-model="form.password"
                    label="Password"
                    id="password"
                    type="password"
                    placeholder="••••••••"
                    icon="lock"
                    :isRequired="true"
                />
            </div>

            <div class="flex items-center justify-between mb-5 space-x-4">
                <CheckboxField
                    v-model="form.remember"
                    label="Remember me"
                    id="remember-me"
                />

                <LinkItem route-name="password.request" class="text-right">
                    Forgot your password?
                </LinkItem>
            </div>

            <ErrorMessages :errors="errors" />

            <SubmitButton :is-disabled="form.processing">
                <template v-slot:disable>
                    Signing in...
                </template>
                <template v-slot:able>
                    Sign in
                </template>
            </SubmitButton>

            <div class="text-center">
                <p class="text-sm">
                    Don't have an account?
                    <LinkItem route-name="register.create">
                        Sign up
                    </LinkItem>
                </p>
            </div>
        </form>
    </AuthLayout>
</template>
