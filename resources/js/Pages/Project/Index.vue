<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AppHead from '@/Components/AppHead.vue';

import { ref } from 'vue';

const open = ref(['Users']);

const admins = ref([
    ['Management', 'mdi-account-multiple-outline'],
    ['Settings', 'mdi-cog-outline'],
]);

const cruds = ref([
    ['Create', 'mdi-plus-outline'],
    ['Read', 'mdi-file-outline'],
    ['Update', 'mdi-update'],
    ['Delete', 'mdi-delete'],
]);

</script>

<template>
    <AppHead title="Projects" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Projects</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <v-card

                            width="300"
                        >
                            <v-list v-model:opened="open">
                                <v-list-item prepend-icon="mdi-home" title="Home"></v-list-item>

                                <v-list-group value="Users">
                                    <template v-slot:activator="{ props }">
                                        <v-list-item
                                            v-bind="props"
                                            prepend-icon="mdi-account-circle"
                                            title="Users"
                                        ></v-list-item>
                                    </template>

                                    <v-list-group value="Admin">
                                        <template v-slot:activator="{ props }">
                                            <v-list-item
                                                v-bind="props"
                                                title="Admin"
                                            ></v-list-item>
                                        </template>

                                        <v-list-item
                                            v-for="([title, icon], i) in admins"
                                            :key="i"
                                            :title="title"
                                            :prepend-icon="icon"
                                            :value="title"
                                        ></v-list-item>
                                    </v-list-group>

                                    <v-list-group value="Actions">
                                        <template v-slot:activator="{ props }">
                                            <v-list-item
                                                v-bind="props"
                                                title="Actions"
                                            ></v-list-item>
                                        </template>

                                        <v-list-item
                                            v-for="([title, icon], i) in cruds"
                                            :key="i"
                                            :value="title"
                                            :title="title"
                                            :prepend-icon="icon"
                                        ></v-list-item>
                                    </v-list-group>
                                </v-list-group>
                            </v-list>
                        </v-card>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
