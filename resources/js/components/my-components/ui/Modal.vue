<template>
    <Transition>
        <dialog v-if="condition" open class="flex h-full w-full flex-col backdrop-blur-md bg-black/80 text-white">
            <slot />
        </dialog>
    </Transition>
</template>

<script setup lang="ts">
defineProps({ condition: Boolean });
</script>

<style>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.3s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
