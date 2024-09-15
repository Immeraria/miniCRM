<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Swal from 'sweetalert2'
import axios from 'axios';
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
                                <th class="py-2 px-4 border" style="width: 206px;">Название компании</th>
                                <th class="py-2 px-4 border" style="width: 317px;">Почта</th>
                                <th class="py-2 px-4 border" style="width: 106px;">Логотип</th>
                                <th class="py-2 px-4 border" style="width: 327px;">Адрес</th>
                                <th class="py-2 px-4 border" style="width: 258px;"></th>
                                <!-- Пустая ячейка для кнопок -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-gray-100" v-for="(company, index) in companies" :key="company.id">
                                <td class="py-2 px-4 border w-206"> <p class="truncate">{{ company.name }}</p></td>
                                <td class="py-2 px-4 border w-317 truncate"> <p class="truncate">{{ company.email }}</p></td>
                                <td class="py-2 px-4 border w-106 truncate"> <p class="truncate">{{ company.logo }}</p></td>
                                <td class="py-2 px-4 border w-327"> <p class="truncate">{{ company.address }}</p></td>
                                <td class="py-2 px-4 border w-258">
                                    <button class="bg-blue-700 text-white px-3 py-1 rounded hover:bg-blue-800">
                                        <a :href="route('company.edit', company.id)">
                                            Редактировать
                                        </a>    
                                    </button>
                                    <button type="submit"
                                    class="bg-red-700 text-white px-3 py-1 rounded hover:bg-red-800 ml-2"
                                    @click="deleteCompany(company.id, index)">
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
        companies: Array,
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