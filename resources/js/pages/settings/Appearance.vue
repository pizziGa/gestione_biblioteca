<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import AppearanceTabs from '@/components/AppearanceTabs.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';

import SettingsLayout from '@/layouts/settings/Layout.vue';

defineProps({ auth: Object });
</script>

<script lang="ts">
import RoleBasedLayout from '@/layouts/RoleBasedLayout.vue';

export default {
    layout: RoleBasedLayout,
};
</script>

<template>
    <Head title="Appearance settings" />

    <SettingsLayout>
        <div class="space-y-6">
            <HeadingSmall title="Tema" description="Cambia tema dell'applicazione" />
            <AppearanceTabs />
        </div>
    </SettingsLayout>
</template>
