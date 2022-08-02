import http from '@/util/http'
import { LoginFormData } from '@/types/auth'

class ApiService {
  getCsrfToken(): Promise<void> {
    return http.get('/sanctum/csrf-cookie')
  }

  login(formData: LoginFormData): Promise<any> {
    return http.post('/login', formData)
  }
}

export default new ApiService()