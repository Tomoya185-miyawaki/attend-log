<template>
  <v-footer
    app
    padless
  >
    <v-container>
      <v-row class="text-center">
        <v-col cols="12">
          © {{ new Date().getFullYear() }} Tomoya Miyawaki
        </v-col>
      </v-row>
    </v-container>
  </v-footer>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'FooterComponent',
})
</script>