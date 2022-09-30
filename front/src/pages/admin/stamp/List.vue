<template>
  <HeaderComponent />
  <v-main>
    <v-container>
      <h2 class="mb-4">{{ todayFormat }}の出退勤状況</h2>
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
            v-for="(stamp, employeeName, index) in stamps"
            :key="employeeIds[index]"
            class="table-row"
            @click="moveStampEditPage(employeeIds[index])"
          >
            <td>{{ employeeName }}</td>
            <td>{{ stamp.attend_date }}</td>
            <td>{{ stamp.leaving_date }}</td>
            <td>{{ stamp.rest_date }}</td>
            <td>{{ stamp.working_date }}</td>
          </tr>
        </tbody>
      </v-table>
      <v-pagination
        v-model="currentPage"
        class="my-4"
        :length="lastPage"
        @click="getStamps(today, currentPage)"
      ></v-pagination>
    </v-container>
  </v-main>
  <LoadingComponent :isLoading="isLoading" />
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import { StampList } from '@/types/stamp'
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
    let stamps = ref<StampList[]>([])
    let employeeIds = ref<number[]>([])
    const date = new Date()
    const year = date.getFullYear()
    const month = ('0' + (date.getMonth() + 1)).slice(-2)
    const day = ('0' + (date.getDate())).slice(-2)
    const today = `${year}-${month}-${day}`
    const todayFormat = `${year}年${month}月${day}日`

    const getStamps = async (today: string, page: number) => {
      isLoading.value = true
      console.log
      await ApiService
        .getStampsByPaginate(today, page)
        .then(res => {
          isLoading.value = false
          stamps.value = res.stamps
          employeeIds.value = res.employeeIds
          currentPage.value = res.currentPage
          lastPage.value = res.lastPage
        })
        .catch(err => {
          isLoading.value = false
          failedApiAfterLogout(err.response.status)
        })
    }
    getStamps(today, currentPage.value)

    const moveStampEditPage = (employeeId: number) => {
      router.push({ name: 'stampEdit', params: { employeeId: employeeId }})
    }

    return {
      isLoading,
      currentPage,
      lastPage,
      stamps,
      employeeIds,
      today,
      todayFormat,
      getStamps,
      moveStampEditPage
    }
  }
})
</script>

<style scoped>
.table-row:hover {
  cursor: pointer;
}
</style>
