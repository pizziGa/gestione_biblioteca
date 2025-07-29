<script setup lang="ts">
import AuthHeader from '@/layouts/auth/Headers/AuthHeader.vue';
import AuthSidebar from '@/layouts/auth/Headers/AuthSidebar.vue';

defineProps({ filters: Boolean, categories: Object });
</script>

<template>
    <div class="min-h-screen">
        <AuthHeader />
        <AuthSidebar :filters="filters" :categories="categories">
            <main class="flex w-full flex-col gap-2 px-4 md:max-w-7xl">
                <slot />
            </main>
        </AuthSidebar>
    </div>
</template>
