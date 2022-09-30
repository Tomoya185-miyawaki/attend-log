<template>
  <HeaderComponent />
  <v-main>
    <v-container>
      <h2 class="mb-4">{{ employeeName }}の出退勤状況</h2>
      <FullCalendar :options="calendarOptions" />
    </v-container>
  </v-main>
  <LoadingComponent :isLoading="isLoading" />
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import '@fullcalendar/core/vdom'
import FullCalendar from '@fullcalendar/vue3'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import HeaderComponent from '@/components/layouts/HeaderComponent.vue'
import LoadingComponent from '@/components/parts/LoadingComponent.vue'
import ApiService from '@/services/ApiService'
import { getTitle, getColor } from '@/util/fullCalendar'
import { useRoute } from 'vue-router'

export default defineComponent({
  name: 'StampEditPage',
  components: {
    HeaderComponent,
    LoadingComponent,
    FullCalendar,
  },
  setup() {
    let isLoading = ref<boolean>(true)
    let employeeName = ref<string>('')
    let calendarOptions = ref<any>(null)
    const route = useRoute()
    const employeeId = route.params.employeeId as string

    calendarOptions.value = {
      plugins: [ timeGridPlugin, interactionPlugin ],
      initialView: 'timeGridWeek',
      events: [],
      nowIndicator: true,
      locale: 'ja',
      allDaySlot: false
    }

    const getStampDetail = async (employeeId: string) => {
      await ApiService
        .getStampDetail(employeeId)
        .then(res => {
          employeeName.value = res.employeeName
          res.stamps.map(stamp => {
            calendarOptions.value.events.push({
                title: getTitle(stamp.status),
                start: stamp.stamp_start_date,
                end: stamp.stamp_end_date,
                backgroundColor: getColor(stamp.status),
                borderColor: getColor(stamp.status),
                editable: true
              })
          })
          isLoading.value = false
        })
    }
    getStampDetail(employeeId)

    return {
      isLoading,
      employeeName,
      calendarOptions
    }
  }
})
</script>