<script setup lang="ts">
import Badge from '@/components/my-components/ui/Badge.vue';
import Table from '@/components/my-components/ui/Table.vue';
import AuthLayout from '@/layouts/auth/AuthMainLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const tableHeaders = ['Libro', 'Codice a barre', 'Condizioni', 'Disponibilità', 'Posizione in coda', ''];

const props = defineProps({ bookings: [Object, null] });

function deleteBooking(id: number) {
    router.delete('prenotazioni/' + id);
}

console.log(props.bookings);

function isAvailable(queue: number) {
    if (queue === 1) {
        return 'Ritirabile';
    }
    return 'Prenotato';
}
</script>

<template>
    <Head title="Le mie prenotazioni" />
    <AuthLayout :filters="false">
        <Table v-if="bookings?.length > 0" :headers="tableHeaders">
            <tr
                v-for="booking in bookings"
                :key="booking?.id"
                class="border-b border-gray-200 odd:bg-white even:bg-gray-50 dark:border-gray-700 odd:dark:bg-zinc-800 even:dark:bg-zinc-700"
            >
                <th scope="row" class="w-24 truncate px-6 py-4 font-medium whitespace-nowrap text-gray-900 dark:text-white">
                    {{ booking?.copy.book.title }}
                </th>
                <td class="px-6 py-4">
                    {{ booking?.copy.barcode }}
                </td>
                <td class="px-6 py-4">
                    {{ booking?.copy.conditions }}
                </td>
                <td class="px-6 py-4">
                    <Badge :status="isAvailable(booking.queue)" />
                </td>
                <td class="px-6 py-4">
                    {{ booking?.queue }}
                </td>
                <td class="px-6 py-4">
                    <button @click="deleteBooking(booking?.id)" class="text-zinc font-medium hover:underline dark:text-shadow-gray-50">
                        Annulla prenotazione
                    </button>
                </td>
            </tr>
        </Table>
        <div v-else class="mx-auto my-auto text-center">
            <p>Non ci sono prenotazioni che hai effettuato</p>
            <div class="rounded bg-neutral-900 p-2 text-white hover:bg-neutral-800 dark:bg-neutral-300 dark:text-black dark:hover:bg-neutral-100">
                <Link :href="route('customer.catalogo')">Sfoglia il catalogo</Link>
            </div>
        </div>
    </AuthLayout>
</template>
