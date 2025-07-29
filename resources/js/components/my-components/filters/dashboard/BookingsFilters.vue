<script setup lang="ts">
import Icon from '@/components/Icon.vue';
import { router, usePage } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import { reactive } from 'vue';

const page = usePage();

const queryForm = reactive({
    search: page.props.filters?.search || '',
});

const doSearch = debounce(() => {
    router.get(
        route('prenotazioni'),
        {
            search: queryForm.search ?? null,
        },
        {
            preserveState: true,
            replace: true,
            preserveScroll: true,
        },
    );
}, 300);
</script>

<template>
    <div
        class="mx-auto flex flex-row items-center gap-2 rounded-md border-[1px] border-neutral-300 bg-neutral-200 p-2 dark:border-neutral-600 dark:bg-neutral-900"
    >
        <Icon name="Search" class="text-neutral-500" />
        <input
            type="text"
            v-model="queryForm.search"
            v-on:input="doSearch"
            placeholder="Utente, Titolo, Codice a barre"
            class="w-full outline-none"
        />
    </div>
</template>
