<template>
  <HeaderComponent />
  <v-main>
    <v-container>
      <h2 class="mb-4">宮脇智也の出退勤状況</h2>
      <FullCalendar :options="calendarOptions" />
    </v-container>
  </v-main>
  <LoadingComponent />
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import '@fullcalendar/core/vdom'
import FullCalendar from '@fullcalendar/vue3'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import HeaderComponent from '@/components/layouts/HeaderComponent.vue'
import LoadingComponent from '@/components/parts/LoadingComponent.vue'

export default defineComponent({
  name: 'StampEditPage',
  components: {
    HeaderComponent,
    LoadingComponent,
    FullCalendar,
  },
  setup() {
    const calendarOptions = {
      plugins: [ timeGridPlugin, interactionPlugin ],
      initialView: 'timeGridWeek',
      events: [
        {
          title: '勤務',
          start: '2022-09-30 08:00:00',
          end: '2022-09-30 12:00:00',
          editable: true,
        },
        {
          title: '休憩',
          start: '2022-09-30 12:00:00',
          end: '2022-09-30 13:00:00',
          backgroundColor: '#a5f1c0',
          borderColor: '#a5f1c0',
          editable: true,
        },
        {
          title: '出勤',
          date: '2022-09-30 13:00:00',
          end: '2022-09-30 17:00:00',
          editable: true,
        },
      ],
      nowIndicator: true,
      locale: 'ja'
    }

    return {
      calendarOptions
    }
  }
})
</script>