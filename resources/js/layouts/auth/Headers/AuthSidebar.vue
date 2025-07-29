<script setup lang="ts">
import Filters from '@/components/my-components/filters/app/Filters.vue';

interface Props {
    filters?: boolean;
    categories?: object;
}

defineProps<Props>();
</script>

<template>
    <div class="mx-auto flex flex-row gap-5 p-4 md:max-w-7xl">
        <Filters :filters="filters" :categories="categories" />
        <slot />
    </div>
</template>
