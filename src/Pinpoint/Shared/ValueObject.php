<?php
namespace Pinpoint\Shared;

interface ValueObject
{
    public function sameValueAs($other = null);
    public function copy();
}
