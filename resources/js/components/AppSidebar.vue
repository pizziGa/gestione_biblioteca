<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { ArrowLeft, Book, Users, List, Bookmark } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const prefix: string = '/dashboard/';

const mainNavItems: NavItem[] = [
    {
        title: 'Catalogo',
        href: prefix + 'catalogo',
        icon: Book,
    },
    {
        title: 'Categorie',
        href: prefix + 'categorie',
        icon: List,
    },
    {
        title: 'Prenotazioni',
        href: prefix + 'prenotazioni',
        icon: Bookmark,
    },
    {
        title: 'Utenti',
        href: prefix + 'utenti',
        icon: Users,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Torna all\'app',
        href: '/',
        icon: ArrowLeft,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
