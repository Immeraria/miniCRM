<script setup>
import {ref} from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps({
  employee: {
    type: Object,
    default: () => ({}), // Установить значение по умолчанию
  },
  companies: {
    type: Object,
    default: () => ({}), // Установить значение по умолчанию
  }
});

const name = ref(props.employee.name || '')
const surname = ref(props.employee.surname || '')
const companyId = ref(props.employee.company_id || '')
const email = ref(props.employee.email || '')
const phoneNum = ref(props.employee.phone_num || '')
const errors = ref({})

const submitForm = async () => {
  errors.value = {}; // Обнулить предыдущие ошибки
  await axios.post(route('employee.update'), {
    id: props.employee.id,
    name: name.value,
    surname: surname.value,
    email: email.value,
    phone_num: phoneNum.value,
    company_id: companyId.value,
    _token: document.querySelector('meta[name="csrf-token"]').value, // CSRF токен
  }).then(response => {
    Swal.fire({
      title: "Уведомление",
      text: "Вы изменили сотрудника",
      icon: "success"
    });
    // Обработка успешного ответа
    console.log(response.data); // Вывод успешного сообщения
  })
      .catch(error => {
        // Обработка ошибки
        Swal.fire({
          title: "Ошибка",
          text: "Произошла ошибка при обновлении сотрудника.",
          icon: "error"
        });
        console.error(error);
      });
}
</script>

<template>

  <Head title="Edit companies"/>

  <AuthenticatedLayout>
    <template #header>
      <a :href="route('employee.index')">Вернуться к просмотру сотрудников</a>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Изменить сотрудника</h2>

            <form @submit.prevent="submitForm">
              <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Имя работника</label>
                <input type="text" id="name" v-model="name" required
                       class="mt-1 block w-full p-2 border border-gray-300 bg-white rounded-md focus:ring focus:ring-gray-300 focus:outline-none"/>
                <span class="text-red-600">{{ errors.name ? errors.name[0] : '' }}</span>
              </div>

              <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Фамилия работника</label>
                <input type="text" id="email" v-model="surname" required
                       class="mt-1 block w-full p-2 border border-gray-300 bg-white rounded-md focus:ring focus:ring-gray-300 focus:outline-none"/>
                <span class="text-red-600">{{ errors.email ? errors.email[0] : '' }}</span>
              </div>

              <div class="mb-4">
                <label for="logo" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="logo" v-model="email"
                       class="mt-1 block w-full p-2 border border-gray-300 bg-white rounded-md focus:ring focus:ring-gray-300 focus:outline-none"/>
              </div>

              <div class="mb-4">
                <label for="company_id" class="block text-sm font-medium text-gray-700">Компания</label>
                <select id="company_id" v-model="companyId"
                        class="mt-1 block w-full p-2 border border-gray-300 bg-white rounded-md focus:ring focus:ring-gray-300 focus:outline-none"
                        required>
                  <option :selected="employee.company_id" v-for="company in companies" :value="company.id" :key="company.id">
                    {{ company.name }}
                  </option>
                </select>
              </div>

              <div class="mb-4">
                <label for="logo" class="block text-sm font-medium text-gray-700">Номер телефона</label>
                <input type="text" id="logo" v-model="phoneNum"
                       class="mt-1 block w-full p-2 border border-gray-300 bg-white rounded-md focus:ring focus:ring-gray-300 focus:outline-none"/>
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