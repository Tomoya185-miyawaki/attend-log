import { Employee } from "@/types/model"

export type GetEmployeesByIdRes = {
  employee: Employee
}

export type GetEmployeesByPaginateRes = {
  currentPage: number
  employees: Employee[]
  lastPage: number
}