<script setup lang="ts">
import Icon from '@/components/Icon.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { router, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({ book: [Object, null], categories: Object, update: Boolean });

const currentYear = new Date().getFullYear();
const years = Array.from({ length: currentYear - 1940 + 1 }, (_, i) => currentYear - i);

const form = useForm({
    title: props.update ? props.book?.title : '',
    author: props.update ? props.book?.author : '',
    publisher: props.update ? props.book?.publisher : '',
    category: props.update ? props.book?.category?.id : null,
    year: props.update ? props.book?.year : currentYear,
    isbn: props.update ? props.book?.ISBN : '',
    description: props.update ? props.book?.description : '',
    cover: '',
    tags: props.update ? props.book?.tags : '',
});

const previewUrl = ref();
const coverUrl = ref(props.book?.cover);

const emit = defineEmits(['closeModal']);

const submit = () => {
    if (props.update) {
        form.post('/dashboard/catalogo/' + props.book?.id + '/update');
    } else {
        form.post(route('catalogo'));
    }
};

function deleteBook(id: number) {
    router.delete('/dashboard/catalogo/' + id);
    emit('closeModal');
}

function onFileChange() {
    const file = event?.target?.files[0];
    if (!file) return;
    previewUrl.value = URL.createObjectURL(file);
}
</script>

<template>
    <div class="m-2 mx-auto flex flex-col gap-2 rounded-2xl dark:bg-neutral-900 bg-neutral-100 p-12">
        <form @submit.prevent="submit">
            <div class="flex flex-col gap-5">
                <div class="flex flex-row gap-3">
                    <div class="flex flex-col gap-2">
                        <label
                            for="inputzone"
                            class="h-72 w-56 items-center rounded-xl border-2 border-dashed border-zinc-200 bg-zinc-300 dark:border-zinc-800 dark:bg-zinc-900 hover:dark:bg-zinc-950"
                        >
                            <img v-if="previewUrl" :src="previewUrl" class="h-full w-full rounded-xl" />
                            <img v-else-if="props.update && !previewUrl" :src="'/storage/' + coverUrl" class="h-full w-full rounded-xl" />
                            <Icon v-else name="Plus" class="h-full w-full opacity-25" />
                            <input
                                id="inputzone"
                                type="file"
                                @input="form.cover = $event?.target?.files[0]"
                                @change="onFileChange"
                                class="invisible"
                            />
                        </label>
                        <InputError :message="form.errors.cover" />
                    </div>
                    <div class="flex w-full flex-col gap-3">
                        <div class="flex flex-col gap-2 text-black dark:text-white">
                            <Label for="title">Titolo</Label>
                            <input class="rounded-xl dark:bg-neutral-800 bg-zinc-200 p-2" id="title" required v-model="form.title" />
                            <InputError :message="form.errors.title" />
                        </div>
                        <div class="flex flex-col gap-2 text-black dark:text-white">
                            <Label for="author">Autore</Label>
                            <input class="rounded-xl dark:bg-neutral-800 bg-zinc-200 p-2" id="author" required v-model="form.author" />
                            <InputError :message="form.errors.author" />
                        </div>
                        <div class="flex flex-col gap-2 text-black dark:text-white">
                            <Label for="publisher">Editore</Label>
                            <input class="rounded-xl dark:bg-neutral-800 bg-zinc-200 p-2" id="publisher" v-model="form.publisher" />
                            <InputError :message="form.errors.publisher" />
                        </div>
                        <div class="flex flex-col gap-2 text-black dark:text-white">
                            <Label for="isbn">ISBN-13</Label>
                            <input class="rounded-xl dark:bg-neutral-800 bg-zinc-200 p-2" id="isbn" v-model="form.isbn" />
                            <InputError :message="form.errors.isbn" />
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2 text-black dark:text-white">
                    <Label>Descrizione</Label>
                    <textarea v-model="form.description" class="max-h-56 min-h-24 rounded-2xl p-4 dark:bg-neutral-800 bg-zinc-200" />
                    <InputError :message="form.errors.description" />
                </div>

                <div class="flex flex-row gap-2">
                    <div class="flex flex-col gap-2 text-black dark:text-white">
                        <Label for="tags">Parole chiave</Label>
                        <input class="rounded-xl dark:bg-neutral-800 bg-zinc-200 p-2" id="tags" v-model="form.tags" placeholder="es. draghi, programmazione, ecc." />
                        <InputError :message="form.errors.tags" />
                    </div>
                    <div class="flex w-full flex-row items-center gap-2">
                        <div class="flex flex-col gap-2 text-black dark:text-white">
                            <Label for="year">Categoria</Label>
                            <select v-model="form.category" class="rounded-xl dark:bg-neutral-800 bg-zinc-200 p-2">
                                <option v-for="category in categories" :key="category.id" :value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>
                            <InputError :message="form.errors.category" />
                        </div>
                        <div class="flex flex-col gap-2 text-black dark:text-white">
                            <Label for="year">Anno di pubblicazione</Label>
                            <select v-model="form.year" class="rounded-xl dark:bg-neutral-800 bg-zinc-200 p-2">
                                <option v-for="year in years" :key="year" :value="year">
                                    {{ year }}
                                </option>
                            </select>
                            <InputError :message="form.errors.year" />
                        </div>
                    </div>
                </div>
            </div>
            <Button type="submit" class="mt-4 w-full text-white dark:text-black" :tabindex="4" :disabled="form.processing">
                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                {{ props.update ? 'Modifica' : 'Aggiungi' }}
            </Button>
        </form>
        <button v-if="update" @click="deleteBook(book?.id)" class="w-full rounded-md bg-red-500 text-black">Elimina</button>
    </div>
</template>
