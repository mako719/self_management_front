<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

trait Calendar
{
    public function calendar(string $recordDate = null) {
        $selectedDate = Carbon::parse($recordDate);

        $year = $selectedDate->format('Y');
        $month = $selectedDate->format('m');
        $yearMonth = Carbon::Create($year, $month, 01, 00, 00, 00);

        // カレンダーの日付を$calendarDaysの配列に集める
        $calendarDays = [];

        // 月初の日付が日曜日ではないときの、追加する前月カレンダーの日付
        if ($yearMonth->dayOfWeek != 0) {
            $calendarStartDay = $yearMonth->copy()->subDays($yearMonth->dayOfWeek);
            for ($i = 0; $i < $yearMonth->dayOfWeek; $i++) {
                $calendarDays[] = ['date'=>$calendarStartDay->copy()->addDays($i), 'show' => false, 'status' => false];
            }
        }

        // 当月の日付
        for ($i = 0; $i < $yearMonth->daysInMonth; $i++) {
            if ($yearMonth->copy()->addDays($i) >= Carbon::now()) {
                $show = true;
                $status = true;
            } else {
                $show = true;
                $status = false;
            }
            $calendarDays[] = ['date' => $yearMonth->copy()->addDays($i), 'show' => $show, 'status' => $status];
        }

        // 月末の日付が土曜日ではないときの、追加する翌月カレンダーの日付
        if ($yearMonth->copy()->endOfMonth()->dayOfWeek != 6) {
            for ($i = $yearMonth->copy()->endOfMonth()->dayOfWeek+1; $i < 7; $i++) {
                $calendarDays[] = ['date' => $yearMonth->copy()->addDays($i), 'show' => false, 'status'=>false];
            }
        }

        return [$calendarDays, $yearMonth->copy()->subMonth(), $yearMonth->copy()->addMonth(), $yearMonth];
    }
}
