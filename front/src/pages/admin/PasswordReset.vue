<template>
  <HeaderComponent />
  <v-main>
    <v-container>
      <h1 class="text-center mb-2">パスワードリセット</h1>
      <v-alert
        dense
        outlined
        type="error"
        class="mb-4"
        v-if="isError"
      >
        パスワードリセットに失敗しました
      </v-alert>
      <form @submit.prevent="handleSubmit">
        <v-text-field
          v-model="email"
          :error-messages="emailError"
          label="メールアドレス"
          filled
          required
        ></v-text-field>
        <v-text-field
          v-model="password"
          :error-messages="passwordError"
          type="password"
          label="パスワード"
          filled
          required
        ></v-text-field>
        <v-col class="text-right pa-0">
          <v-col class="px-0 pt-0">
            <router-link to="/admin/login">ログイン画面へ</router-link>
          </v-col>
          <v-btn
            type="submit"
          >
            更新
          </v-btn>
        </v-col>
      </form>
    </v-container>
  </v-main>
  <FooterComponent />
  <LoadingComponent :isLoading="isLoading" />
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import { useField, useForm } from 'vee-validate';
import * as yup from 'yup'
import HeaderComponent from '@/components/layouts/HeaderComponent.vue';
import FooterComponent from '@/components/layouts/FooterComponent.vue';
import LoadingComponent from '@/components/parts/LoadingComponent.vue'
import ApiService from '@/services/ApiService';
import router from '@/routes/router';

export default defineComponent({
  name: 'LoginPage',
  components: {
    HeaderComponent,
    FooterComponent,
    LoadingComponent
  },
  setup() {
    let isError = ref<boolean>(false)
    let isLoading = ref<boolean>(false)
    const formSchema = yup.object({
      email: yup.string().email('メールアドレス形式で入力してください').required('メールアドレスは必須項目です'),
      password: yup.string().required('パスワードは必須項目です')
    })
    useForm({ validationSchema: formSchema })
    const { value: email, errorMessage: emailError } = useField<string>('email');
    const { value: password, errorMessage: passwordError } = useField<string>('password');
    const handleSubmit = () => {
      if (
        email.value &&
        !emailError.value?.length &&
        password.value &&
        !passwordError.value?.length
      ) {
        isLoading.value = true
        ApiService.getCsrfToken().then(() => {
          ApiService.passwordReset({
            email: email.value,
            password: password.value
          }).then(() => {
            isLoading.value = false
            router.push('/admin/login');
          }).catch(() => {
            isLoading.value = false
            isError.value = true
          })
        })
      }
    }
    return {
      email,
      emailError,
      password,
      passwordError,
      handleSubmit,
      isError,
      isLoading,
    }
  }
})
</script>
