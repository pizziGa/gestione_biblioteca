<script setup lang="ts">
import AppLogo from '@/components/AppLogo.vue';
import Icon from '@/components/Icon.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import UserMenuContent from '@/components/UserMenuContent.vue';
import { getInitials } from '@/composables/useInitials';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const auth = computed(() => page.props.auth);
</script>

<template>
    <div
        class="sticky top-0 mx-auto flex h-16 items-center border-[1px] border-t-0 border-r-0 border-l-0 border-b-neutral-300 dark:border-b-neutral-800 px-4 md:max-w-7xl dark:bg-neutral-950"
    >
        <nav class="flex h-full w-full flex-row items-center gap-5">
            <Link href="/">
                <AppLogo />
            </Link>
            <nav class="flex h-9 flex-row items-center gap-2 text-sm">
                <Link :href="route('customer.catalogo')" class="flex flex-row items-center gap-2 rounded-md p-2 font-semibold hover:bg-neutral-200 dark:hover:bg-neutral-800">
                    <Icon name="Book" />
                    Sfoglia il catalogo
                </Link>
                <Link href="/prenotazioni" class="flex flex-row items-center gap-2 rounded-md p-2 font-semibold hover:bg-neutral-200 dark:hover:bg-neutral-800">
                    <Icon name="Bookmark" />
                    Le mie prenotazioni
                </Link>
            </nav>
            <div class="flex-1" />
            <nav class="flex h-9 flex-row items-center gap-2 text-sm">
                <Link
                    v-if="page.props.auth.user.role === 'admin'"
                    href="/dashboard"
                    class="flex flex-row items-center gap-2 rounded-md p-2 font-semibold hover:bg-neutral-200 dark:hover:bg-neutral-800"
                >
                    <Icon name="Grid" />
                    Dashboard
                </Link>
                <DropdownMenu>
                    <DropdownMenuTrigger :as-child="true">
                        <Button
                            variant="ghost"
                            size="icon"
                            class="relative size-10 w-auto rounded-full p-1 focus-within:ring-2 focus-within:ring-primary"
                        >
                            <Avatar class="size-8 overflow-hidden rounded-full">
                                <AvatarImage v-if="auth.user.avatar" :src="auth.user.avatar" :alt="auth.user.name" />
                                <AvatarFallback class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white">
                                    {{ getInitials(auth.user?.name) }}
                                </AvatarFallback>
                            </Avatar>
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end" class="w-56">
                        <UserMenuContent :user="auth.user" />
                    </DropdownMenuContent>
                </DropdownMenu>
            </nav>
        </nav>
    </div>
</template>
