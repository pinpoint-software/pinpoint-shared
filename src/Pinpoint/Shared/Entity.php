<?php
namespace Pinpoint\Shared;

interface Entity
{
    public function getId();
    public function sameIdAs($other = null);
}
