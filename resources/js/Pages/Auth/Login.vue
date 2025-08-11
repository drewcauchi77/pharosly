<script setup>
import InputField from "@/Components/Fields/InputField.vue";
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";

const form = useForm({
    email: '',
    password: ''
});
</script>

<template>
    <Head title="Login" />
    <div class="relative h-full">
        <form class="flex items-center absolute top-0 bottom-0 left-0 right-0 m-auto h-fit flex-col w-full max-w-100">
            <InputField v-model="form.email" label="Email" type="email" placeholder="john.doe@gmail.com" icon="envelope" class="mb-4 w-full" />

            <InputField v-model="form.password" label="Password" type="password" placeholder="••••••••" icon="lock" class="mb-4 w-full" />

            <PrimaryButton>Login</PrimaryButton>
        </form>
    </div>
</template>
