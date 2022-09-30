import { StampStatus } from '@/enums/stamp'

export type StampList = {
  attend_date: string
  leaving_date: string
  rest_date: string
  working_date: string
}

export type StampDetail = {
  status: StampStatus
  stamp_start_date: string
  stamp_end_date?: string
}