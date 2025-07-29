<script setup lang="ts">
defineProps({ status: String })
</script>

<template>
    <div :class="[status == 'Prenotato' ? 'bg-red-500' :  'bg-green-500', 'rounded px-2 py-1 text-center']">
        {{ status }}
    </div>
</template>
