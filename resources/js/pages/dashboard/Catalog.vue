<script setup lang="ts">
import Filters from '@/components/my-components/filters/dashboard/CatalogFilters.vue';
import BookForm from '@/components/my-components/forms/BookForm.vue';
import Modal from '@/components/my-components/ui/Modal.vue';
import Pagination from '@/components/my-components/ui/Pagination.vue';
import Table from '@/components/my-components/ui/Table.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';

const tableHeaders = ['Titolo', 'Autore', 'Editore', 'Anno di pubblicazione', 'Categoria', 'ISBN', 'Parole chiave', ' ', ' '];

const modal = reactive({
    add: false,
    update: false,
});

const selectedBook = ref();

function showAddModal() {
    modal.add = !modal.add;
}

function showUpdateModal(book: object) {
    modal.update = !modal.update;
    selectedBook.value = book;
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
        title: 'Catalogo',
        href: '/dashboard/catalogo',
    },
];

defineProps({ categories: Object, books: Object, filters: Boolean });
</script>

<template>
    <Head title="Catalogo" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <!-- Form aggiunta libro -->
        <Modal :condition="modal.add">
            <Button @click="showAddModal">X</Button>
            <div class="flex h-full w-full flex-col justify-center">
                <BookForm @close-modal="closeModals" :categories="categories" :update="false" :book="null" />
            </div>
        </Modal>
        <!-- Form aggiornamento libro -->
        <Modal :condition="modal.update">
            <Button @click="showUpdateModal">X</Button>
            <div class="flex h-full w-full flex-col justify-center">
                <BookForm @close-modal="closeModals" :book="selectedBook" :categories="categories" :update="true" />
            </div>
        </Modal>
        <div class="mx-auto mt-5 flex flex-col gap-4">
            <div class="flex flex-row">
                <Filters :categories="categories" />
                <div class="flex-1" />
                <button
                    @click="showAddModal"
                    class="cursor-pointer text-black underline hover:text-gray-950 dark:text-gray-200 dark:hover:text-white"
                >
                    Aggiungi libro
                </button>
            </div>
            <Table :headers="tableHeaders">
                <tr
                    v-for="book in books?.data"
                    :key="book.id"
                    class="border-b border-gray-200 odd:bg-white even:bg-gray-50 dark:border-gray-700 odd:dark:bg-zinc-800 even:dark:bg-zinc-700"
                >
                    <th scope="row" class="w-24 truncate px-6 py-4 font-medium whitespace-nowrap text-gray-900 dark:text-white">
                        {{ book.title }}
                    </th>
                    <td class="px-6 py-4">
                        {{ book.author }}
                    </td>
                    <td class="px-6 py-4">
                        {{ book.publisher }}
                    </td>
                    <td class="px-6 py-4">
                        {{ book.year }}
                    </td>
                    <td class="px-6 py-4">
                        {{ book.category?.name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ book.ISBN }}
                    </td>
                    <td class="overflow-hidden px-6 py-4">
                        {{ book.tags }}
                    </td>
                    <td class="px-6 py-4">
                        <Link
                            :href="'/dashboard/catalogo/' + book.id + '/copie'"
                            class="text-zinc font-medium hover:underline dark:text-shadow-gray-50"
                        >
                            Copie
                        </Link>
                    </td>
                    <td class="px-6 py-4">
                        <button @click="showUpdateModal(book)" class="text-zinc font-medium hover:underline dark:text-shadow-gray-50">
                            Modifica
                        </button>
                    </td>
                </tr>
            </Table>
            <Pagination :meta="books?.meta" />
        </div>
    </AppLayout>
</template>
