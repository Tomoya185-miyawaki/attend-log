<?php

declare(strict_types=1);

namespace App\Utils;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class StampResource
{
    /**
     * 出退勤状況をフロント表示用に変換する
     *
     * @param array $stamps 出退勤状況
     *
     * @return array 出退勤記録
     */
    public static function convertStampList(array $stamps)
    {
        $attendLeavingLog = [];
        foreach ($stamps as $key => $stamp) {
            $attendLeavingLog[$key] = [];
            foreach ($stamp as $st) {
                // 出勤時間
                if ($st->status->isAttend()) {
                    $attendLeavingLog[$key]['attend_start_date'] = $st->stamp_start_date;
                    if ($st->stamp_end_date !== null) {
                        $attendLeavingLog[$key]['attend_end_date'] = $st->stamp_end_date;
                    }
                }
                // 退勤時間
                if ($st->status->isLeaving()) {
                    $attendLeavingLog[$key]['leaving_start_date'] = $st->stamp_start_date;
                    if ($st->stamp_end_date !== null) {
                        $attendLeavingLog[$key]['leaving_end_date'] = $st->stamp_end_date;
                    }
                }
                // 休憩時間
                if ($st->status->isRest()) {
                    $attendLeavingLog[$key]['rest_start_date'] = $st->stamp_start_date;
                    if ($st->stamp_end_date !== null) {
                        $attendLeavingLog[$key]['rest_end_date'] = $st->stamp_end_date;
                    }
                }
            }
        }
        return self::calcAttendLeavingDate($attendLeavingLog);
    }

    /**
     * 出退勤詳細用に加工
     *
     * @param Collection $stampDetails 出退勤情報
     *
     * @return array
     */
    public static function convertStampDetails(Collection $stampDetails): array
    {
        $response = [];
        foreach ($stampDetails as $key => $stampDetail) {
            $response[$key]['status'] = $stampDetail->status->value;
            $response[$key]['stamp_start_date'] = $stampDetail->stamp_start_date;
            $response[$key]['stamp_end_date'] = $stampDetail->stamp_end_date;
        }
        return $response;
    }

    /**
     * 出退勤記録から労働時間・休憩時間を計算する
     *
     * @param array $attendLeavingLogs 出退勤記録
     *
     * @return array $response 労働時間・休憩時間を計算した配列
     */
    private static function calcAttendLeavingDate(array $attendLeavingLogs): array
    {
        $response = [];
        // dd($attendLeavingLogs);
        foreach ($attendLeavingLogs as $key => $attendLeavingLog) {
            // 出勤時刻
            if (isset($attendLeavingLog['attend_start_date'])) {
                $attendDate = new Carbon($attendLeavingLog['attend_start_date']);
                $response[$key]['attend_date'] = ltrim($attendDate->format('H時i分'), '0');
            } else {
                $attendDate = null;
                $response[$key]['attend_date'] = '-';
            }
            // 退勤時刻
            if (isset($attendLeavingLog['leaving_end_date'])) {
                $leavingDate = new Carbon($attendLeavingLog['leaving_end_date']);
                $response[$key]['leaving_date'] = ltrim($leavingDate->format('H時i分'), '0');
            } elseif (isset($attendLeavingLog['attend_end_date']) && ! isset($attendLeavingLog['rest_start_date'])) {
                $leavingDate = new Carbon($attendLeavingLog['attend_end_date']);
                $response[$key]['leaving_date'] = ltrim($leavingDate->format('H時i分'), '0');
            } else {
                $leavingDate = null;
                $response[$key]['leaving_date'] = '-';
            }
            // 休憩時間
            if (isset($attendLeavingLog['rest_start_date']) && isset($attendLeavingLog['rest_end_date'])) {
                $restStartDate = new Carbon($attendLeavingLog['rest_start_date']);
                $restDoneDate = new Carbon($attendLeavingLog['rest_end_date']);
                $diffRestDate = $restDoneDate->diff($restStartDate);
                // 分の差分
                $diffRestMinutes = $diffRestDate->days * 24 * 60 + $diffRestDate->h * 60 + $diffRestDate->i;
                $hours = floor($diffRestMinutes / 60);
                $minutes = $diffRestMinutes % 60;
                $response[$key]['rest_date'] = $hours > 0 ? ltrim(sprintf('%02d時間%02d分', $hours, $minutes), '0') : ltrim(sprintf('%02d分', $minutes), '0');
            } else {
                $diffRestMinutes = null;
                $response[$key]['rest_date'] = '-';
            }
            // 労働時間
            if ($attendDate !== null && $leavingDate !== null) {
                // 退勤時刻から休憩時間を引く（休憩時間がない場合は0で計算する）
                $diff = $diffRestMinutes !== null ? $leavingDate->subMinute($diffRestMinutes) : $leavingDate->subMinute(0);
                // 引いたものから出勤時間との差分を出す
                $diffWorkingDate = $diff->diff($attendDate);
                $diffWorkingMinutes = $diffWorkingDate->days * 24 * 60 + $diffWorkingDate->h * 60 + $diffWorkingDate->i;
                $hours = floor($diffWorkingMinutes / 60);
                $minutes = $diffWorkingMinutes % 60;
                $response[$key]['working_date'] = $hours > 0 ? ltrim(sprintf('%02d時間%02d分', $hours, $minutes), '0') : ltrim(sprintf('%02d分', $minutes), '0');
            } else {
                $response[$key]['working_date'] = '-';
            }
        }
        return $response;
    }
}
