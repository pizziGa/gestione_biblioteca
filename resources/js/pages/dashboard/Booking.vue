<script setup lang="ts">
import BookingsFilters from '@/components/my-components/filters/dashboard/BookingsFilters.vue';
import Pagination from '@/components/my-components/ui/Pagination.vue';
import Table from '@/components/my-components/ui/Table.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';

const tableHeaders = ['Copia del libro', 'Prenotato da', 'Condizioni', 'Codice a barre', 'Prenotato il', 'Posizione in coda', ' '];

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Prenotazioni',
        href: '/dashboard/prenotazioni',
    },
];

defineProps({ bookings: Object });

function completeBooking(id: number) {
    router.delete('/dashboard/prenotazioni/' + id, {});
}
</script>

<template>
    <Head title="Prenotazioni" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-3 p-3">
            <BookingsFilters />
            <Table v-if="bookings?.data.length > 0" :headers="tableHeaders">
                <tr
                    v-for="booking in bookings?.data"
                    :key="booking.id"
                    class="border-b border-gray-200 odd:bg-white even:bg-gray-50 dark:border-gray-700 odd:dark:bg-zinc-800 even:dark:bg-zinc-700"
                >
                    <th scope="row" class="w-24 truncate px-6 py-4 font-medium whitespace-nowrap text-gray-900 dark:text-white">
                        {{ booking.copy.book.title }}
                    </th>
                    <td class="px-6 py-4">
                        {{ booking.user.name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ booking.copy.conditions }}
                    </td>
                    <td class="px-6 py-4">
                        {{ booking.copy.barcode }}
                    </td>
                    <td class="px-6 py-4">
                        {{ booking.formatted_created_at }}
                    </td>
                    <td class="px-6 py-4">
                        {{ booking.queue }}
                    </td>
                    <td class="px-6 py-4">
                        <button @click="completeBooking(booking?.id)" class="text-zinc font-medium hover:underline dark:text-shadow-gray-50">
                            Completa ordine
                        </button>
                    </td>
                </tr>
            </Table>
            <div v-else class="mx-auto my-10 text-center text-xl">
                <p>Non ci sono prenotazioni effettuate</p>
            </div>
        </div>
        <Pagination :meta="bookings?.meta" />
    </AppLayout>
</template>
