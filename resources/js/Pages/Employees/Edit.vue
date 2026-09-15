<script setup lang="ts">
import AppLayout from '../../Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';

interface Department {
    id: number;
    name: string;
}

interface Position {
    id: number;
    name: string;
}

interface User {
    id: number;
    name: string;
    email: string;
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

const props = defineProps<{
    employee: Employee;
    departments: Department[];
    positions: Position[];
    users: User[];
}>();

const form = useForm({
    employee_number: props.employee.employee_number,
    user_id: String(props.employee.user.id),
    phone: props.employee.phone ?? '',
    gender: props.employee.gender ?? '',
    hire_date: props.employee.hire_date.slice(0, 10),
    employment_status: props.employee.employment_status,
    department_id: String(props.employee.department.id),
    position_id: String(props.employee.position.id),
});

const submit = () => {
    form.put(`/employees/${props.employee.id}`);
};
</script>

<template>
    <AppLayout>
        <div class="max-w-4xl">
            <!-- Header -->
            <div class="mb-8">
                <Link
                    href="/employees"
                    class="mb-4 inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-900"
                >
                    <ArrowLeft class="h-4 w-4" />
                    Kembali ke Karyawan
                </Link>

                <h1 class="text-3xl font-bold text-slate-900">
                    Edit Karyawan
                </h1>

                <p class="mt-2 text-slate-600">
                    Perbarui data karyawan dalam sistem HRIS.
                </p>
            </div>

            <!-- Form -->
            <form
                @submit.prevent="submit"
                class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8"
            >
                <div class="grid gap-6 md:grid-cols-2">
                    <!-- User -->
                    <div class="md:col-span-2">
                        <label
                            for="user_id"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Akun User
                        </label>

                        <select
                            id="user_id"
                            v-model="form.user_id"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                        >
                            <option
                                v-for="user in props.users"
                                :key="user.id"
                                :value="String(user.id)"
                            >
                                {{ user.name }} — {{ user.email }}
                            </option>
                        </select>

                        <p
                            v-if="form.errors.user_id"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.user_id }}
                        </p>
                    </div>

                    <!-- Employee Number -->
                    <div>
                        <label
                            for="employee_number"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Nomor Karyawan
                        </label>

                        <input
                            id="employee_number"
                            v-model="form.employee_number"
                            type="text"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                        />

                        <p
                            v-if="form.errors.employee_number"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.employee_number }}
                        </p>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label
                            for="phone"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            No. HP
                        </label>

                        <input
                            id="phone"
                            v-model="form.phone"
                            type="text"
                            placeholder="Contoh: 081234567806"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                        />

                        <p
                            v-if="form.errors.phone"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.phone }}
                        </p>
                    </div>

                    <!-- Gender -->
                    <div>
                        <label
                            for="gender"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Gender
                        </label>

                        <select
                            id="gender"
                            v-model="form.gender"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                        >
                            <option value="">Pilih gender</option>
                            <option value="male">Laki-laki</option>
                            <option value="female">Perempuan</option>
                        </select>

                        <p
                            v-if="form.errors.gender"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.gender }}
                        </p>
                    </div>

                    <!-- Hire Date -->
                    <div>
                        <label
                            for="hire_date"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Tanggal Masuk
                        </label>

                        <input
                            id="hire_date"
                            v-model="form.hire_date"
                            type="date"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                        />

                        <p
                            v-if="form.errors.hire_date"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.hire_date }}
                        </p>
                    </div>

                    <!-- Employment Status -->
                    <div>
                        <label
                            for="employment_status"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Status Kepegawaian
                        </label>

                        <select
                            id="employment_status"
                            v-model="form.employment_status"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                        >
                            <option value="permanent">Tetap</option>
                            <option value="contract">Kontrak</option>
                            <option value="intern">Magang</option>
                            <option value="probation">Probation</option>
                            <option value="resigned">Resign</option>
                        </select>

                        <p
                            v-if="form.errors.employment_status"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.employment_status }}
                        </p>
                    </div>

                    <!-- Department -->
                    <div>
                        <label
                            for="department_id"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Departemen
                        </label>

                        <select
                            id="department_id"
                            v-model="form.department_id"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                        >
                            <option
                                v-for="department in props.departments"
                                :key="department.id"
                                :value="String(department.id)"
                            >
                                {{ department.name }}
                            </option>
                        </select>

                        <p
                            v-if="form.errors.department_id"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.department_id }}
                        </p>
                    </div>

                    <!-- Position -->
                    <div>
                        <label
                            for="position_id"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Jabatan
                        </label>

                        <select
                            id="position_id"
                            v-model="form.position_id"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                        >
                            <option
                                v-for="position in props.positions"
                                :key="position.id"
                                :value="String(position.id)"
                            >
                                {{ position.name }}
                            </option>
                        </select>

                        <p
                            v-if="form.errors.position_id"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.position_id }}
                        </p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex justify-end gap-3 border-t border-slate-200 pt-6">
                    <Link
                        href="/employees"
                        class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Batal
                    </Link>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>