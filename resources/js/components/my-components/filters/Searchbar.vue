<script setup lang="ts">
import Icon from '@/components/Icon.vue';
import { router, usePage } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import { reactive } from 'vue';

const props = defineProps({ route: String, placeholder: String })

const page = usePage();

const queryForm = reactive({
    search: page.props.filters?.search || '',
});

const doSearch = debounce(() => {
    router.get(
        route(props.route),
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
    <div class="flex flex-row items-center gap-2 rounded-md border-[1px] dark:border-neutral-600 border-neutral-300 dark:bg-neutral-900 bg-neutral-200 p-2 mx-auto">
        <Icon name="Search" class="text-neutral-500" />
        <input
            type="text"
            v-model="queryForm.search"
            v-on:input="doSearch"
            :placeholder="placeholder"
            class="w-full outline-none"
        />
    </div>
</template>

