import { StampStatus } from '@/enums/stamp'

export function getTitle(status: StampStatus) {
  if (status === StampStatus.Rest) {
    return '休憩'
  }
  return '勤務'
}

export function getColor(status: StampStatus) {
  if (status === StampStatus.Rest) {
    return '#a5f1c0'
  }
  return '#3789d8'
}