<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Carbon\Carbon;

class BaseModel extends Model
{
        /**
         * هذا الدالة تتحكم في كيفية تحويل التواريخ عند التحويل إلى JSON
         */
    protected function serializeDate(DateTimeInterface $date)
    {
        // نحول الوقت للـ timezone اللي محدد في config/app.php
        return Carbon::instance($date)
            ->setTimezone(config('app.timezone'))
            ->format('Y-m-d H:i:s');
    }
}
