<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Swal from 'sweetalert2'
import axios from 'axios';
</script>

<template>

  <Head title="Employees"/>

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
            <tr class="hover:bg-gray-100" v-for="(employee, index) in employees" :key="employee.id">
              <td class="py-2 px-4 border">{{ employee.name }}</td>
              <td class="py-2 px-4 border">{{ employee.surname }}</td>
              <td class="py-2 px-4 border">{{ employee.company.name }}</td>
              <td class="py-2 px-4 border">{{ employee.email }}</td>
              <td class="py-2 px-4 border">{{ employee.phone_num }}</td>
              <td class="py-2 px-4 border">
                <button class="bg-blue-700 text-white px-3 py-1 rounded hover:bg-blue-800">
                  <a :href="route('employee.edit', employee.id)">
                    Редактировать
                  </a>
                </button>
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
    employees: Array,
    companies: Array
  },

  methods: {
    // удаление компании
    deleteEmployee(id, index) {
      Swal.fire({
        title: "Подтвердите",
        text: "Вы действительно хотите удалить сотрудника?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Да",
        cancelButtonText: "Нет",
      }).then(async (result) => {
        if (result.isConfirmed) {
          await axios.delete(route('employee.destroy', id));
          this.employees.splice(index, 1)
          Swal.fire({
            title: "Уведомление",
            text: "Вы удалили сотрудника",
            icon: "success"
          });
        }
      });
    },
  }
};
</script>