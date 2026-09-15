<script setup lang="ts">
import { ref } from 'vue';
import { usePage, Link, router } from '@inertiajs/vue3';

import {
    LayoutDashboard,
    Users,
    Building2,
    BriefcaseBusiness,
    CalendarCheck,
    Clock3,
    Timer,
    CalendarDays,
    WalletCards,
    ReceiptText,
    FileBarChart,
    Menu,
    X,
    ChevronDown,
} from 'lucide-vue-next';

const page = usePage();

const sidebarOpen = ref(false);
const userMenuOpen = ref(false);

const logout = () => {
    router.post('/logout');
};

const navigationSections = [
    {
        title: 'MAIN',
        items: [
            {
                label: 'Dashboard',
                icon: LayoutDashboard,
                href: '/',
                active: true,
            },
        ],
    },
    {
        title: 'MASTER DATA',
        items: [
            {
                label: 'Karyawan',
                icon: Users,
                href: '/employees',
                permission: 'employees.view',
                active: true,
            },
            {
                label: 'Departemen',
                icon: Building2,
                href: '/departments',
                permission: 'departments.view',
                active: true,
            },
            {
                label: 'Jabatan',
                icon: BriefcaseBusiness,
                href: '/positions',
                permission: 'position.view',
                active: true,
            },
        ],
    },
    {
        title: 'KEHADIRAN',
        items: [
            {
                label: 'Absensi',
                icon: CalendarCheck,
                href: '#',
                active: false,
            },
            {
                label: 'Jadwal Kerja',
                icon: Clock3,
                href: '#',
                active: false,
            },
            {
                label: 'Lembur',
                icon: Timer,
                href: '#',
                active: false,
            },
        ],
    },
    {
        title: 'CUTI',
        items: [
            {
                label: 'Pengajuan Cuti',
                icon: CalendarDays,
                href: '#',
                active: false,
            },
            {
                label: 'Saldo Cuti',
                icon: ReceiptText,
                href: '#',
                active: false,
            },
        ],
    },
    {
        title: 'PAYROLL',
        items: [
            {
                label: 'Penggajian',
                icon: WalletCards,
                href: '#',
                active: false,
            },
            {
                label: 'Slip Gaji',
                icon: ReceiptText,
                href: '#',
                active: false,
            },
        ],
    },
    {
        title: 'LAPORAN',
        items: [
            {
                label: 'Laporan HR',
                icon: FileBarChart,
                href: '#',
                active: false,
            },
        ],
    },
];

const isActive = (href: string) => {
    if (href === '/') {
        return page.component === 'Dashboard';
    }

    return false;
};

const closeSidebar = () => {
    sidebarOpen.value = false;
};
</script>

<template>
    <div class="min-h-screen bg-slate-100">
        <!-- Mobile Overlay -->
        <div
            v-if="sidebarOpen"
            class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"
            @click="closeSidebar"
        />

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r border-slate-200 bg-white transition-transform duration-200"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        >
            <!-- Logo -->
            <div class="flex h-16 shrink-0 items-center justify-between border-b border-slate-200 px-6">
                <div>
                    <h1 class="text-xl font-bold text-slate-900">
                        HRIS
                    </h1>

                    <p class="text-xs text-slate-500">
                        Human Resource System
                    </p>
                </div>

                <button
                    type="button"
                    class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 lg:hidden"
                    @click="closeSidebar"
                >
                    <X class="h-5 w-5" />
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto px-3 py-4">
                <div
                    v-for="section in navigationSections"
                    :key="section.title"
                    class="mb-6"
                >
                    <p class="mb-2 px-3 text-[11px] font-semibold tracking-wider text-slate-400">
                        {{ section.title }}
                    </p>

                    <div class="space-y-1">
                        <template
                            v-for="item in section.items"
                            :key="item.label"
                        >
                            <!-- Active / available route -->
                            <Link
                                v-if="item.href !== '#'"
                                :href="item.href"
                                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition"
                                :class="
                                    isActive(item.href)
                                        ? 'bg-slate-900 text-white'
                                        : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'
                                "
                                @click="closeSidebar"
                            >
                                <component
                                    :is="item.icon"
                                    class="h-5 w-5 shrink-0"
                                    :stroke-width="1.8"
                                />

                                <span>{{ item.label }}</span>
                            </Link>

                            <!-- Future route -->
                            <div
                                v-else
                                class="flex cursor-not-allowed items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-400"
                            >
                                <component
                                    :is="item.icon"
                                    class="h-5 w-5 shrink-0"
                                    :stroke-width="1.8"
                                />

                                <span>{{ item.label }}</span>
                            </div>
                        </template>
                    </div>
                </div>
            </nav>

            <!-- Sidebar Footer -->
            <div class="border-t border-slate-200 p-4">
                <div class="rounded-lg bg-slate-50 p-3">
                    <p class="text-xs font-medium text-slate-700">
                        HRIS System
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        v1.0.0
                    </p>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="lg:pl-64">
            <!-- Topbar -->
            <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 lg:px-6">
                <div class="flex items-center gap-3">
                    <!-- Mobile Menu -->
                    <button
                        type="button"
                        class="rounded-lg p-2 text-slate-600 hover:bg-slate-100 lg:hidden"
                        @click="sidebarOpen = true"
                    >
                        <Menu class="h-5 w-5" />
                    </button>

                    <div>
                        <p class="text-sm font-medium text-slate-900">
                            Human Resource Information System
                        </p>

                        <p class="hidden text-xs text-slate-500 sm:block">
                            Employee management & administration
                        </p>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="relative">
                    <button
                        type="button"
                        class="flex items-center gap-2 rounded-lg px-2 py-1.5 hover:bg-slate-100"
                        @click="userMenuOpen = !userMenuOpen"
                    >
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-900 text-sm font-semibold text-white"
                        >
                            A
                        </div>
                        <div class="hidden text-left sm:block">
                            <p class="text-sm font-medium text-slate-800">
                                Admin
                            </p>
                            <p class="text-xs text-slate-500">
                                Administrator
                            </p>
                        </div>
                        <ChevronDown
                            class="hidden h-4 w-4 text-slate-400 sm:block"
                        />
                    </button>
                    <!-- Dropdown -->
                    <div
                        v-if="userMenuOpen"
                        class="absolute right-0 mt-2 w-48 rounded-lg border border-slate-200 bg-white p-1 shadow-lg"
                    >
                        <button
                            type="button"
                            class="w-full rounded-md px-3 py-2 text-left text-sm font-medium text-red-600 hover:bg-red-50"
                            @click="logout"
                        >
                            Logout
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 lg:p-6">
                <slot />
            </main>
        </div>
    </div>
</template>