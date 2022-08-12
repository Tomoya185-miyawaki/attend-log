<template>
  <HeaderComponent />
  <v-main>
    <v-container>
      <v-alert
        dense
        outlined
        type="error"
        class="mb-4"
        v-if="isError"
      >
        認証に失敗しました
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
          :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
          :type="showPassword ? 'text' : 'password'"
          label="パスワード"
          filled
          required
          @click:append="showPassword = !showPassword"
        ></v-text-field>
        <v-col class="text-right pa-0">
          <v-btn
            type="submit"
          >
            送信
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

export default defineComponent({
  name: 'LoginPage',
  components: {
    HeaderComponent,
    FooterComponent,
    LoadingComponent
  },
  setup() {
    let isError = ref<boolean>(false)
    let showPassword = ref<boolean>(false)
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
          ApiService.login({
            email: email.value,
            password: password.value
          }).then(() => {
            isLoading.value = false
            // TODO: ログイン後のページにリダイレクトさせる
            console.log('ログインに成功しました')
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
      showPassword,
    }
  }
})
</script>
