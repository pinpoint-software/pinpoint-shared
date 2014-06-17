<?php
namespace Pinpoint\Shared;

class UniqidIdentityGenerator implements IdentityGenerator
{
    protected $prefix;
    protected $moreEntropy;

    public function __construct($prefix = '', $moreEntropy = false)
    {
        $this->prefix = $prefix;
        $this->moreEntropy = $moreEntropy;
    }

    public function generateId()
    {
        return uniqid($this->prefix, $this->moreEntropy);
    }
}
