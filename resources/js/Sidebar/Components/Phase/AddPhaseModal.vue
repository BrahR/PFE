<script setup lang="ts">
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

import { useForm } from "@inertiajs/vue3";

const emits = defineEmits<{
    (event: 'close'): void
}>()

const props = defineProps<{
    show: boolean;
    project: Project | null;
}>();

const closeModal = () => {
    emits('close');
};

const form = useForm<Phase>({
    name: '',
    description: '',
    color: ''
});

const submit = () => {
    form.post(route('projects.phases.store', { project: props.project!.id! }), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onFinish: () => closeModal(),
    });
};

</script>

<template>
    <Modal :show="show" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Create a phase
            </h2>

            <form @submit.prevent="submit">
                <p class="mt-1 text-sm text-gray-600">
                    Please fill in the form below to create a new phase.
                </p>

                <div class="mt-6">
                    <div>
                        <InputLabel for="name" value="Project name" />

                        <TextInput
                            id="name"
                            class="mt-1 block w-full"
                            type="text"
                            placeholder="My project"
                            v-model="form.name"
                        />

                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="description" value="Description" />

                        <TextInput
                            id="description"
                            class="mt-1 block w-full"
                            type="text"
                            placeholder="My project description"
                            v-model="form.description"
                        />

                        <InputError :message="form.errors.description" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="color" value="Color" />

                        <color-input class="d-flex justify-center"
                                     v-model="form.color"
                                     position="top"
                                     model-value="rgb(0, 0, 0)"
                        />

                        <InputError :message="form.errors.color" class="mt-2" />
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Register
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
