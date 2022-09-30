<?php

declare(strict_types=1);

namespace App\Enums;

enum StampStatus: int
{
    case Attend = 1;
    case Leaving = 2;
    case Rest = 3;

    /**
     * ステータスを取得する
     *
     * @return string
     */
    public function getStatus(): string
    {
        return match ($this) {
            self::Attend => 'attend',
            self::Leaving => 'leaving',
            self::Rest => 'rest',
        };
    }

    /**
     * 出勤のステータスかどうか
     *
     * @return bool
     */
    public function isAttend(): bool
    {
        return $this === self::Attend;
    }

    /**
     * 退勤のステータスかどうか
     *
     * @return bool
     */
    public function isLeaving(): bool
    {
        return $this === self::Leaving;
    }

    /**
     * 休憩のステータスかどうか
     *
     * @return bool
     */
    public function isRest(): bool
    {
        return $this === self::Rest;
    }
}
