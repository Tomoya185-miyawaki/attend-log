<template>
  <HeaderComponent />
  <v-main>
    <v-container>
      <v-row class="text-center">
        <v-col cols="12">
          大変申し訳ございません。<br>
          ただ今回線が大変混雑しています。<br>
          しばらくたってからご利用くださいますようお願いいたします。
        </v-col>
      </v-row>
    </v-container>
  </v-main>
  <FooterComponent />
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import HeaderComponent from '@/components/layouts/HeaderComponent.vue'
import FooterComponent from '@/components/layouts/FooterComponent.vue'

export default defineComponent({
  name: 'AdminErrorPage',
  components: {
    HeaderComponent,
    FooterComponent,
  },
})
</script>