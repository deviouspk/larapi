<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 15.09.18
 * Time: 13:37.
 */

namespace Modules\Schedule\Attributes;

interface ScheduleExceptions
{
    const ACTIVE = 'active';
    const MINUTE = 'monday';
    const HOUR = 'tuesday';
    const WEDNESDAY = 'wednesday';
    const THURSDAY = 'thursday';
    const FRIDAY = 'friday';
    const SATURDAY = 'saturday';
    const SUNDAY = 'sunday';
}
