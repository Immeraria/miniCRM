<script setup>
import { ref } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps({
    company: {
        type: Object,
        default: () => ({}), // Установить значение по умолчанию
    },
});

const name = ref(props.company.name || '');
const email = ref(props.company.email || '');
const logo = ref(props.company.logo || '');
const address = ref(props.company.address || '');
const errors = ref({});

const submitForm = async () => {
    errors.value = {}; // Обнулить предыдущие ошибки
    await axios.post(route('company.update'), {
        id: props.company.id,
        name: name.value,
        email: email.value,
        logo: logo.value,
        address: address.value,
        _token: document.querySelector('meta[name="csrf-token"]').value, // CSRF токен
    }).then(response => {
        Swal.fire({
            title: "Уведомление",
            text: "Вы изменили компанию",
            icon: "success"
        });
        // Обработка успешного ответа
        console.log(response.data); // Вывод успешного сообщения
    })
        .catch(error => {
            // Обработка ошибки
            Swal.fire({
                title: "Ошибка",
                text: "Произошла ошибка при обновлении компании.",
                icon: "error"
            });
            console.error(error);
        });
}
</script>

<template>

    <Head title="Edit companies" />

    <AuthenticatedLayout>
        <template #header>
            <a :href="route('company.index')">Вернуться к просмотру компаний</a>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Изменить компанию</h2>

                        <form @submit.prevent="submitForm">
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Название
                                    компании</label>
                                <input type="text" id="name" v-model="name" required
                                    class="mt-1 block w-full p-2 border border-gray-300 bg-white rounded-md focus:ring focus:ring-gray-300 focus:outline-none" />
                                <span class="text-red-600">{{ errors.name ? errors.name[0] : '' }}</span>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" v-model="email" required
                                    class="mt-1 block w-full p-2 border border-gray-300 bg-white rounded-md focus:ring focus:ring-gray-300 focus:outline-none" />
                                <span class="text-red-600">{{ errors.email ? errors.email[0] : '' }}</span>
                            </div>

                            <div class="mb-4">
                                <label for="logo" class="block text-sm font-medium text-gray-700">Логотип
                                    (необязательно)</label>
                                <input type="text" id="logo" v-model="logo"
                                    class="mt-1 block w-full p-2 border border-gray-300 bg-white rounded-md focus:ring focus:ring-gray-300 focus:outline-none" />
                            </div>

                            <div class="mb-4">
                                <label for="address" class="block text-sm font-medium text-gray-700">Адрес сайта</label>
                                <input type="url" id="address" v-model="address" required
                                    class="mt-1 block w-full p-2 border border-gray-300 bg-white rounded-md focus:ring focus:ring-gray-300 focus:outline-none" />
                                <span class="text-red-600">{{ errors.address ? errors.address[0] : '' }}</span>
                            </div>

                            <button type="submit"
                                class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-md hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-300">
                                Изменить
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>