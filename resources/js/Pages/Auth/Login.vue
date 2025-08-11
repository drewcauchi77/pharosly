<script setup>
import InputField from "@/Components/Fields/InputField.vue";
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import Header from "@/Components/Forms/Header.vue";
import Loading from "@/Components/Icons/Loading.vue";

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
    <div class="min-h-screen flex items-center justify-center bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <Header title="Sign in to your account" description="Welcome back! Please enter your details." />

            <form @submit.prevent="submit" class="mt-8 space-y-6 bg-white rounded-xl shadow-lg p-8">
                <div class="space-y-4">
                    <InputField
                        v-model="form.email"
                        label="Email"
                        type="email"
                        placeholder="john.doe@gmail.com"
                        icon="envelope"
                    />

                    <InputField
                        v-model="form.password"
                        label="Password"
                        type="password"
                        placeholder="••••••••"
                        icon="lock"
                    />
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            id="remember-me"
                            name="remember-me"
                            type="checkbox"
                            class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                        >

                        <label for="remember-me" class="ml-2 block text-sm text-slate-700">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <PrimaryButton type="submit" :disabled="form.processing">
                    <span v-if="form.processing" class="inline-flex items-center">
                        <Loading />
                        Signing in...
                    </span>

                    <span v-else>Sign in</span>
                </PrimaryButton>

                <div class="text-center">
                    <p class="text-sm text-slate-600">
                        Don't have an account?
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
                            Sign up
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</template>
