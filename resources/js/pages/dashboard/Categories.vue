<script setup lang="ts">
import Searchbar from '@/components/my-components/filters/Searchbar.vue';
import CategoryForm from '@/components/my-components/forms/CategoryForm.vue';
import Modal from '@/components/my-components/ui/Modal.vue';
import Pagination from '@/components/my-components/ui/Pagination.vue';
import Table from '@/components/my-components/ui/Table.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';

defineProps({ categories: Object });

const selectedCategory = ref();

const modal = reactive({
    add: false,
    update: false,
});

const tableHeaders = ['Nome', ' '];

function showAddModal() {
    modal.add = !modal.add;
}

function showUpdateModal(category: object) {
    modal.update = !modal.update;
    selectedCategory.value = category;
}

function closeModals() {
    modal.add = false;
    modal.update = false;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Categorie',
        href: '/dashboard/categorie',
    },
];
</script>

<template>
    <Head title="Categorie" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <!-- Form aggiornamento categoria -->
        <Modal :condition="modal.update">
            <Button @click="showUpdateModal">X</Button>
            <div class="flex h-full w-full flex-col justify-center">
                <CategoryForm @close-modal="closeModals" :category="selectedCategory" :update="true" />
            </div>
        </Modal>
        <!-- Form creazione categoria -->
        <Modal :condition="modal.add">
            <Button @click="showAddModal">X</Button>
            <div class="flex h-full w-full flex-col justify-center">
                <CategoryForm @close-modal="closeModals" :update="false" />
            </div>
        </Modal>
        <div class="mx-auto mt-5 flex flex-col gap-4">
            <div class="flex flex-row gap-2">
                <Searchbar route="categorie" placeholder="ex. Horror" />
                <div class="flex-1" />
                <button
                    @click="showAddModal"
                    class="cursor-pointer text-right text-black underline hover:text-gray-950 dark:text-gray-200 dark:hover:text-white"
                >
                    Aggiungi categoria
                </button>
            </div>

            <Table @action="showAddModal" :headers="tableHeaders" target="Aggiungi categoria">
                <tr
                    v-for="category in categories?.data"
                    :key="category.id"
                    class="border-b border-gray-200 odd:bg-white even:bg-gray-50 dark:border-gray-700 odd:dark:bg-zinc-800 even:dark:bg-zinc-700"
                >
                    <th scope="row" class="w-24 truncate px-6 py-4 font-medium whitespace-nowrap text-gray-900 dark:text-white">
                        {{ category.name }}
                    </th>
                    <td class="px-6 py-4">
                        <button
                            @click="showUpdateModal(category)"
                            class="cursor-pointer text-right text-black underline hover:text-gray-950 dark:text-gray-200 dark:hover:text-white"
                        >
                            Modifica
                        </button>
                    </td>
                </tr>
            </Table>
            <Pagination :meta="categories?.meta" />
        </div>
    </AppLayout>
</template>
