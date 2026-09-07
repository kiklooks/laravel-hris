<script setup lang="ts">
import AppLayout from '../Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout>
        <div>
            <h1 class="text-3xl font-bold text-slate-900">
                Dashboard
            </h1>

            <p class="mt-2 text-slate-600">
                Selamat datang di Human Resource Information System.
            </p>

            <div class="mt-8 grid gap-6 md:grid-cols-3">
                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <p class="text-sm text-slate-500">
                        Total Karyawan
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        0
                    </p>
                </div>

                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <p class="text-sm text-slate-500">
                        Hadir Hari Ini
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        0
                    </p>
                </div>

                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <p class="text-sm text-slate-500">
                        Pengajuan Cuti
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        0
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>