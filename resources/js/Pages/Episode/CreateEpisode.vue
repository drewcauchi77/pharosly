<script setup>
import InputField from "@/Components/Fields/InputField.vue";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import ErrorMessages from "@/Components/Statuses/ErrorMessages.vue";
import Loading from "@/Components/Icons/Loading.vue";

defineProps({
    errors: Object
});

const form = useForm({
    title: '',
    description: '',
    video_link: ''
});

const submit = () => {
    form.post(route('episodes.store'));
};
</script>

<template>
    <Head title="Create Episode" />

    <div class="min-h-screen flex items-center justify-center bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <form @submit.prevent="submit">
                <div class="space-y-4">
                    <InputField
                        v-model="form.title"
                        label="Title"
                        type="text"
                        placeholder="New Episode Title"
                        icon="font"
                        :isRequired="true"
                    />

                    <InputField
                        v-model="form.description"
                        label="Description"
                        type="text"
                        placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam in pharetra mauris."
                        icon="align-left"
                        :isRequired="true"
                    />

                    <InputField
                        v-model="form.video_link"
                        label="Video Link"
                        type="text"
                        placeholder="https://youtu.be/dQw4w9WgXcQ?si=Lhn91wA5oD0Ivcls"
                        icon="video"
                        :isRequired="true"
                    />

                    <ErrorMessages :errors="errors" />

                    <PrimaryButton type="submit" :disabled="form.processing">
                        <span v-if="form.processing" class="inline-flex items-center">
                            <Loading />
                            Creating...
                        </span>

                        <span v-else>Create</span>
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>
