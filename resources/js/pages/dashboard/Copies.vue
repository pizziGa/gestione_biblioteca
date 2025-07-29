<script setup lang="ts">
import CopyForm from '@/components/my-components/forms/CopyForm.vue';
import Badge from '@/components/my-components/ui/Badge.vue';
import Modal from '@/components/my-components/ui/Modal.vue';
import Pagination from '@/components/my-components/ui/Pagination.vue';
import Table from '@/components/my-components/ui/Table.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({ book_id: Number, copies: Object });

const showModal = ref(false);

function show() {
    showModal.value = !showModal.value;
}

function closeModal() {
    showModal.value = false;
}

const tableHeaders = ['Codice a barre', 'Condizioni', 'Nota', 'Disponibilità', ' '];

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
</script>

<template>
    <AppLayout class="divide-y-2" :breadcrumbs="breadcrumbs">
        <Modal :condition="showModal">
            <Button @click="show">X</Button>
            <CopyForm @close-modal="closeModal" :book_id="book_id" />
        </Modal>
        <div class="mt-5 flex flex-col gap-5">
            <button @click="show" class="cursor-pointer text-black underline hover:text-gray-950 dark:text-gray-200 dark:hover:text-white">
                Aggiungi copia
            </button>
            <Table @action="show" target="Aggiungi copia" :headers="tableHeaders">
                <tr
                    v-for="copy in copies?.data"
                    :key="copy.id"
                    class="border-b border-gray-200 odd:bg-white even:bg-gray-50 dark:border-gray-700 odd:dark:bg-zinc-800 even:dark:bg-zinc-700"
                >
                    <th scope="row" class="w-24 truncate px-6 py-4 font-medium whitespace-nowrap text-gray-900 dark:text-white">
                        {{ copy.barcode }}
                    </th>
                    <td class="px-6 py-4">
                        {{ copy.conditions }}
                    </td>
                    <td class="px-6 py-4">
                        {{ copy?.note }}
                    </td>
                    <td class="px-6 py-4">
                        <Badge :status="copy.status" />
                    </td>
                    <td class="px-6 py-4">
                        <Link
                            :href="'/dashboard/prenotazioni?search=' + copy.barcode"
                            class="text-zinc font-medium hover:underline dark:text-shadow-gray-50"
                        >
                            Visualizza prenotazioni
                        </Link>
                    </td>
                </tr>
            </Table>
            <Pagination :meta="copies?.meta" />
        </div>
    </AppLayout>
</template>
