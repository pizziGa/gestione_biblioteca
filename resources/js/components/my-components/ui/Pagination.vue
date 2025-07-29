<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps({ meta: Object });
</script>

<template>
    <nav class="flex justify-center gap-3">
        <template v-for="link in meta?.links" :key="link.label">
            <Link
                :href="link.url ?? ''"
                v-html="link.label"
                class="flex items-center rounded px-3 py-2 dark:hover:bg-neutral-600 hover:bg-neutral-300"
                :class="{ 'dark:bg-neutral-700 bg-neutral-200': link.active }"
            />
        </template>
    </nav>
</template>
