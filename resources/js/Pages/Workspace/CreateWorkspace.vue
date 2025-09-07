<script setup>
import PrimaryButton from "@/Components/Elements/PrimaryButton.vue";
import InputField from "@/Components/Fields/InputField.vue";
import {useForm} from "@inertiajs/vue3";
import PageTitle from "@/Components/Elements/PageTitle.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import {ref} from "vue";

const labelsInput = ref('');

const form = useForm({
    name: '',
    labels: [],
    internal_domain: '',
    domain: '',
    path: '/'
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

    <PageTitle title="Create Workspace" description="You can create a new workspace with all the details required." class="text-left" />

    <form @submit.prevent="submit">
        <InputField
            v-model="form.name"
            label="Workspace Name"
            id="workspace"
            type="text"
            placeholder="Acme Space"
            icon="briefcase"
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
                    v-model="form.internal_domain"
                    label="Pharosly Domain"
                    id="domain"
                    type="text"
                    placeholder="acme-space.pharosly.com"
                    icon="globe"
                    :is-required="true"
                />

                <InputField
                    v-model="form.domain"
                    label="Custom Domain"
                    id="domain"
                    type="text"
                    placeholder="acme.com"
                    icon="globe"
                />

                <InputField
                    v-model="form.path"
                    label="Custom Path"
                    id="path"
                    type="text"
                    placeholder="/academy/"
                    icon="sitemap"
                />
            </div>
        </fieldset>

        <div class="flex gap-5 justify-end">
            <PrimaryButton :is-secondary="true" class="!w-fit !h-fit" @click="back">
                Cancel
            </PrimaryButton>

            <SubmitButton :is-disabled="form.processing" class="!w-fit">
                <template v-slot:disable>
                    Creating workspace...
                </template>
                <template v-slot:able>
                    Create
                </template>
            </SubmitButton>
        </div>
    </form>
</template>
