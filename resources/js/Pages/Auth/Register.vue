<script setup>
import InputField from "@/Components/Fields/InputField.vue";
import ErrorMessages from "@/Components/Elements/ErrorMessages.vue";
import FormTitle from "@/Components/Forms/FormTitle.vue";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import { useForm } from "@inertiajs/vue3";
import LinkItem from "@/Components/Elements/LinkItem.vue";

defineProps({
    errors: Object
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
});

const submit = () => {
    form.post(route('register.store'), {
        onFinish: () => form.reset('password', 'password_confirmation')
    });
};
</script>

<template>
    <Head title="Register" />

    <AuthLayout>
        <FormTitle title="Join Us!" description="Sign up to get started with Pharosly." />

        <form @submit.prevent="submit">
            <div class="space-y-4">
                <InputField
                    v-model="form.name"
                    label="Name"
                    type="text"
                    placeholder="John Doe"
                    icon="user"
                    :isRequired="true"
                />

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

                <InputField
                    v-model="form.password_confirmation"
                    label="Confirm Password"
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
                    <LinkItem route-name="login.create">
                        Sign in
                    </LinkItem>
                </p>
            </div>
        </form>
    </AuthLayout>
</template>
