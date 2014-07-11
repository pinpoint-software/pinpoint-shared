<?php
namespace Pinpoint\Shared;

use DateTime;
use DateTimeZone;

trait GetDateTime
{
    protected function getDateTime(DateTime $originalDateTime, $format = null, $tz = null)
    {
        $clonedDateTime = clone $originalDateTime;
        if (!is_null($tz) && $tz instanceof DateTimeZone) {
            $clonedDateTime->setTimezone($tz);
        } elseif (!is_null($tz) && is_string($tz)) {
            $clonedDateTime->setTimezone(new \DateTimeZone($tz));
        }
        if (is_null($format)) {
            return $clonedDateTime;
        } else {
            return $clonedDateTime->format($format);
        }
    }
}
