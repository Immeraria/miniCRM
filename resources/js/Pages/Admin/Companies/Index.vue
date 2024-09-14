<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Companies" />

    <AuthenticatedLayout>
        <template #header>
            <a :href="route('company.create')">Добавить новую компанию</a>
        </template>

        <div class="py-6">
            <div class="container mx-auto mt-8 max-w-screen-xl">
                <div class="overflow-x-auto px-8">
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="py-2 px-4 border">Название компании</th>
                                <th class="py-2 px-4 border">Почта</th>
                                <th class="py-2 px-4 border">Логотип</th>
                                <th class="py-2 px-4 border">Адрес</th>
                                <th class="py-2 px-4 border" style="width: 258px;"></th>
                                <!-- Пустая ячейка для кнопок -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-gray-100" v-for="company in companies" :key="company.id">
                                <td class="py-2 px-4 border">{{ company.name }}</td>
                                <td class="py-2 px-4 border">{{ company.email }}</td>
                                <td class="py-2 px-4 border">{{ company.logo }}</td>
                                <td class="py-2 px-4 border">{{ company.address }}</td>
                                <td class="py-2 px-4 border" style="width: 258px;">
                                    <button
                                        class="bg-blue-700 text-white px-3 py-1 rounded hover:bg-blue-800">Редактировать</button>
                                    <button
                                        class="bg-red-700 text-white px-3 py-1 rounded hover:bg-red-800 ml-2" @click="axios.delete(company.id)">Удалить</button>
                                </td>
                            </tr>
                            <!-- Добавьте дополнительные строки по необходимости -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    props: {
        companies: Array,
    },
};
</script>