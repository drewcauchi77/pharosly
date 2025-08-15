<script setup>
import Loading from "@/Components/Icons/Loading.vue";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import InputField from "@/Components/Fields/InputField.vue";
import ErrorMessages from "@/Components/Elements/ErrorMessages.vue";
import FormTitle from "@/Components/Forms/FormTitle.vue";
import { useForm } from "@inertiajs/vue3";

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
    <div class="min-h-screen flex items-center justify-center bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <FormTitle title="Sign up" description="Create an account by entering the below details." />

            <form @submit.prevent="submit" class="mt-8 space-y-6 bg-white rounded-xl shadow-lg p-8">
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

                <PrimaryButton type="submit" :disabled="form.processing">
                    <span v-if="form.processing" class="inline-flex items-center">
                        <Loading />
                        Signing up...
                    </span>

                    <span v-else>Sign up</span>
                </PrimaryButton>

                <div class="text-center">
                    <p class="text-sm text-slate-600">
                        Already have an account?
                        <Link :href="route('login.create')" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
                            Sign in
                        </Link>
                    </p>
                </div>
            </form>
        </div>
    </div>
</template>
