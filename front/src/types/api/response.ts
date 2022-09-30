import { Employee } from "@/types/model"
import { StampDetail, StampList } from "@/types/stamp"

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
  employeeIds: number[]
}

export type GetStampDetailRes = {
  employeeName: string
  stamps: StampDetail[]
}