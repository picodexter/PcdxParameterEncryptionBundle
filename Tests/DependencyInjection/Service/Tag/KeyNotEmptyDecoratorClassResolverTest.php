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

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\CryptoClassDetectorInterface;
use Picodexter\ParameterEncryptionBundle\DependencyInjection\Service\Tag\KeyNotEmptyDecoratorClassResolver;
use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\Decorator\KeyNotEmptyDecrypterDecorator;
use Picodexter\ParameterEncryptionBundle\Encryption\Encrypter\Decorator\KeyNotEmptyEncrypterDecorator;

class KeyNotEmptyDecoratorClassResolverTest extends TestCase
{
    /**
     * @var CryptoClassDetectorInterface|MockObject
     */
    private $cryptoClassDetector;

    /**
     * @var KeyNotEmptyDecoratorClassResolver
     */
    private $resolver;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->cryptoClassDetector = $this->createCryptoClassDetectorInterfaceMock();

        $this->resolver = new KeyNotEmptyDecoratorClassResolver($this->cryptoClassDetector);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->resolver = null;
        $this->cryptoClassDetector = null;
    }

    public function testGetDecoratorClassForDecoratedClassSuccessDecrypter()
    {
        $serviceClass = 'some decrypter class';

        $this->setUpCryptoClassDetectorIsEncrypterClass($serviceClass, false);

        $decoratorClass = $this->resolver->getDecoratorClassForDecoratedClass($serviceClass);

        $this->assertSame(KeyNotEmptyDecrypterDecorator::class, $decoratorClass);
    }

    public function testGetDecoratorClassForDecoratedClassSuccessEncrypter()
    {
        $serviceClass = 'some encrypter class';

        $this->setUpCryptoClassDetectorIsEncrypterClass($serviceClass, true);

        $decoratorClass = $this->resolver->getDecoratorClassForDecoratedClass($serviceClass);

        $this->assertSame(KeyNotEmptyEncrypterDecorator::class, $decoratorClass);
    }

    /**
     * Create mock for CryptoClassDetectorInterface.
     *
     * @return CryptoClassDetectorInterface|MockObject
     */
    private function createCryptoClassDetectorInterfaceMock()
    {
        return $this->getMockBuilder(CryptoClassDetectorInterface::class)->getMock();
    }

    /**
     * Set up CryptoClassDetector: isEncrypterClass.
     *
     * @param string $serviceClass
     * @param bool   $result
     */
    private function setUpCryptoClassDetectorIsEncrypterClass($serviceClass, $result)
    {
        $this->cryptoClassDetector->expects($this->once())
            ->method('isEncrypterClass')
            ->with($this->identicalTo($serviceClass))
            ->will($this->returnValue($result));
    }
}
