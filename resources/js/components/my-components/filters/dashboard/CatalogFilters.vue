<script setup lang="ts">
import Icon from '@/components/Icon.vue';
import { router, usePage } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import { reactive, watch } from 'vue';

const page = usePage();

const currentYear = new Date().getFullYear();
const years = Array.from({ length: currentYear - 1940 + 1 }, (_, i) => currentYear - i);

const queryForm = reactive({
    search: page.props.filters?.search || '',
    category: page.props.filters?.category || '',
    year: page.props.filters?.year || '',
    available: page.props.filters?.available || '',
});

const reset = reactive({
    category: false,
    year: false,
});

watch(queryForm.category, () => {
    if (queryForm.category != '') {
        reset.category = true;
    }
});

watch(queryForm.year, () => {
    if (queryForm.year != '') {
        reset.year = true;
    }
});

function resetCategory() {
    queryForm.category = '';
    doSearch();
}

function resetYear() {
    queryForm.year = '';
    doSearch();
}

const doSearch = debounce(() => {
    router.get(
        route('catalogo'),
        {
            search: queryForm.search ?? null,
            category: queryForm.category ?? null,
            year: queryForm.year ?? null,
            available: queryForm.available,
        },
        {
            preserveState: true,
            replace: true,
            preserveScroll: true,
        },
    );
}, 300);

interface Props {
    categories?: object;
}

defineProps<Props>();
</script>

<template>
    <div class="flex w-full flex-row gap-2">
        <div
            class="flex flex-row items-center gap-2 rounded-md border-[1px] border-neutral-300 bg-neutral-200 p-2 dark:border-neutral-600 dark:bg-neutral-900"
        >
            <Icon name="Search" class="text-neutral-500" />
            <input type="text" v-model="queryForm.search" v-on:input="doSearch" placeholder="Titolo, Autore, Editore ..." class="outline-none" />
        </div>
        <div class="flex flex-row gap-2">
            <select
                class="rounded-md border-[1px] border-neutral-300 bg-neutral-200 p-2 outline-none dark:border-neutral-600 dark:bg-neutral-900"
                v-model="queryForm.category"
                v-on:input="doSearch"
            >
                <option value="" disabled selected>Categoria</option>
                <option v-for="category in categories" :key="category.id" :value="category.id">
                    {{ category.name }}
                </option>
            </select>
            <button :disabled="reset.category" @click="resetCategory">
                <Icon name="RotateCcw" />
            </button>
        </div>
        <div class="flex flex-row gap-2">
            <select
                class="rounded-md border-[1px] border-neutral-300 bg-neutral-200 p-2 outline-none dark:border-neutral-600 dark:bg-neutral-900"
                v-model="queryForm.year"
                v-on:input="doSearch"
            >
                <option value="" disabled selected>Anno</option>
                <option v-for="year in years" :key="year" :value="year">
                    {{ year }}
                </option>
            </select>
            <button :disabled="reset.year" @click="resetYear">
                <Icon name="RotateCcw" />
            </button>
        </div>
        <label for="showAvailable" class="flex flex-row items-center gap-1">
            <input
                id="showAvailable"
                type="checkbox"
                class="bg-neutral-400"
                :checked="queryForm.available"
                v-model="queryForm.available"
                v-on:input="doSearch"
            />
            Mostra solo disponibili
        </label>
    </div>
</template>
