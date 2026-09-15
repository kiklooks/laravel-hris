<script setup lang="ts">
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft } from 'lucide-vue-next';

const form = useForm({
    name: '',
    code: '',
    description: '',
});

const submit = () => {
    form.post('/departments');
};
</script>

<template>
    <AppLayout>
        <div class="mx-auto max-w-3xl space-y-6">
            <!-- Header -->
            <div>
                <Link
                    href="/departments"
                    class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-900"
                >
                    <ArrowLeft class="h-4 w-4" />
                    Kembali ke Departemen
                </Link>

                <h1 class="mt-4 text-xl font-semibold text-slate-900">
                    Tambah Departemen
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Tambahkan data departemen baru.
                </p>
            </div>

            <!-- Form -->
            <div
                class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm"
            >
                <form
                    class="space-y-5"
                    @submit.prevent="submit"
                >
                    <!-- Nama -->
                    <div>
                        <label
                            for="name"
                            class="mb-1.5 block text-sm font-medium text-slate-700"
                        >
                            Nama Departemen
                        </label>

                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                            placeholder="Contoh: Human Resources"
                        />

                        <p
                            v-if="form.errors.name"
                            class="mt-1.5 text-sm text-red-600"
                        >
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <!-- Kode -->
                    <div>
                        <label
                            for="code"
                            class="mb-1.5 block text-sm font-medium text-slate-700"
                        >
                            Kode Departemen
                        </label>

                        <input
                            id="code"
                            v-model="form.code"
                            type="text"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm uppercase outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                            placeholder="Contoh: HR"
                        />

                        <p
                            v-if="form.errors.code"
                            class="mt-1.5 text-sm text-red-600"
                        >
                            {{ form.errors.code }}
                        </p>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label
                            for="description"
                            class="mb-1.5 block text-sm font-medium text-slate-700"
                        >
                            Deskripsi
                        </label>

                        <textarea
                            id="description"
                            v-model="form.description"
                            rows="4"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                            placeholder="Deskripsi departemen (opsional)"
                        ></textarea>

                        <p
                            v-if="form.errors.description"
                            class="mt-1.5 text-sm text-red-600"
                        >
                            {{ form.errors.description }}
                        </p>
                    </div>

                    <!-- Actions -->
                    <div
                        class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end"
                    >
                        <Link
                            href="/departments"
                            class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                        >
                            Batal
                        </Link>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            {{
                                form.processing
                                    ? 'Menyimpan...'
                                    : 'Simpan Departemen'
                            }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>