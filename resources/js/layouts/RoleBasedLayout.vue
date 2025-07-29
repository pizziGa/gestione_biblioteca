<script setup lang="ts">
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AppLayout from './AppLayout.vue';
import AuthMainLayout from '@/layouts/auth/AuthMainLayout.vue';

const page = usePage();
const role = computed(() => page.props.auth?.user?.role);

const layout = computed(() => (role.value === 'admin' ? AppLayout : AuthMainLayout));
</script>

<template>
    <component :is="layout">
        <slot />
    </component>
</template>
