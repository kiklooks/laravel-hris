<script setup lang="ts">
import AppLayout from '../../Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { Pencil, Plus, Trash2 } from 'lucide-vue-next';

interface User {
    id: number;
    name: string;
    email: string;
}

interface Department {
    id: number;
    name: string;
}

interface Position {
    id: number;
    name: string;
}

interface Employee {
    id: number;
    employee_number: string;
    phone: string | null;
    gender: string | null;
    hire_date: string;
    employment_status: string;
    user: User;
    department: Department;
    position: Position;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginatedEmployees {
    data: Employee[];
    current_page: number;
    last_page: number;
    from: number | null;
    to: number | null;
    total: number;
    links: PaginationLink[];
}

defineProps<{
    employees: PaginatedEmployees;
}>();

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    });
};

const formatStatus = (status: string) => {
    const labels: Record<string, string> = {
        permanent: 'Tetap',
        contract: 'Kontrak',
        intern: 'Magang',
        probation: 'Probation',
        resigned: 'Resign',
    };

    return labels[status] ?? status;
};

const deleteEmployee = (employee: Employee) => {
    const confirmed = window.confirm(
        `Apakah kamu yakin ingin menghapus data ${employee.user.name}?`
    );

    if (!confirmed) {
        return;
    }

    router.delete(`/employees/${employee.id}`);
};
</script>

<template>
    <AppLayout>
        <div>
            <!-- Header -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">
                        Karyawan
                    </h1>

                    <p class="mt-2 text-slate-600">
                        Kelola data karyawan dalam sistem HRIS.
                    </p>
                </div>

                <Link
                    v-if="$page.props.auth?.user?.permissions?.['employee.create']"
                    href="/employees/create"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800"
                >
                    <Plus class="h-4 w-4" />
                    Tambah Karyawan
                </Link>
            </div>

            <!-- Table -->
            <div class="mt-8 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[900px]">
                        <thead class="border-b border-slate-200 bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    No. Karyawan
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Nama
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Departemen
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Jabatan
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            <tr
                                v-for="employee in employees.data"
                                :key="employee.id"
                                class="transition hover:bg-slate-50"
                            >
                                <td class="px-6 py-4 text-sm font-medium text-slate-800">
                                    {{ employee.employee_number }}
                                </td>

                                <td class="px-6 py-4">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-800">
                                            {{ employee.user.name }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ employee.user.email }}
                                        </p>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ employee.department.name }}
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ employee.position.name }}
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700"
                                    >
                                        {{ formatStatus(employee.employment_status) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <Link
                                            v-if="$page.props.auth?.user?.permissions?.['employee.update']"
                                            :href="`/employees/${employee.id}/edit`"
                                            class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900"
                                            title="Edit"
                                        >
                                            <Pencil class="h-4 w-4" />
                                        </Link>

                                        <button
                                            v-if="$page.props.auth?.user?.permissions?.['employee.delete']"
                                            type="button"
                                            class="rounded-lg p-2 text-slate-500 transition hover:bg-red-50 hover:text-red-600"
                                            title="Hapus"
                                            @click="deleteEmployee(employee)"
                                        >
                                            <Trash2 class="h-4 w-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="employees.data.length === 0">
                                <td
                                    colspan="6"
                                    class="px-6 py-12 text-center text-sm text-slate-500"
                                >
                                    Belum ada data karyawan.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer -->
                <div
                    v-if="employees.total > 0"
                    class="flex flex-col gap-4 border-t border-slate-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between"
                >
                    <p class="text-sm text-slate-500">
                        Menampilkan
                        <span class="font-medium text-slate-700">
                            {{ employees.from }}
                        </span>
                        -
                        <span class="font-medium text-slate-700">
                            {{ employees.to }}
                        </span>
                        dari
                        <span class="font-medium text-slate-700">
                            {{ employees.total }}
                        </span>
                        karyawan
                    </p>

                    <div class="flex items-center gap-1">
                        <Link
                            v-for="(link, index) in employees.links"
                            :key="index"
                            :href="link.url ?? '#'"
                            v-html="link.label"
                            class="rounded-lg px-3 py-2 text-sm transition"
                            :class="[
                                link.active
                                    ? 'bg-slate-900 text-white'
                                    : link.url
                                      ? 'text-slate-600 hover:bg-slate-100'
                                      : 'cursor-not-allowed text-slate-300',
                            ]"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>