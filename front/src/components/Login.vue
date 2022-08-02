<template>
  <div class="hello">
  </div>
</template>

<script lang="ts">
import { Vue } from 'vue-class-component';
import ApiService from '@/services/ApiService';

export default class Login extends Vue {
  mounted() {
    ApiService.getCsrfToken().then(() => {
      ApiService.login({
        email: 'admin@example.com',
        password: 'password'
      }).then(() => {
        alert('ログインに成功しました')
      }).catch(err => {
        console.error(err)
        alert('ログインに失敗しました')
      })
    })
  }
}
</script>
