import { Employee } from "@/types/model"
import { StampList } from "@/types/stampList"

export type GetEmployeesByIdRes = {
  employee: Employee
}

export type GetEmployeesByPaginateRes = {
  currentPage: number
  employees: Employee[]
  lastPage: number
}

export type GetStampsByPaginateRes = {
  currentPage: number
  stamps: StampList[]
  lastPage: number
}