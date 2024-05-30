<?php

namespace App\Services;

use App\Traits\Calendar;
use Illuminate\Support\Facades\Validator;

class CalendarService
{
    use Calendar;

    public function __construct()
    {
    }

    public function calendarComponents(string $recordDate = null)
    {
        if ($recordDate) {
            if(preg_match('/\A[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}\z/', $recordDate) == false) {
                abort(404);
            }
        }

        return $this->calendar($recordDate);
    }

    public function getcalendarContents(string $recordDate = null)
    {

    }
}
