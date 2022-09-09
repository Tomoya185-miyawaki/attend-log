<template>
  <v-app-bar app>
    <v-app-bar-nav-icon v-if="isAuth" @click="drawer = !drawer" />
    <v-toolbar-title class="pl-0">出退勤管理システム</v-toolbar-title>
    <v-btn v-if="isAuth" @click="logout">
      ログアウト
    </v-btn>
  </v-app-bar>
  <v-navigation-drawer
    v-if="isAuth"
    v-model="drawer"
    app
    floating
    class="px-6 py-4"
  >
    <v-list>
      <v-list-item
        v-for="item in items"
        active-color="primary"
        :to="item.path"
        :key="item.key"
        class="py-3"
      >
        <v-col class="d-flex pa-0">
          <v-icon :icon="item.icon" class="mr-6" />
          <v-list-item-title class="font-weight-bold" v-text="item.title" />
        </v-col>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
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
    const drawer = ref<boolean>(false)
    const items = [
      {
          key: 1,
          title: '従業員一覧',
          path: '/admin/employee',
          icon: 'mdi-account-multiple'
      },
    ]
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
      drawer,
      items,
      logout
    }
  }
})
</script>