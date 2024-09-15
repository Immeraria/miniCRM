<script setup>
import {ref} from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Swal from 'sweetalert2'

const name = ref('');
const surname = ref('');
const company_id = ref('');
const email = ref('');
const phone_num = ref('');
const errors = ref({});


const submitForm = async () => {
  errors.value = {}; // Сброс ошибок перед отправкой
  try {
    await axios.post(route('employee.store'), {
      name: name.value,
      surname: surname.value,
      company_id: company_id.value,
      email: email.value,
      phone_num: phone_num.value,
      _token: document.querySelector('meta[name="csrf-token"]').value, // CSRF токен
    }).then(response => {
      // Обработка успешного ответа
      Swal.fire({
        title: "Уведомление",
        text: "Вы добавили нового сотрудника!",
        icon: "success"
      });
      console.log(response.data); // Вывод успешного сообщения
    })
        .catch(error => {
          // Обработка ошибки
          console.error(error);
        })
  } catch (error) {
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors;
    } else {
      errors.value = {message: 'Произошла ошибка при отправке запроса'};
    }
  }
};

</script>

<template>

  <Head title="Create employee"/>

  <AuthenticatedLayout>
    <template #header>
      <a :href="route('employee.index')">Вернуться к просмотру сотрудников</a>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Добавить сотрудника</h2>

            <form @submit.prevent="submitForm">
              <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Имя сотрудника*</label>
                <input type="text" id="name" v-model="name" required
                       class="mt-1 block w-full p-2 border border-gray-300 bg-white rounded-md focus:ring focus:ring-gray-300 focus:outline-none"/>
                <span class="text-red-600">{{ errors.name ? errors.name[0] : '' }}</span>
              </div>

              <div class="mb-4">
                <label for="surname" class="block text-sm font-medium text-gray-700">Фамилия
                  сотрудника*</label>
                <input type="text" id="surname" v-model="surname" required
                       class="mt-1 block w-full p-2 border border-gray-300 bg-white rounded-md focus:ring focus:ring-gray-300 focus:outline-none"/>
                <span class="text-red-600">{{ errors.surname ? errors.surname[0] : '' }}</span>
              </div>

              <div class="mb-4">
                <label for="company_id" class="block text-sm font-medium text-gray-700">Компания сотрудника</label>
                <select id="company_id" v-model="company_id"
                        class="mt-1 block w-full p-2 border border-gray-300 bg-white rounded-md focus:ring focus:ring-gray-300 focus:outline-none"
                        required>
                  <option value="" disabled selected>Выберите компанию</option>
                  <option v-for="company in companies" :value="company.id" :key="company.id">
                    {{ company.name }}
                  </option>
                </select>
              </div>

              <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email сотрудника</label>
                <input type="email" id="email" v-model="email"
                       class="mt-1 block w-full p-2 border border-gray-300 bg-white rounded-md focus:ring focus:ring-gray-300 focus:outline-none"/>
              </div>

              <div class="mb-4">
                <label for="logo" class="block text-sm font-medium text-gray-700">Номер телефона
                  сотрудника</label>
                <input type="text" id="phone_num" v-model="phone_num"
                       class="mt-1 block w-full p-2 border border-gray-300 bg-white rounded-md focus:ring focus:ring-gray-300 focus:outline-none"/>
              </div>


              <button type="submit"
                      class="px-4 py-2 bg-gray-500 text-white font-semibold rounded-md hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-300">
                Добавить
              </button>
            </form>
          </div>
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