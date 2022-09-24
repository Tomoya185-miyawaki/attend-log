<?php

declare(strict_types=1);

namespace App\Enums;

enum StampStatus: int
{
    case Attend = 1;
    case Leaving = 2;
    case RestStart = 3;
    case RestDone = 4;

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
            self::RestStart => 'restStart',
            self::RestDone => 'restDone',
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
     * 休憩開始のステータスかどうか
     *
     * @return bool
     */
    public function isRestStart(): bool
    {
        return $this === self::RestStart;
    }

    /**
     * 休憩終了のステータスかどうか
     *
     * @return bool
     */
    public function isRestDone(): bool
    {
        return $this === self::RestDone;
    }
}
