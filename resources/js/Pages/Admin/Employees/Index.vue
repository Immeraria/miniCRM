<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Swal from 'sweetalert2'
import axios from 'axios';
</script>

<template>

    <Head title="Employees" />

    <AuthenticatedLayout>
        <template #header>
            <a :href="route('employee.create')">Добавить нового сотрудника</a>
        </template>

        <div class="py-6">
            <div class="container mx-auto mt-8 max-w-screen-xl">
                <div class="overflow-x-auto px-8">
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="py-2 px-4 border">Имя</th>
                                <th class="py-2 px-4 border">Фамилия</th>
                                <th class="py-2 px-4 border">Компания</th>
                                <th class="py-2 px-4 border">Почта</th>
                                <th class="py-2 px-4 border">Телефон</th>
                                <th class="py-2 px-4 border"></th>
                                <!-- Пустая ячейка для кнопок -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-gray-100" v-for="(employee, index) in companies" :key="employee.id">
                                <td class="py-2 px-4 border">{{ employee.name }}</td>
                                <td class="py-2 px-4 border">{{ employee.surname }}</td>
                                <td class="py-2 px-4 border">{{ employee.company_id }}</td>
                                <td class="py-2 px-4 border">{{ employee.email }}</td>
                                <td class="py-2 px-4 border">{{ employee.phone_num }}</td>
                                <td class="py-2 px-4 border">
                                    <button type="submit"
                                    class="bg-red-700 text-white px-3 py-1 rounded hover:bg-red-800 ml-2"
                                    @click="deleteEmployee(employee.id, index)">
                                        Удалить
                                    </button>
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
        employee: Array,
    },

    methods: {
        // удаление компании
        async deleteCompany(id, index) {
            Swal.fire({
                title: "Подтвердите",
                text: "Вы действительно хотите удалить компанию?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Да",
                cancelButtonText: "Нет",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    await axios.delete(route('company.destroy', id));
                    this.companies.splice(index, 1)
                    Swal.fire({
                        title: "Уведомление",
                        text: "Вы удалили компанию",
                        icon: "success"
                    });
                }
            });
        },
    }
};
</script>