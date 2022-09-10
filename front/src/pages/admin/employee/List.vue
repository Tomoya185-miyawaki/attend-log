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
    let employees = ref<Employee[]>([])

    const getEmployees = async () => {
      await ApiService
        .getEmployees()
        .then(response => {
          isLoading.value = false
          employees.value = response.data
        })
        .catch(err => {
          isLoading.value = false
          failedApiAfterLogout(err.response.status)
        })
    }
    getEmployees()

    return {
      isLoading,
      employees
    }
  }
})
</script>
