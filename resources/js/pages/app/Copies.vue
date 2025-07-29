<script setup lang="ts">
import Table from '@/components/my-components/ui/Table.vue';
import { router } from '@inertiajs/vue3';
import { computed } from 'vue';
import Badge from '@/components/my-components/ui/Badge.vue';

const tableHeaders = ['Codice a barre', 'Condizioni', 'Nota', 'Disponibilità', ''];

const props = defineProps({ copies: [Object, null], booked_copies: [Object, null] });

console.log(props);

function bookCopy(id: number) {
    router.post(route('customer.prenotazione'), { copy: id });
}

const isEmpty = computed(() => {
    return !props.copies || Object.keys(props.copies).length === 0;
});

function isBooked(id: number) {
    return props.booked_copies?.includes(id);
}
</script>

<template>
    <Table v-if="!isEmpty" :headers="tableHeaders">
        <tr
            v-for="copy in copies"
            :key="copy.id"
            class="border-b border-gray-200 odd:bg-white even:bg-gray-50 dark:border-gray-700 odd:dark:bg-zinc-800 even:dark:bg-zinc-700"
        >
            <th scope="row" class="w-24 truncate px-6 py-4 font-medium whitespace-nowrap text-gray-900 dark:text-white">
                {{ copy.barcode }}<span class="text-green-500">{{ copies?.indexOf(copy) === 0 ? ' [Consigliato]' : '' }}</span>
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
                <button
                    @click="bookCopy(copy.id)"
                    :disabled="isBooked(copy.id)"
                    class="text-zinc font-medium hover:underline disabled:text-neutral-500 dark:text-shadow-gray-50"
                >
                    {{ isBooked(copy.id) ? 'Prenotato' : 'Prenota' }}
                </button>
            </td>
        </tr>
    </Table>
    <div v-else class="flex flex-col items-center pt-5">Non ci sono ancora copie disponibili</div>
</template>
