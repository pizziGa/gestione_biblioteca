<script setup lang="ts">
import BookSheet from '@/components/BookSheet.vue';
import Pagination from '@/components/my-components/ui/Pagination.vue';
import AuthLayout from '@/layouts/auth/AuthMainLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({ books: Object, categories: Object });
</script>

<template>
    <Head title="Catalogo" />
    <AuthLayout :filters="true" :categories="categories">
        <BookSheet v-for="book in books?.data" :key="book.id" alt="Copertina" :cover="book.cover">
            <h1 class="text-xl font-semibold">{{ book.title }}</h1>
            <div class="flex flex-col gap-2">
                <p class="text-sm text-neutral-500">{{ book.author }}, {{ book.publisher }}</p>
                <p class="text-sm text-neutral-500">Categoria: {{ book.category.name }}, Anno: {{ book.year }}</p>
            </div>
            <p class="h-full w-full overflow-scroll">{{ book.description }}</p>
            <Link :href="'/catalogo/' + book.id">Vai alla scheda del libro</Link>
        </BookSheet>
        <Pagination :meta="books?.meta" />
    </AuthLayout>
</template>
