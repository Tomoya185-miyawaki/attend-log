<template>
  <HeaderComponent />
  <v-main>
    <v-container>
      <v-table>
        <thead>
          <tr>
            <th class="text-left">
              従業員名
            </th>
            <th class="text-left">
              時給
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="employee in employees"
            :key="employee.id"
          >
            <td>{{ employee.name }}</td>
            <td>{{ employee.hourly_wage }}円</td>
          </tr>
        </tbody>
      </v-table>
      <v-pagination
        v-model="currentPage"
        class="my-4"
        :length="lastPage"
        @click="getEmployees(currentPage)"
      ></v-pagination>
    </v-container>
  </v-main>
  <FooterComponent />
  <LoadingComponent :isLoading="isLoading" />
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import { Employee } from "@/types/model"
import HeaderComponent from '@/components/layouts/HeaderComponent.vue';
import FooterComponent from '@/components/layouts/FooterComponent.vue';
import LoadingComponent from '@/components/parts/LoadingComponent.vue'
import ApiService from '@/services/ApiService';
import { failedApiAfterLogout } from '@/util/auth'

export default defineComponent({
  name: 'EmployeeListPage',
  components: {
    HeaderComponent,
    FooterComponent,
    LoadingComponent,
  },
  setup() {
    let isLoading = ref<boolean>(true)
    let currentPage = ref<number>(1)
    let lastPage = ref<number>(1)
    let perPage = ref<number>(10)
    let employees = ref<Employee[]>([])

    const getEmployees = async (page: number) => {
      isLoading.value = true
      await ApiService
        .getEmployeesByPaginate(page)
        .then(response => {
          isLoading.value = false
          employees.value = response.data.employees
          currentPage.value = response.data.currentPage
          lastPage.value = response.data.lastPage
        })
        .catch(err => {
          isLoading.value = false
          failedApiAfterLogout(err.response.status)
        })
    }
    getEmployees(currentPage.value)

    return {
      isLoading,
      currentPage,
      lastPage,
      perPage,
      employees,
      getEmployees
    }
  }
})
</script>
