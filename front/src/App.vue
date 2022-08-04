<template>
  <v-app id="app">
    <v-main>
      <Login/>
    </v-main>
  </v-app>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Login from '@/components/Login.vue'

export default defineComponent({
  name: 'App',

  components: {
    Login,
  },
})
</script>
