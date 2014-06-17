<?php
namespace Pinpoint\Shared;

class UniqidIdentityGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testDefault()
    {
        $identityGenerator = new UniqidIdentityGenerator();

        $this->assertEquals(
            13,
            strlen($identityGenerator->generateId()),
            'Default generateId is not 13 characters long'
        );
    }

    public function testPrefixed()
    {
        $identityGenerator = new UniqidIdentityGenerator('aaa');

        $this->assertEquals(
            16,
            strlen($identityGenerator->generateId()),
            'Prefixed generateId is not 16 characters long'
        );

        $this->assertStringMatchesFormat(
            'aaa%s',
            $identityGenerator->generateId(),
            'Prefixed generateId is does not start with aaa'
        );
    }

    public function testMoreEntropy()
    {
        $identityGenerator = new UniqidIdentityGenerator('', true);

        $this->assertEquals(
            23,
            strlen($identityGenerator->generateId()),
            'MoreEntropy generateId is not 23 characters long'
        );
    }

    public function testPrefixedMoreEntropy()
    {
        $identityGenerator = new UniqidIdentityGenerator('aaa', true);

        $this->assertEquals(
            26,
            strlen($identityGenerator->generateId()),
            'Prefixed MoreEntropy generateId is not 26 characters long'
        );

        $this->assertStringMatchesFormat(
            'aaa%s',
            $identityGenerator->generateId(),
            'Prefixed MoreEntropy generateId is does not start with aaa'
        );
    }
}
