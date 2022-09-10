import http from '@/util/http'
import { LoginFormData, EmployeeFormData } from '@/types/auth'

class ApiService {
  getCsrfToken(): Promise<void> {
    return http.get('/sanctum/csrf-cookie')
  }

  login(formData: LoginFormData): Promise<any> {
    return http.post('/admin/login', formData)
  }

  logout(): Promise<any> {
    return http.post('/admin/logout')
  }

  passwordReset(formData: LoginFormData): Promise<any> {
    return http.post('/api/admin/password-reset', formData)
  }

  getEmployeesByPaginate(page: number): Promise<any> {
    return http.get('/api/employee?page=' + page)
  }

  createEmployee(formData: EmployeeFormData): Promise<any> {
    return http.post('/api/employee/create', formData)
  }
}

export default new ApiService()