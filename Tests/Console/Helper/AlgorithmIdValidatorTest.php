<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Helper;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Configuration\AlgorithmConfigurationContainerInterface;
use Picodexter\ParameterEncryptionBundle\Console\Helper\AlgorithmIdValidator;
use Picodexter\ParameterEncryptionBundle\Exception\Console\UnknownAlgorithmIdException;

class AlgorithmIdValidatorTest extends TestCase
{
    /**
     * @var AlgorithmConfigurationContainerInterface|MockObject
     */
    private $algorithmConfigContainer;

    /**
     * @var AlgorithmIdValidator
     */
    private $validator;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->algorithmConfigContainer = $this->createAlgorithmConfigurationContainerInterfaceMock();

        $this->validator = new AlgorithmIdValidator($this->algorithmConfigContainer);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->validator = null;
        $this->algorithmConfigContainer = null;
    }

    public function testAssertKnownAlgorithmIdExceptionUnknown()
    {
        $this->expectException(UnknownAlgorithmIdException::class);

        $algorithmId = 'cannot_find_me';

        $this->setUpAlgorithmConfigurationContainerHas($algorithmId, false);

        $this->validator->assertKnownAlgorithmId($algorithmId);
    }

    public function testAssertKnownAlgorithmIdSuccessKnown()
    {
        $algorithmId = 'can_find_me';

        $this->setUpAlgorithmConfigurationContainerHas($algorithmId, true);

        $this->validator->assertKnownAlgorithmId($algorithmId);
    }

    /**
     * Create mock for AlgorithmConfigurationContainerInterface.
     *
     * @return AlgorithmConfigurationContainerInterface|MockObject
     */
    private function createAlgorithmConfigurationContainerInterfaceMock()
    {
        return $this->getMockBuilder(AlgorithmConfigurationContainerInterface::class)->getMock();
    }

    /**
     * Set up algorithm configuration container: has.
     *
     * @param string $algorithmId
     * @param bool   $result
     */
    private function setUpAlgorithmConfigurationContainerHas($algorithmId, $result)
    {
        $this->algorithmConfigContainer->expects($this->once())
            ->method('has')
            ->with($this->identicalTo($algorithmId))
            ->will($this->returnValue($result));
    }
}
