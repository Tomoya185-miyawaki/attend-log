import http from '@/util/http'
import { LoginFormData } from '@/types/auth'

class ApiService {
  getCsrfToken(): Promise<void> {
    return http.get('/sanctum/csrf-cookie')
  }

  login(formData: LoginFormData): Promise<any> {
    return http.post('/admin/login', formData)
  }

  passwordReset(formData: LoginFormData): Promise<any> {
    return http.post('/api/admin/password-reset', formData)
  }

  authStatus(): Promise<any> {
    return http.get('/api/admin/auth/status')
  }
}

export default new ApiService()