<?php

declare(strict_types=1);

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Service\Tag;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\DefinitionFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\ReferenceFactoryInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Tag\KeyNotEmptyDecoratorDefinitionGenerator;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\ServiceNames;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class KeyNotEmptyDecoratorDefinitionGeneratorTest extends TestCase
{
    /**
     * @var DefinitionFactoryInterface|MockObject
     */
    private $definitionFactory;

    /**
     * @var KeyNotEmptyDecoratorDefinitionGenerator
     */
    private $generator;

    /**
     * @var ReferenceFactoryInterface|MockObject
     */
    private $referenceFactory;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->definitionFactory = $this->createDefinitionFactoryInterfaceMock();
        $this->referenceFactory = $this->createReferenceFactoryInterfaceMock();

        $this->generator = new KeyNotEmptyDecoratorDefinitionGenerator(
            $this->definitionFactory,
            $this->referenceFactory
        );
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->generator = null;
        $this->referenceFactory = null;
        $this->definitionFactory = null;
    }

    public function testCreateDecoratorDefinitionSuccess()
    {
        $decoratorClass = '\\A\\Decorator\\Class';
        $decoratorServiceId = 'decorator_service';
        $decoratedServiceId = 'default_service';
        $decorationPriority = 123;

        $prepDefinition = $this->createDefinitionMock();
        $prepRefInner = $this->createReferenceMock();
        $prepRefKeyValidator = $this->createReferenceMock();

        $this->referenceFactory->expects($this->exactly(2))
            ->method('createReference')
            ->withConsecutive(
                [$this->identicalTo($decoratorServiceId.'.inner')],
                [$this->identicalTo(ServiceNames::KEY_VALIDATOR_NOT_EMPTY)]
            )
            ->willReturnOnConsecutiveCalls(
                $prepRefInner,
                $prepRefKeyValidator
            );

        $this->definitionFactory->expects($this->once())
            ->method('createDefinition')
            ->with(
                $this->identicalTo($decoratorClass),
                $this->identicalTo([
                    $prepRefInner,
                    $prepRefKeyValidator,
                ])
            )
            ->will($this->returnValue($prepDefinition));

        $prepDefinition->expects($this->once())
            ->method('setDecoratedService')
            ->with(
                $this->identicalTo($decoratedServiceId),
                $this->identicalTo(null),
                $this->identicalTo($decorationPriority)
            );

        $prepDefinition->expects($this->once())
            ->method('setPublic')
            ->with($this->identicalTo(false));

        $definition = $this->generator->createDecoratorDefinition(
            $decoratorClass,
            $decoratorServiceId,
            $decoratedServiceId,
            $decorationPriority
        );

        $this->assertInstanceOf(Definition::class, $definition);
    }

    /**
     * Create mock for DefinitionFactoryInterface.
     *
     * @return DefinitionFactoryInterface|MockObject
     */
    private function createDefinitionFactoryInterfaceMock()
    {
        return $this->getMockBuilder(DefinitionFactoryInterface::class)->getMock();
    }

    /**
     * Create mock for Definition.
     *
     * @return Definition|MockObject
     */
    private function createDefinitionMock()
    {
        return $this->getMockBuilder(Definition::class)->getMock();
    }

    /**
     * Create mock for ReferenceFactoryInterface.
     *
     * @return ReferenceFactoryInterface|MockObject
     */
    private function createReferenceFactoryInterfaceMock()
    {
        return $this->getMockBuilder(ReferenceFactoryInterface::class)->getMock();
    }

    /**
     * Create mock for Reference.
     *
     * @return Reference|MockObject
     */
    private function createReferenceMock()
    {
        return $this->getMockBuilder(Reference::class)->disableOriginalConstructor()->getMock();
    }
}
