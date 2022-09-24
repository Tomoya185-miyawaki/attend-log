<?php

declare(strict_types=1);

namespace App\Utils;

use App\Enums\StampStatus;
use function array_key_exists;
use Carbon\Carbon;

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
                    $attendLeavingLog[$key][StampStatus::Attend->name] = $st->stamp_date;
                }
                // 退勤時間
                if ($st->status->isLeaving()) {
                    $attendLeavingLog[$key][StampStatus::Leaving->name] = $st->stamp_date;
                }
                // 休憩開始時間
                if ($st->status->isRestStart()) {
                    $attendLeavingLog[$key][StampStatus::RestStart->name] = $st->stamp_date;
                }
                // 休憩終了時間
                if ($st->status->isRestDone()) {
                    $attendLeavingLog[$key][StampStatus::RestDone->name] = $st->stamp_date;
                }
            }
            // 未入力の場合は「-」を設定する
            // 出勤時間
            if (! array_key_exists(StampStatus::Attend->name, $attendLeavingLog[$key])) {
                $attendLeavingLog[$key][StampStatus::Attend->name] = '-';
            }
            // 退勤時間
            if (! array_key_exists(StampStatus::Leaving->name, $attendLeavingLog[$key])) {
                $attendLeavingLog[$key][StampStatus::Leaving->name] = '-';
            }
            // 休憩開始時間
            if (! array_key_exists(StampStatus::RestStart->name, $attendLeavingLog[$key])) {
                $attendLeavingLog[$key][StampStatus::RestStart->name] = '-';
            }
            // 休憩終了時間
            if (! array_key_exists(StampStatus::RestDone->name, $attendLeavingLog[$key])) {
                $attendLeavingLog[$key][StampStatus::RestDone->name] = '-';
            }
        }
        return self::calcAttendLeavingDate($attendLeavingLog);
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
        foreach ($attendLeavingLogs as $key => $attendLeavingLog) {
            // 出勤時刻
            if ($attendLeavingLog[StampStatus::Attend->name] !== '-') {
                $attendDate = new Carbon($attendLeavingLog[StampStatus::Attend->name]);
                $response[$key]['attend_date'] = ltrim($attendDate->format('H時i分'), '0');
            } else {
                $response[$key]['attend_date'] = $attendLeavingLog[StampStatus::Attend->name];
            }
            // 退勤時刻
            if ($attendLeavingLog[StampStatus::Leaving->name] !== '-') {
                $leavingDate = new Carbon($attendLeavingLog[StampStatus::Leaving->name]);
                $response[$key]['leaving_date'] = ltrim($leavingDate->format('H時i分'), '0');
            } else {
                $response[$key]['leaving_date'] = $attendLeavingLog[StampStatus::Leaving->name];
            }
            // 休憩時間
            if ($attendLeavingLog[StampStatus::RestStart->name] !== '-' && $attendLeavingLog[StampStatus::RestDone->name] !== '-') {
                $restStartDate = new Carbon($attendLeavingLog[StampStatus::RestStart->name]);
                $restDoneDate = new Carbon($attendLeavingLog[StampStatus::RestDone->name]);
                $diffRestDate = $restDoneDate->diff($restStartDate);
                // 分の差分
                $diffRestMinutes = $diffRestDate->days * 24 * 60 + $diffRestDate->h * 60 + $diffRestDate->i;
                $hours = floor($diffRestMinutes / 60);
                $minutes = $diffRestMinutes % 60;
                $response[$key]['rest_date'] = $hours > 0 ? ltrim(sprintf('%02d時間%02d分', $hours, $minutes), '0') : ltrim(sprintf('%02d分', $minutes), '0');
            } else {
                $response[$key]['rest_date'] = '-';
            }
            // 労働時間
            if ($attendLeavingLog[StampStatus::Attend->name] !== '-' && $attendLeavingLog[StampStatus::Leaving->name] !== '-') {
                $attendDate = new Carbon($attendLeavingLog[StampStatus::Attend->name]);
                $leavingDate = new Carbon($attendLeavingLog[StampStatus::Leaving->name]);
                // 退勤時刻から休憩時間を引く（休憩時間がない場合は0で計算する）
                $diff = isset($diffRestMinutes) ? $leavingDate->subMinute($diffRestMinutes) : $leavingDate->subMinute(0);
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
