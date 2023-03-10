<script setup lang="ts">
import AddProjectButton from '@/Sidebar/Components/Project/AddProjectButton.vue';
import PrItemEverything from '@/Sidebar/Components/Project/PrItemEverything.vue';
import AddPhaseModal from '@/Sidebar/Components/Phase/AddPhaseModal.vue';
import AddProjectModal from "@/Project/Components/AddProjectModal.vue";
import PrItem from '@/Sidebar/Components/Project/PrItem.vue';
import PrName from '@/Sidebar/Components/Project/PrName.vue';
import PrPhase from '@/Sidebar/Components/Project/PrPhase.vue';
import ThreeVDots from '@/Components/Icons/ThreeVDots.vue';
import Plus from '@/Components/Icons/Plus.vue';

import { Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const props = defineProps<{
    projects: Project[]
}>()

console.log(props.projects[0].phases)

const projectModal = ref(false);
const closeProjectModal = () => {
    projectModal.value = false;
};

const phaseModal = ref(false);
const selectedProject = ref<Project | null>(null);
const showPhaseModal = (project: Project) => {
    selectedProject.value = project;
    phaseModal.value = true;
};

const closePhaseModal = () => {
    phaseModal.value = false;
    selectedProject.value = null;
}

onMounted(() => {
    const projectChannel = Echo.channel('public.projects');

    projectChannel
        .listen('.project.created', (e: any) => {
            console.log('ProjectCreated', e);
            props.projects.push(e.project);
        })
        .listen('.project.updated', (e: any) => {
            console.log('ProjectUpdated', e);
            const updateIndex = props.projects.findIndex(project => project.id == e.project.id)
            if (updateIndex !== -1) props.projects[updateIndex] = e.project;
        })
        .listen('.project.deleted', (e: any) => {
            console.log('ProjectDeleted', e);
            const deleteIndex = props.projects.findIndex(project => project.id == e.project.id)
            if (deleteIndex !== -1) props.projects.splice(deleteIndex, 1);
        });
});

</script>

<template>
    <div class="sidebar-dropdown">
        <div class="sidebar-search"></div>
        <div class="sidebar-title">Projects</div>
        <div class="sidebar-content">
            <div class="sidebar-project-list">
                <AddProjectButton @click.prevent="projectModal = !projectModal" />
                <PrItemEverything />
                <PrItem v-if="projects.length" v-for="project in projects" :key="project.id" :project="project">
                    <PrName :project="project" />
                    <template #icons>
                        <Link href="">
                            <ThreeVDots />
                        </Link>
                        <Plus @click="showPhaseModal(project)" />
                    </template>
                    <template #phases>
                        <PrPhase
                            v-if="project.phases.length"
                            v-for="(phase, index) in project.phases"
                            :key="phase.id"
                            :phase="phase"
                            :number="index + 1"
                        />
                        <div v-else>
                            <p>No phases yet</p>
                        </div>
                    </template>
                </PrItem>
                <div v-else>
                    No projects yet
                </div>
            </div>
        </div>
    </div>

    <AddProjectModal :show="projectModal" @close="closeProjectModal" />
    <AddPhaseModal :show="phaseModal" :project="selectedProject" @close="closePhaseModal" />
</template>
