<script setup lang="ts">
import Icon from '@/components/Icon.vue';
import { router, usePage } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import { reactive } from 'vue';

const page = usePage();

const queryForm = reactive({
    search: page.props.filters?.search || '',
    admin: page.props.filters?.admin || '',
});

const doSearch = debounce(() => {
    router.get(
        route('utenti'),
        {
            search: queryForm.search ?? null,
            admin: queryForm.admin ?? null,
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
    <div class="flex w-full flex-row gap-2">
        <div
            class="flex flex-row items-center gap-2 rounded-md border-[1px] border-neutral-300 bg-neutral-200 p-2 dark:border-neutral-600 dark:bg-neutral-900"
        >
            <Icon name="Search" class="text-neutral-500" />
            <input type="text" v-model="queryForm.search" v-on:input="doSearch" placeholder="ex. Mario Rossi" class="outline-none" />
        </div>
        <label for="showAvailable" class="flex flex-row items-center gap-1">
            <input
                id="showAvailable"
                type="checkbox"
                class="bg-neutral-400"
                :checked="queryForm.admin"
                v-model="queryForm.admin"
                v-on:input="doSearch"
            />
            Mostra solo amministratori
        </label>
    </div>
</template>
