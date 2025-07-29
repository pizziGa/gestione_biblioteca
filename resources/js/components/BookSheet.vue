<script setup lang="ts">
interface Props {
    cover?: string;
    alt?: string;
}

defineProps<Props>();
</script>

<template>
    <div class="flex h-full w-full flex-row gap-2 p-5">
        <div class="flex min-h-52 w-40 items-center rounded-md border-2 border-neutral-800">
            <img :src="'/storage/' + cover" :alt="alt" />
        </div>
        <div class="flex flex-col gap-2">
            <slot />
        </div>
    </div>
</template>
