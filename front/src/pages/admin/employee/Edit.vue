<template>
  <HeaderComponent />
  <v-main>
    <v-container>
      <v-alert
        dense
        outlined
        type="error"
        class="mb-4"
        v-if="errorMessage"
      >
        {{ errorMessage }}
      </v-alert>
      <form @submit.prevent="handleSubmit">
        <v-text-field
          v-model="name"
          :error-messages="nameError"
          label="従業員名（例：山田 太郎）"
          filled
          required
        ></v-text-field>
        <v-text-field
          v-model="hourlyWage"
          :error-messages="hourlyWageError"
          type="number"
          label="時給（例：1000）"
          filled
          required
        ></v-text-field>
        <v-col class="text-right pa-0">
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
import { useField, useForm } from 'vee-validate'
import * as yup from 'yup'
import HeaderComponent from '@/components/layouts/HeaderComponent.vue'
import FooterComponent from '@/components/layouts/FooterComponent.vue'
import LoadingComponent from '@/components/parts/LoadingComponent.vue'
import ApiService from '@/services/ApiService'
import router from '@/routes/router'
import { useRoute } from 'vue-router'

export default defineComponent({
  name: 'EmployeeEdit',
  components: {
    HeaderComponent,
    FooterComponent,
    LoadingComponent
  },
  setup() {
    let isLoading = ref<boolean>(true)
    const route = useRoute()
    const formSchema = yup.object({
      name: yup.string().required('従業員名は必須項目です'),
      hourlyWage: yup.string().required('時給は必須項目です')
    })
    useForm({ validationSchema: formSchema })
    const { value: name, errorMessage: nameError } = useField<string>('name');
    const { value: hourlyWage, errorMessage: hourlyWageError } = useField<number>('hourlyWage');

    ApiService.getEmployeesById(route.params.employeeId as string)
      .then(res => {
        name.value = res.employee.name
        hourlyWage.value = res.employee.hourly_wage
        isLoading.value = false
      })
      .catch(() => {
        router.push({ name: 'adminError' })
      })

    let errorMessage = ref<string>('')
    const handleSubmit = () => {
      if (
        name.value &&
        !nameError.value?.length &&
        hourlyWage.value &&
        !hourlyWageError.value?.length
      ) {
        isLoading.value = true
        ApiService.createEmployee({
            name: name.value,
            hourlyWage: hourlyWage.value
          }).then(() => {
            isLoading.value = false
            router.push({ name: 'employeeList' })
          }).catch((err) => {
            isLoading.value = false
            errorMessage.value = err.response.data.message
          })
      }
    }
    return {
      name,
      nameError,
      hourlyWage,
      hourlyWageError,
      handleSubmit,
      errorMessage,
      isLoading,
    }
  }
})
</script>
