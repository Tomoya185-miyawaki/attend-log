<template>
  <HeaderComponent />
  <v-main>
    <v-container>
      <h2 class="mb-4">2022年9月24日の出退勤状況</h2>
      <v-table>
        <thead>
          <tr>
            <th class="text-left">
              従業員名
            </th>
            <th class="text-left">
              出社時刻
            </th>
            <th class="text-left">
              退社時刻
            </th>
            <th class="text-left">
              休憩時間
            </th>
            <th class="text-left">
              労働時間
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="employee in employees"
            :key="employee.id"
            class="table-row"
            @click="moveEmployeeEditPage(employee.id)"
          >
            <td>{{ employee.name }}</td>
            <td>{{ employee.hourly_wage }}円</td>
            <td>18:00</td>
            <td>1:00</td>
            <td>7:00</td>
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
  <LoadingComponent :isLoading="isLoading" />
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import { Employee } from '@/types/model'
import HeaderComponent from '@/components/layouts/HeaderComponent.vue'
import LoadingComponent from '@/components/parts/LoadingComponent.vue'
import ApiService from '@/services/ApiService'
import { failedApiAfterLogout } from '@/util/auth'
import router from '@/routes/router'

export default defineComponent({
  name: 'StampListPage',
  components: {
    HeaderComponent,
    LoadingComponent,
  },
  setup() {
    let isLoading = ref<boolean>(true)
    let currentPage = ref<number>(1)
    let lastPage = ref<number>(1)
    let employees = ref<Employee[]>([])

    const getEmployees = async (page: number) => {
      isLoading.value = true
      await ApiService
        .getEmployeesByPaginate(page)
        .then(res => {
          isLoading.value = false
          employees.value = res.employees
          currentPage.value = res.currentPage
          lastPage.value = res.lastPage
        })
        .catch(err => {
          isLoading.value = false
          failedApiAfterLogout(err.response.status)
        })
    }
    getEmployees(currentPage.value)

    const moveEmployeeEditPage = (employeeId: number) => {
      router.push({ name: 'employeeEdit', params: { employeeId: employeeId }})
    }

    return {
      isLoading,
      currentPage,
      lastPage,
      employees,
      getEmployees,
      moveEmployeeEditPage
    }
  }
})
</script>

<style scoped>
.table-row:hover {
  cursor: pointer;
}
</style>
