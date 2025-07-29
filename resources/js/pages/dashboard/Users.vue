<script setup lang="ts">
import UsersFilters from '@/components/my-components/filters/dashboard/UsersFilters.vue';
import AdminForm from '@/components/my-components/forms/AdminForm.vue';
import Modal from '@/components/my-components/ui/Modal.vue';
import Pagination from '@/components/my-components/ui/Pagination.vue';
import Table from '@/components/my-components/ui/Table.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const tableHeaders = ['Nome', 'Email', 'Ruolo'];

const showModal = ref(false);

function show() {
    showModal.value = !showModal.value;
}

function closeModal() {
    showModal.value = false;
}

defineProps({ users: [Object, null] });

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Utenti',
        href: '/dashboard/utenti',
    },
];
</script>

<template>
    <Head title="Clienti" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Modal :condition="showModal">
            <Button @click="show">X</Button>
            <div class="flex h-full w-full flex-col justify-center">
                <AdminForm @close-modal="closeModal" />
            </div>
        </Modal>
        <div class="mx-auto mt-5 flex flex-col gap-4">
            <div class="flex flex-row gap-2">
                <UsersFilters />
                <button @click="show" class="cursor-pointer text-black underline hover:text-gray-950 dark:text-gray-200 dark:hover:text-white">
                    Aggiungi amministratore
                </button>
            </div>
            <Table :headers="tableHeaders">
                <tr
                    v-for="user in users?.data"
                    :key="user.id"
                    class="border-b border-gray-200 odd:bg-white even:bg-gray-50 dark:border-gray-700 odd:dark:bg-zinc-800 even:dark:bg-zinc-700"
                >
                    <th scope="row" class="w-24 truncate px-6 py-4 font-medium whitespace-nowrap text-gray-900 dark:text-white">
                        {{ user.name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ user.email }}
                    </td>
                    <td class="px-6 py-4">
                        {{ user.role }}
                    </td>
                </tr>
            </Table>
            <Pagination :meta="users?.meta" />
        </div>
    </AppLayout>
</template>
