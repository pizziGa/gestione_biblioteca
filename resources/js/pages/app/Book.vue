<script setup lang="ts">
import BookSheet from '@/components/BookSheet.vue';
import { Separator } from '@/components/ui/separator';
import AuthLayout from '@/layouts/auth/AuthMainLayout.vue';
import Copies from '@/pages/app/Copies.vue';
import { Head } from '@inertiajs/vue3';

defineProps({ book: Object, copies: [Object, null], booked_copies: [Object, null] });
</script>

<template>
    <Head :title="book?.title" />
    <AuthLayout :filters="false">
        <BookSheet alt="Copertina" :cover="book?.cover">
            <h1 class="text-xl font-semibold">{{ book?.title }}</h1>
            <div class="flex w-full flex-col gap-2">
                <p class="text-sm text-neutral-500">{{ book?.author }} (Autore), {{ book?.publisher }} (Editore)</p>
            </div>
            <p class="max-h-44 min-h-24 w-full overflow-scroll">
                {{ book?.description !== null ? book?.description : 'Descrizione non disponibile' }}
            </p>
            <div class="flex w-full flex-row gap-2">
                <p class="text-sm text-neutral-500">Categoria: {{ book?.category.name }}</p>
                <p class="text-sm text-neutral-500">ISBN: {{ book?.ISBN }}</p>
                <p class="text-sm text-neutral-500">Anno: {{ book?.year }}</p>
            </div>
        </BookSheet>
        <Separator />
        <Copies :copies="copies" :booked_copies="booked_copies" />
    </AuthLayout>
</template>
