<script setup>
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import InputField from "@/Components/Fields/InputField.vue";
import {useForm} from "@inertiajs/vue3";
import PageTitle from "@/Components/Elements/PageTitle.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import {ref} from "vue";
import ErrorMessages from "@/Components/Statuses/ErrorMessages.vue";

const props = defineProps({
    title: String,
    description: String,
    buttonName: String,
    disabledButtonName: String,
    presetValues: Object,
    errors: Object
});

const labelsInput = ref('');

const form = useForm({
    name: props.presetValues?.name ?? '',
    labels: props.presetValues?.labels ?? [],
    subdomain: props.presetValues?.subdomain ?? '',
    domain: props.presetValues?.domain ?? '',
    path: props.presetValues?.path ?? '/'
});

const submit = () => {
    form.post(route('workspaces.store'));
};

const back = () => {
    window.history.back();
};

const splitToArray = (e) => {
    if (e.code === 'Comma') {
        const inputValue = e.target.value.slice(0, -1).trim();
        form.labels = [...form.labels, inputValue];
        labelsInput.value = '';
    }
};

const removeItem = (label) => {
    const labelIndex = form.labels.indexOf(label);
    form.labels.splice(labelIndex, 1);
};
</script>

<template>
    <Head title="New Workspace" />

    <PageTitle
        :title="title ?? 'Create Workspace'"
        :description="description ?? 'You can create a new workspace with all the details required.'"
        class="text-left" />

    <form @submit.prevent="submit">
        <InputField
            v-model="form.name"
            label="Workspace Name"
            id="name"
            type="text"
            placeholder="Acme Space"
            icon="briefcase"
            :has-error="errors?.hasOwnProperty('name')"
            :is-required="true"
        />

        <fieldset class="grid md:grid-cols-2 md:gap-5">
            <div>
                <InputField
                    v-model="labelsInput"
                    label="Workspace Labels (up to 5 labels)"
                    id="labels"
                    type="text"
                    placeholder="AI, E-commerce, Certification"
                    icon="tags"
                    :has-error="errors?.hasOwnProperty('labels')"
                    @keyup="splitToArray"
                />

                <template v-if="form.labels.length > 0">
                    <span class="block text-sm text-text mb-2">Selected Labels: </span>

                    <div class="flex gap-2">
                        <div v-for="(label, index) in form.labels" :key="index" class="flex gap-3 rounded-md bg-input-icon-color py-2 px-3 w-fit items-center">
                            <span class="leading-3">{{ label }}</span>

                            <button class="cursor-pointer text-[10px]" @click="removeItem(label)">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <div>
                <InputField
                    v-model="form.subdomain"
                    label="Our Subdomain"
                    id="subdomain"
                    type="text"
                    placeholder="acme-space"
                    icon="globe"
                    :has-error="errors?.hasOwnProperty('subdomain')"
                    :is-required="true"
                />

                <InputField
                    v-model="form.domain"
                    label="Custom Domain"
                    id="domain"
                    type="text"
                    placeholder="acme.com"
                    icon="globe"
                    :has-error="errors?.hasOwnProperty('domain')"
                />

                <InputField
                    v-model="form.path"
                    label="Custom Path"
                    id="path"
                    type="text"
                    placeholder="/academy/"
                    icon="sitemap"
                    :has-error="errors?.hasOwnProperty('path')"
                />

                <ErrorMessages :errors="errors" />
            </div>
        </fieldset>

        <div class="flex gap-5 justify-end">
            <PrimaryButton :is-secondary="true" class="!w-fit !h-fit" @click="back">
                Cancel
            </PrimaryButton>

            <SubmitButton :is-disabled="form.processing" class="!w-fit">
                <template v-slot:disable>
                    {{ disabledButtonName ?? 'Creating workspace...' }}
                </template>
                <template v-slot:able>
                    {{ buttonName ?? 'Create' }}
                </template>
            </SubmitButton>
        </div>
    </form>
</template>
