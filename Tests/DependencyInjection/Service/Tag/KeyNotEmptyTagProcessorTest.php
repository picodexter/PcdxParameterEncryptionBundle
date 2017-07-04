<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\DependencyInjection\Service\Tag;

use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Tag\KeyNotEmptyDecoratorClassResolverInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Tag\KeyNotEmptyDecoratorDefinitionGeneratorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Tag\KeyNotEmptyTagProcessor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class KeyNotEmptyTagProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var KeyNotEmptyDecoratorClassResolverInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $decoratorClassResolver;

    /**
     * @var KeyNotEmptyDecoratorDefinitionGeneratorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $decoratorDefinitionGenerator;

    /**
     * @var KeyNotEmptyTagProcessor
     */
    private $processor;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->decoratorClassResolver = $this->createKeyNotEmptyDecoratorClassResolverInterfaceMock();
        $this->decoratorDefinitionGenerator = $this->createKeyNotEmptyDecoratorDefinitionGeneratorInterfaceMock();

        $this->processor = new KeyNotEmptyTagProcessor(
            $this->decoratorClassResolver,
            $this->decoratorDefinitionGenerator
        );
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->processor = null;
        $this->decoratorDefinitionGenerator = null;
        $this->decoratorClassResolver = null;
    }

    public function testProcessSuccessEmpty()
    {
        $container = $this->createContainerBuilderMock();

        $container->expects($this->once())
            ->method('findTaggedServiceIds')
            ->with($this->identicalTo(KeyNotEmptyTagProcessor::TAG_NAME))
            ->will($this->returnValue([]));

        $container->expects($this->never())
            ->method('setDefinition');

        $this->processor->process($container);
    }

    /**
     * @param array  $serviceTags
     * @param int    $expectedDecPriority
     *
     * @dataProvider provideProcessData
     */
    public function testProcessSuccessNotEmpty(array $serviceTags, $expectedDecPriority)
    {
        $serviceId = 'some_service';
        $taggedServices = [
            $serviceId => $serviceTags,
        ];
        $serviceClass = '\\Some\\Encrypter\\Or\\Decrypter\\Class';
        $prepDecoratorClass = '\\Correct\\Encrypter\\Or\\Decrypter\\Decorator\\Class';
        $prepDecoratorSvcId = $serviceId.KeyNotEmptyTagProcessor::DECORATOR_SERVICE_ID_SUFFIX;

        $container = $this->createContainerBuilderMock();
        $serviceDefinition = $this->createDefinitionMock();
        $decoratorDefinition = $this->createDefinitionMock();

        $container->expects($this->once())
            ->method('findTaggedServiceIds')
            ->with($this->identicalTo(KeyNotEmptyTagProcessor::TAG_NAME))
            ->will($this->returnValue($taggedServices));

        $container->expects($this->once())
            ->method('getDefinition')
            ->with($this->identicalTo($serviceId))
            ->will($this->returnValue($serviceDefinition));

        $serviceDefinition->expects($this->once())
            ->method('getClass')
            ->with()
            ->will($this->returnValue($serviceClass));

        $this->decoratorClassResolver->expects($this->once())
            ->method('getDecoratorClassForDecoratedClass')
            ->with($this->identicalTo($serviceClass))
            ->will($this->returnValue($prepDecoratorClass));

        $this->decoratorDefinitionGenerator->expects($this->once())
            ->method('createDecoratorDefinition')
            ->with(
                $this->identicalTo($prepDecoratorClass),
                $this->identicalTo($prepDecoratorSvcId),
                $this->identicalTo($serviceId),
                $this->identicalTo($expectedDecPriority)
            )
            ->will($this->returnValue($decoratorDefinition));

        $container->expects($this->once())
            ->method('setDefinition')
            ->with(
                $this->identicalTo($prepDecoratorSvcId),
                $this->identicalTo($decoratorDefinition)
            );

        $this->processor->process($container);
    }

    /**
     * Data provider.
     */
    public function provideProcessData()
    {
        return [
            'service with priority' => [
                [
                    [
                        'name' => KeyNotEmptyTagProcessor::TAG_NAME,
                        'priority' => 1234,
                    ],
                ],
                1234,
            ],
            'service without priority' => [
                [
                    [
                        'name' => KeyNotEmptyTagProcessor::TAG_NAME,
                    ],
                ],
                KeyNotEmptyTagProcessor::DEFAULT_DECORATION_PRIORITY,
            ],
        ];
    }

    /**
     * Create mock for ContainerBuilder.
     *
     * @return ContainerBuilder|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['findTaggedServiceIds', 'getDefinition', 'setDefinition'])
            ->getMock();
    }

    /**
     * Create mock for Definition.
     *
     * @return Definition|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createDefinitionMock()
    {
        return $this->getMockBuilder(Definition::class)->getMock();
    }

    /**
     * Create mock for KeyNotEmptyDecoratorClassResolverInterface.
     *
     * @return KeyNotEmptyDecoratorClassResolverInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createKeyNotEmptyDecoratorClassResolverInterfaceMock()
    {
        return $this->getMockBuilder(KeyNotEmptyDecoratorClassResolverInterface::class)->getMock();
    }

    /**
     * Create mock for KeyNotEmptyDecoratorDefinitionGeneratorInterface.
     *
     * @return KeyNotEmptyDecoratorDefinitionGeneratorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createKeyNotEmptyDecoratorDefinitionGeneratorInterfaceMock()
    {
        return $this->getMockBuilder(KeyNotEmptyDecoratorDefinitionGeneratorInterface::class)->getMock();
    }
}
