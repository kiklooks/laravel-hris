<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { Plus, Pencil, Trash2 } from 'lucide-vue-next';

interface Department {
    id: number;
    name: string;
    code: string;
    description: string | null;
    employees_count: number;
}

interface PaginatedDepartments {
    data: Department[];
    current_page: number;
    last_page: number;
    from: number | null;
    to: number | null;
    total: number;
    links: {
        url: string | null;
        label: string;
        active: boolean;
    }[];
}

interface PageProps {
    departments: PaginatedDepartments;
    flash: {
        success?: string;
        error?: string;
    };
    auth: {
        user: {
            permissions: {
                'department.create': boolean;
                'department.update': boolean;
                'department.delete': boolean;
            };
        };
    };
}

const page = usePage<PageProps>();

const canCreate = () => page.props.auth.user.permissions['department.create'];
const canUpdate = () => page.props.auth.user.permissions['department.update'];
const canDelete = () => page.props.auth.user.permissions['department.delete'];

const deleteDepartment = (department: Department) => {
    if (
        !window.confirm(
            `Yakin ingin menghapus departemen "${department.name}"?`,
        )
    ) {
        return;
    }

    router.delete(`/departments/${department.id}`);
};

const formatPaginationLabel = (label: string) => {
    return label
        .replace('&laquo; Previous', 'Sebelumnya')
        .replace('Next &raquo;', 'Berikutnya');
};
</script>

<template>
    <AppLayout>
        <div class="space-y-6">
            <!-- Header -->
            <div
                class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
            >
                <div>
                    <h1 class="text-xl font-semibold text-slate-900">
                        Departemen
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Kelola data departemen perusahaan.
                    </p>
                </div>

                <Link
                    v-if="canCreate()"
                    href="/departments/create"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800"
                >
                    <Plus class="h-4 w-4" />
                    Tambah Departemen
                </Link>
            </div>

            <!-- Flash Message -->
            <div
                v-if="page.props.flash?.success"
                class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"
            >
                {{ page.props.flash.success }}
            </div>
            
            <div
                v-if="page.props.flash?.error"
                class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
            >
                {{ page.props.flash.error }}
            </div>

            <!-- Table -->
            <div
                class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm"
            >
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500"
                                >
                                    Departemen
                                </th>

                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500"
                                >
                                    Kode
                                </th>

                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500"
                                >
                                    Deskripsi
                                </th>

                                <th
                                    class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500"
                                >
                                    Karyawan
                                </th>

                                <th
                                    class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500"
                                >
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            <tr
                                v-for="department in page.props.departments.data"
                                :key="department.id"
                                class="hover:bg-slate-50"
                            >
                                <td
                                    class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900"
                                >
                                    {{ department.name }}
                                </td>

                                <td
                                    class="whitespace-nowrap px-6 py-4 text-sm text-slate-600"
                                >
                                    {{ department.code }}
                                </td>

                                <td
                                    class="max-w-xs px-6 py-4 text-sm text-slate-600"
                                >
                                    {{
                                        department.description ||
                                        'Tidak ada deskripsi'
                                    }}
                                </td>

                                <td
                                    class="whitespace-nowrap px-6 py-4 text-center text-sm text-slate-600"
                                >
                                    {{ department.employees_count }}
                                </td>

                                <td
                                    class="whitespace-nowrap px-6 py-4 text-right"
                                >
                                    <div
                                        class="flex justify-end gap-2"
                                    >
                                        <Link
                                            v-if="canUpdate()"
                                            :href="`/departments/${department.id}/edit`"
                                            class="inline-flex items-center gap-1.5 rounded-md px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-slate-900"
                                        >
                                            <Pencil class="h-4 w-4" />
                                            Edit
                                        </Link>

                                        <button
                                            v-if="canDelete()"
                                            type="button"
                                            class="inline-flex items-center gap-1.5 rounded-md px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50"
                                            @click="
                                                deleteDepartment(department)
                                            "
                                        >
                                            <Trash2 class="h-4 w-4" />
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr
                                v-if="
                                    page.props.departments.data.length === 0
                                "
                            >
                                <td
                                    colspan="5"
                                    class="px-6 py-12 text-center text-sm text-slate-500"
                                >
                                    Belum ada data departemen.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div
                    v-if="page.props.departments.last_page > 1"
                    class="flex flex-col gap-3 border-t border-slate-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between"
                >
                    <p class="text-sm text-slate-500">
                        Menampilkan
                        {{ page.props.departments.from }}
                        -
                        {{ page.props.departments.to }}
                        dari
                        {{ page.props.departments.total }}
                        departemen
                    </p>

                    <div class="flex flex-wrap gap-1">
                        <template
                            v-for="(link, index) in page.props.departments
                                .links"
                            :key="index"
                        >
                            <Link
                                v-if="link.url"
                                :href="link.url"
                                class="rounded-md border px-3 py-1.5 text-sm transition"
                                :class="
                                    link.active
                                        ? 'border-slate-900 bg-slate-900 text-white'
                                        : 'border-slate-200 text-slate-600 hover:bg-slate-50'
                                "
                            >
                                {{ formatPaginationLabel(link.label) }}
                            </Link>

                            <span
                                v-else
                                class="rounded-md border border-slate-100 px-3 py-1.5 text-sm text-slate-300"
                            >
                                {{ formatPaginationLabel(link.label) }}
                            </span>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>