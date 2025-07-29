<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
    name: '',
    email: '',
    password: '',
});

const emit = defineEmits(['closeModal']);
const submit = () => {
    form.post(route('app.create'));
    emit('closeModal');
};
</script>

<template>
    <div class="flex h-full w-full flex-col justify-center">
        <form @submit.prevent="submit" class="m-2 mx-auto gap-6 rounded-2xl bg-neutral-100 p-12 dark:bg-neutral-900">
            <div class="flex flex-row gap-5">
                <div class="flex flex-col gap-3">
                    <div class="flex flex-col gap-3 text-black dark:text-white">
                        <Label for="name">Nome</Label>
                        <input
                            id="name"
                            v-model="form.name"
                            class="w-full rounded-md border-gray-50 bg-gray-200 p-2 text-black outline-none dark:border-zinc-700 dark:bg-neutral-800 dark:text-white"
                        />
                        <InputError :message="form.errors.name" />
                    </div>
                    <div class="flex flex-col gap-3 text-black dark:text-white">
                        <Label for="email">Email</Label>
                        <input
                            id="email"
                            type="email"
                            v-model="form.email"
                            class="w-full rounded-md border-gray-50 bg-gray-200 p-2 text-black outline-none dark:border-zinc-700 dark:bg-neutral-800 dark:text-white"
                        />
                        <InputError :message="form.errors.email" />
                    </div>
                    <div class="flex flex-col gap-3 text-black dark:text-white">
                        <Label for="password">Password</Label>
                        <input
                            id="password"
                            type="password"
                            v-model="form.password"
                            class="w-full rounded-md border-gray-50 bg-gray-200 p-2 text-black outline-none dark:border-zinc-700 dark:bg-neutral-800 dark:text-white"
                        />
                        <InputError :message="form.errors.password" />
                    </div>
                </div>
            </div>
            <Button type="submit" class="mt-4 w-full text-white dark:text-black" :tabindex="4" :disabled="form.processing">
                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                Aggiungi
            </Button>
        </form>
    </div>
</template>
