<template>
  <v-app-bar app>
    <v-toolbar-title>出退勤管理システム</v-toolbar-title>
    <v-btn v-if="isAuth" @click="logout">
      ログアウト
    </v-btn>
  </v-app-bar>
  <LoadingComponent :isLoading="isLoading" />
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import LoadingComponent from '@/components/parts/LoadingComponent.vue'
import { isAdminLoggedIn } from '@/util/auth';
import ApiService from '@/services/ApiService';
import router from '@/routes/router';

export default defineComponent({
  name: 'HeaderComponent',
  components: {
    LoadingComponent
  },
  setup() {
    const isAuth = ref<boolean>(isAdminLoggedIn())
    let isLoading = ref<boolean>(false)
    const logout = () => {
      isLoading.value = true
      ApiService
        .logout()
        .then(() => {
          localStorage.setItem('adminAuth', 'false')
          isLoading.value = false
          router.push('/admin/login')
        })
        .catch(() => {
          isLoading.value = false
          alert('ログアウトに失敗しました')
        })
    }
    return {
      isAuth,
      isLoading,
      logout
    }
  }
})
</script>