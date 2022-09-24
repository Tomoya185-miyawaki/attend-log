<?php

declare(strict_types=1);

namespace App\Utils;

use App\Enums\StampStatus;
use function array_key_exists;

class StampResource
{
    /**
     * 出退勤状況をフロント表示用に変換する
     *
     * @param array $stamps 出退勤状況
     *
     * @return array $response フロント用に変換したレスポンス
     */
    public static function convertStampList(array $stamps)
    {
        $response = [];
        foreach ($stamps as $key => $stamp) {
            $response[$key] = [];
            foreach ($stamp as $st) {
                // 出勤時間
                if ($st->status->isAttend()) {
                    $response[$key][StampStatus::Attend->value] = $st->stamp_date;
                }
                // 退勤時間
                if ($st->status->isLeaving()) {
                    $response[$key][StampStatus::Leaving->value] = $st->stamp_date;
                }
                // 休憩開始時間
                if ($st->status->isRestStart()) {
                    $response[$key][StampStatus::RestStart->value] = $st->stamp_date;
                }
                // 休憩終了時間
                if ($st->status->isRestDone()) {
                    $response[$key][StampStatus::RestDone->value] = $st->stamp_date;
                }
            }
            // 未入力の場合は「-」を設定する
            // 出勤時間
            if (! array_key_exists(StampStatus::Attend->value, $response[$key])) {
                $response[$key][StampStatus::Attend->value] = '-';
            }
            // 退勤時間
            if (! array_key_exists(StampStatus::Leaving->value, $response[$key])) {
                $response[$key][StampStatus::Leaving->value] = '-';
            }
            // 休憩開始時間
            if (! array_key_exists(StampStatus::RestStart->value, $response[$key])) {
                $response[$key][StampStatus::RestStart->value] = '-';
            }
            // 休憩終了時間
            if (! array_key_exists(StampStatus::RestDone->value, $response[$key])) {
                $response[$key][StampStatus::RestDone->value] = '-';
            }
        }
        return $response;
    }
}
