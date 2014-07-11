<?php
namespace Pinpoint\Shared;

use DateTime;

class DateTimeValueObject implements ValueObject
{
    use GetDateTime;

    protected $value;

    public function __construct(DateTime $value)
    {
        $this->value = $value;
    }

    public function getValue($format = null, $tz = null)
    {
        return $this->getDateTime($this->value, $format, $tz);
    }

    public function sameValueAs($other = null)
    {
        return $this->value->getTimestamp() === $other->getValue()->getTimestamp();
    }

    public function copy()
    {
        return new DateTimeValueObject(clone $this->value);
    }
}
