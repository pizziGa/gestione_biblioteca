<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const props = defineProps({
    book_id: Number,
});

const emit = defineEmits(['closeModal']);

const form = useForm({
    conditions: '',
    note: ' ',
});

const submit = () => {
    form.post('/dashboard/catalogo/' + props.book_id + '/copie');
    emit('closeModal')
};
</script>

<template>
    <div class="flex h-full w-full flex-col justify-center">
        <form @submit.prevent="submit" class="m-2 mx-auto gap-6 rounded-2xl dark:bg-neutral-900 bg-neutral-100 p-12">
            <div class="flex flex-row gap-5">
                <div class="flex flex-col gap-3">
                    <div class="flex flex-col gap-3 text-black dark:text-white">
                        <Label for="conditions">Condizioni</Label>
                        <select id="conditions" v-model="form.conditions" class="rounded-xl bg-zinc-200 dark:bg-neutral-800 p-2">
                            <option>Ottimo</option>
                            <option>Buono</option>
                            <option>Discreto</option>
                        </select>
                        <div class="flex flex-col gap-3">
                            <Label for="note">Nota</Label>
                            <textarea id="note" v-model="form.note" class="rounded-xl bg-zinc-200 dark:bg-neutral-800 p-2" />
                        </div>
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
