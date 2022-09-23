import http from '@/util/http'
import { LoginFormData, EmployeeFormData } from '@/types/auth'
import { GetEmployeesByIdRes, GetEmployeesByPaginateRes } from '@/types/api/response'

class ApiService {
  getCsrfToken(): Promise<void> {
    return http.get('/sanctum/csrf-cookie')
  }

  login(formData: LoginFormData): Promise<void> {
    return http.post('/admin/login', formData)
  }

  logout(): Promise<void> {
    return http.post('/admin/logout')
  }

  passwordReset(formData: LoginFormData): Promise<void> {
    return http.post('/api/admin/password-reset', formData)
  }

  async getEmployeesById(employeeId: string): Promise<GetEmployeesByIdRes> {
    const response = await http.get('/api/employee/' + employeeId)
    return response.data
  }

  async getEmployeesByPaginate(page: number): Promise<GetEmployeesByPaginateRes> {
    const response = await http.get('/api/employee?page=' + page)
    return response.data
  }

  createEmployee(formData: EmployeeFormData): Promise<void> {
    return http.post('/api/employee/create', formData)
  }

  updateEmployee(formData: EmployeeFormData, id: string): Promise<void> {
    return http.patch(`/api/employee/${id}`, formData)
  }
}

export default new ApiService()