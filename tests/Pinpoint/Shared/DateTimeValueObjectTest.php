<?php
namespace Pinpoint\Shared;

use DateTime;
use DateTimeZone;

class DateTimeValueObjectTest extends \PHPUnit_Framework_TestCase
{
    public function testGetValue()
    {
        $cdt = new DateTimeZone('America/Chicago');
        $birthday = new DateTime('1981-08-27 17:00:00', $cdt);
        $dtvalue = new DateTimeValueObject($birthday);

        $this->assertEquals($birthday->getTimestamp(), $dtvalue->getValue()->getTimestamp());
        $this->assertEquals('1981-08-27 17:00:00', $dtvalue->getValue('Y-m-d H:i:s'));
        $this->assertEquals('1981-08-27 22:00:00', $dtvalue->getValue('Y-m-d H:i:s', 'GMT'));
        $this->assertEquals('1981-08-27 22:00:00', $dtvalue->getValue('Y-m-d H:i:s', new DateTimeZone('GMT')));
    }

    public function testCopy()
    {
        $cdt = new DateTimeZone('America/Chicago');
        $birthday = new DateTime('1981-08-27 17:00:00', $cdt);
        $dtvalue = new DateTimeValueObject($birthday);
        $copied = $dtvalue->copy();
        $this->assertTrue($dtvalue->sameValueAs($copied));
    }
}
