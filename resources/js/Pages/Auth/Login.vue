<script setup>
import InputField from "@/Components/Fields/InputField.vue";
import FormTitle from "@/Components/Forms/FormTitle.vue";
import ErrorMessages from "@/Components/Elements/ErrorMessages.vue";
import LinkItem from "@/Components/Elements/LinkItem.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import { useForm } from "@inertiajs/vue3";

defineProps({
    errors: Object
});

const form = useForm({
    email: '',
    password: ''
});

const submit = () => {
    form.post(route('login.store'));
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
                    type="email"
                    placeholder="john.doe@gmail.com"
                    icon="envelope"
                    :isRequired="true"
                />

                <InputField
                    v-model="form.password"
                    label="Password"
                    type="password"
                    placeholder="••••••••"
                    icon="lock"
                    :isRequired="true"
                />
            </div>

            <div class="flex items-center justify-between mb-5 space-x-4">
                <div class="flex items-center">
                    <input
                        id="remember-me"
                        name="remember-me"
                        type="checkbox"
                        class="h-4 w-4 rounded-sm border-slate-300 text-primary focus:ring-2 focus:ring-offset-1 focus:ring-primary"
                    >

                    <label for="remember-me" class="ml-2 block text-sm text-text">
                        Remember me
                    </label>
                </div>

                <LinkItem route-name="register.create" class="text-right">
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
