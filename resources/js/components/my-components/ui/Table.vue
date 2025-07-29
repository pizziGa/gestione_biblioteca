<script setup lang="ts">
defineProps({ headers: Object });
</script>

<template>
    <div class="flex flex-col items-center">
        <table class="mx-auto text-left text-sm rtl:text-right">
            <thead class="bg-zinc-300 text-xs uppercase dark:bg-zinc-900">
                <tr>
                    <th v-for="header in headers" :key="headers?.indexOf(header)" scope="col" class="px-6 py-3">
                        {{ header }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <slot />
            </tbody>
        </table>
    </div>
</template>
