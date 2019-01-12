<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Replacement\Pattern\Registry;

use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Replacement\Pattern\Registry\ReplacementPatternTypeRegistry;

class ReplacementPatternTypeRegistryTest extends TestCase
{
    public function testGetSetPatternTypesSuccess()
    {
        $preparedPatternTypes = [
            'foo' => 'Example\\Class',
            'bar' => 'Example\\SecondClass',
        ];

        $patternTypeRegistry = new ReplacementPatternTypeRegistry([]);

        $patternTypes = $patternTypeRegistry->getPatternTypes();

        $this->assertSame([], $patternTypes);

        $patternTypeRegistry->setPatternTypes($preparedPatternTypes);

        $patternTypes = $patternTypeRegistry->getPatternTypes();

        $this->assertSame($preparedPatternTypes, $patternTypes);
    }

    public function testGetSuccessFound()
    {
        $findKey = 'foo';
        $findValue = 'Example\\Class';

        $patternTypeRegistry = new ReplacementPatternTypeRegistry([
            $findKey => $findValue,
            'bar'    => 'Example\\Class',
        ]);

        $result = $patternTypeRegistry->get($findKey);

        $this->assertSame($findValue, $result);
    }

    public function testGetSuccessNotFound()
    {
        $patternTypeRegistry = new ReplacementPatternTypeRegistry([
            'foo' => 'Example\\Class',
        ]);

        $result = $patternTypeRegistry->get('bar');

        $this->assertNull($result);
    }

    public function testHasSuccessFound()
    {
        $patternTypeRegistry = new ReplacementPatternTypeRegistry([
            'foobar' => 'Example\\Class',
        ]);

        $result = $patternTypeRegistry->has('foobar');

        $this->assertTrue($result);
    }

    public function testHasSuccessNotFound()
    {
        $patternTypeRegistry = new ReplacementPatternTypeRegistry([
            'foobar' => 'Example\\Class',
        ]);

        $result = $patternTypeRegistry->has('no_find');

        $this->assertFalse($result);
    }
}
