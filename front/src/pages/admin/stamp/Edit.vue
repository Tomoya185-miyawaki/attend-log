<template>
  <HeaderComponent />
  <v-main>
    <v-container>
      <v-row class="text-center">
        <v-col cols="12">
          出退勤詳細
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import HeaderComponent from '@/components/layouts/HeaderComponent.vue'

export default defineComponent({
  name: 'StampEditPage',
  components: {
    HeaderComponent,
  },
})
</script>