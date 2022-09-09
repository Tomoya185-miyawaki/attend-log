<template>
  <HeaderComponent />
  <v-main>
    <v-container>
      <v-row class="text-center">
        <v-col cols="12">
          404ページ
        </v-col>
      </v-row>
    </v-container>
  </v-main>
  <FooterComponent />
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import HeaderComponent from '@/components/layouts/HeaderComponent.vue';
import FooterComponent from '@/components/layouts/FooterComponent.vue';

export default defineComponent({
  name: 'NotFoundPage',
  components: {
    HeaderComponent,
    FooterComponent,
  },
})
</script>