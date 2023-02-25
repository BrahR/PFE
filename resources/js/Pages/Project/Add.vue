<script setup lang="ts">
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import ProjectPopup from '@/Pages/Project/ProjectPopup.vue';
import AppHead from '@/Components/AppHead.vue';

import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm<Project>({
      name: '',
      description: '',
      timeline: '',
      budget: 0,
      resource_allocation: 0,
});

const props = defineProps<{
    projects: Project[]
}>()

const submit = () => {
    form.post(route('projects.index'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};

const showModelEl = ref(false);
const showProjectPopup = ref(false);
const selectedProject = ref<Project | null>(null);

const showModal = () => {
    showModelEl.value = true;
};

const closeModal = () => {
    showModelEl.value = false;
};

const openProjectPopup = (project: Project) => {
    showProjectPopup.value = true;
    selectedProject.value = project;
};

const closeProjectPopup = () => {
    showProjectPopup.value = false;
    selectedProject.value = null;
    console.log('closeProjectPopup')
};

</script>

<template>
    <AppHead title="Temp Index" />
    <PrimaryButton @click="showModal">Add project</PrimaryButton>

    <Modal :show="showModelEl" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Create a project
            </h2>

            <form @submit.prevent="submit">
                <p class="mt-1 text-sm text-gray-600">
                    Please fill in the form below to create a new project.
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
                        <InputLabel for="timeline" value="Timeline" />

                        <TextInput
                          id="timeline"
                          class="mt-1 block w-full"
                          type="date"
                          placeholder="My project timeline"
                          v-model="form.timeline"
                        />

                        <InputError :message="form.errors.timeline" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="budget" value="Budget" />

                        <TextInput
                            id="budget"
                            class="mt-1 block w-full"
                            type="number"
                            placeholder="My project budget"
                            v-model="form.budget"
                        />

                        <InputError :message="form.errors.budget" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="resource_allocation" value="Resource allocation" />

                        <TextInput
                            id="resource_allocation"
                            class="mt-1 block w-full"
                            type="number"
                            placeholder="My project resource allocation"
                            v-model="form.resource_allocation"
                        />

                        <InputError :message="form.errors.resource_allocation" class="mt-2" />
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

    <div class="mt-4">
        <ul>
            <li v-for="project in props.projects" :key="project.id">
                <a @click.prevent="openProjectPopup(project)">{{ project.name }}</a>
            </li>
        </ul>
    </div>

    <ProjectPopup :project="selectedProject" @close="closeProjectPopup"/>
</template>
