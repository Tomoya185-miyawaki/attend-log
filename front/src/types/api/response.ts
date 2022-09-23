import { Employee } from "@/types/model"

export type GetEmployeesByPaginateRes = {
  currentPage: number
  employees: Employee[]
  lastPage: number
}