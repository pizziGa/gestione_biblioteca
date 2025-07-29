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
    unavailable: page.props.filters?.unavailable || '',
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
        route('customer.catalogo'),
        {
            search: queryForm.search ?? null,
            category: queryForm.category ?? null,
            year: queryForm.year ?? null,
            unavailable: queryForm.unavailable,
        },
        {
            preserveState: true,
            replace: true,
            preserveScroll: true,
        },
    );
}, 300);

interface Props {
    filters?: boolean;
    categories?: object;
}

defineProps<Props>();
</script>

<template>
    <div v-if="filters" class="flex h-full gap-2 px-4" :class="[admin ? 'flex-row' : 'flex-col']">
        <div
            class="flex flex-row items-center gap-2 rounded-md border-[1px] border-neutral-300 bg-neutral-200 p-2 dark:border-neutral-600 dark:bg-neutral-900"
        >
            <Icon name="Search" class="text-neutral-500" />
            <input
                type="text"
                v-model="queryForm.search"
                v-on:input="doSearch"
                placeholder="Titolo, Autore, Editore ..."
                class="w-full outline-none"
            />
        </div>
        <div class="flex flex-row items-center gap-2">
            <select
                class="w-full rounded-md border-[1px] border-neutral-300 bg-neutral-200 p-2 outline-none dark:border-neutral-600 dark:bg-neutral-900"
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
        <div class="flex flex-row items-center gap-2">
            <select
                class="w-full rounded-md border-[1px] border-neutral-300 bg-neutral-200 p-2 outline-none dark:border-neutral-600 dark:bg-neutral-900"
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
        <label for="showUnavailable" class="flex w-full flex-row items-center gap-1">
            <input
                id="showUnavailable"
                type="checkbox"
                class="bg-neutral-400"
                :checked="queryForm.unavailable"
                v-model="queryForm.unavailable"
                v-on:input="doSearch"
            />
            Mostra non disponibili
        </label>
    </div>
</template>
