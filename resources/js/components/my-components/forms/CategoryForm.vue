<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const props = defineProps({ category: [Object, null], update: Boolean });

const form = useForm({
    name: props.update ? props.category?.name : '',
});

const emit = defineEmits(['closeModal'])

const submit = () => {
    if (props.update) {
        form.post('/dashboard/categorie/' + props.category?.id + '/update');
    } else {
        form.post(route('categorie'));
    }
    emit('closeModal')
};

function deleteCategory() {
    form.delete('/dashboard/categorie/' + props.category?.id);
    emit('closeModal')
}
</script>

<template>
    <div class="flex h-full w-full flex-col justify-center">
        <form @submit.prevent="submit" class="m-2 mx-auto gap-6 rounded-2xl dark:bg-neutral-900 bg-neutral-100 p-12">
            <div class="flex flex-row gap-5">
                <div class="flex flex-col gap-3">
                    <div class="flex flex-col gap-3 text-black dark:text-white">
                        <Label for="name">Nome</Label>
                        <input v-model="form.name" id="name" class="w-full rounded-md border dark:bg-neutral-800 bg-zinc-200 p-2" />
                        <InputError :message="form.errors.name" />
                    </div>
                </div>
            </div>
            <Button type="submit" class="mt-4 w-full text-white dark:text-black" :tabindex="4" :disabled="form.processing">
                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                {{ props.update ? 'Modifica' : 'Aggiungi' }}
            </Button>
            <Button v-if="props.update" @click="deleteCategory" class="mt-4 w-full text-white dark:text-black" :tabindex="4" :disabled="form.processing">
                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                Elimina
            </Button>
        </form>
    </div>
</template>
