<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Processor;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Picodexter\ParameterEncryptionBundle\Configuration\AlgorithmConfiguration;
use Picodexter\ParameterEncryptionBundle\Configuration\AlgorithmConfigurationContainerInterface;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Console\Helper\AlgorithmIdValidatorInterface;
use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAskerInterface;
use Picodexter\ParameterEncryptionBundle\Console\Processor\ActiveKeyConfigurationProviderInterface;
use Picodexter\ParameterEncryptionBundle\Console\Processor\EncryptProcessor;
use Picodexter\ParameterEncryptionBundle\Console\Processor\TransformedKey;
use Picodexter\ParameterEncryptionBundle\Console\Processor\TransformedKeyProviderInterface;
use Picodexter\ParameterEncryptionBundle\Console\Renderer\CryptRendererInterface;
use Picodexter\ParameterEncryptionBundle\Console\Request\EncryptRequest;
use Picodexter\ParameterEncryptionBundle\Encryption\Encrypter\EncrypterInterface;
use Picodexter\ParameterEncryptionBundle\Exception\Console\UnknownAlgorithmIdException;
use Symfony\Component\Console\Output\OutputInterface;

class EncryptProcessorTest extends TestCase
{
    /**
     * @var ActiveKeyConfigurationProviderInterface|MockObject
     */
    private $activeKeyConfigProvider;

    /**
     * @var AlgorithmConfigurationContainerInterface|MockObject
     */
    private $algorithmConfigContainer;

    /**
     * @var AlgorithmIdValidatorInterface|MockObject
     */
    private $algorithmIdValidator;

    /**
     * @var EncryptProcessor
     */
    private $processor;

    /**
     * @var CryptRendererInterface|MockObject
     */
    private $renderer;

    /**
     * @var TransformedKeyProviderInterface|MockObject
     */
    private $transformedKeyProvider;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->activeKeyConfigProvider = $this->createActiveKeyConfigurationProviderInterfaceMock();
        $this->algorithmConfigContainer = $this->createAlgorithmConfigurationContainerInterfaceMock();
        $this->algorithmIdValidator = $this->createAlgorithmIdValidatorInterfaceMock();
        $this->renderer = $this->createCryptRendererInterfaceMock();
        $this->transformedKeyProvider = $this->createTransformedKeyProviderInterfaceMock();

        $this->processor = new EncryptProcessor(
            $this->activeKeyConfigProvider,
            $this->algorithmConfigContainer,
            $this->algorithmIdValidator,
            $this->renderer,
            $this->transformedKeyProvider
        );
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->processor = null;
        $this->transformedKeyProvider = null;
        $this->renderer = null;
        $this->algorithmIdValidator = null;
        $this->algorithmConfigContainer = null;
        $this->activeKeyConfigProvider = null;
    }

    public function testRenderEncryptOutputExceptionUnknownAlgorithmId()
    {
        $this->expectException(UnknownAlgorithmIdException::class);

        $algorithmId = 'doesnotexist';

        $request = new EncryptRequest(
            $algorithmId,
            'secret key',
            true,
            $this->createQuestionAskerInterfaceMock(),
            'to be encrypted'
        );
        $output = $this->createOutputInterfaceMock();

        $this->algorithmIdValidator->expects($this->once())
            ->method('assertKnownAlgorithmId')
            ->with($this->identicalTo($algorithmId))
            ->will($this->throwException(new UnknownAlgorithmIdException($algorithmId)));

        $this->processor->renderEncryptOutput($request, $output);
    }

    public function testRenderEncryptOutputSuccessPlaintextValueFromRequest()
    {
        $algorithmId = 'algo_01';
        $key = 'secret key';
        $keyProvided = true;
        $plaintextValue = 'to be encrypted';
        $encryptedValue = 'encrypted value';

        $request = new EncryptRequest(
            $algorithmId,
            $key,
            $keyProvided,
            $this->createQuestionAskerInterfaceMock(),
            $plaintextValue
        );
        $output = $this->createOutputInterfaceMock();
        $algorithmConfig = $this->createAlgorithmConfigurationMock();
        $keyConfig = $this->createKeyConfigurationMock();
        $activeKeyConfig = $this->createKeyConfigurationMock();
        $encrypter = $this->createEncrypterInterfaceMock();
        $transformedKey = $this->createTransformedKeyMock();

        $this->setUpAlgorithmConfigurationContainerGetAlgorithmConfiguration($algorithmId, $algorithmConfig);

        $this->setUpAlgorithmConfigurationGetEncryptionKeyConfig($algorithmConfig, $keyConfig);

        $this->setUpActiveKeyConfigurationProviderGetActiveKeyConfiguration(
            $keyProvided,
            $key,
            $keyConfig,
            $activeKeyConfig
        );

        $this->setUpTransformedKeyProviderGetTransformedKey($activeKeyConfig, $transformedKey);

        $this->setUpAlgorithmConfigurationGetEncrypter($algorithmConfig, $encrypter);

        $this->setUpTransformedKeyGetFinalKey($transformedKey, $key);

        $this->setUpEncrypterEncryptValue($encrypter, $plaintextValue, $key, $encryptedValue);

        $this->setUpCryptoRendererRenderOutput($encryptedValue, $transformedKey, $output);

        $this->processor->renderEncryptOutput($request, $output);
    }

    public function testRenderEncryptOutputSuccessPlaintextValueFromQuestionAsker()
    {
        $algorithmId = 'algo_01';
        $key = 'secret key';
        $keyProvided = true;
        $plaintextValue = 'encrypt me';
        $encryptedValue = 'encrypted value';

        $plaintextAsker = $this->createQuestionAskerInterfaceMock();
        $request = new EncryptRequest(
            $algorithmId,
            $key,
            $keyProvided,
            $plaintextAsker,
            null
        );
        $output = $this->createOutputInterfaceMock();
        $algorithmConfig = $this->createAlgorithmConfigurationMock();
        $keyConfig = $this->createKeyConfigurationMock();
        $activeKeyConfig = $this->createKeyConfigurationMock();
        $encrypter = $this->createEncrypterInterfaceMock();
        $transformedKey = $this->createTransformedKeyMock();

        $this->setUpAlgorithmConfigurationContainerGetAlgorithmConfiguration($algorithmId, $algorithmConfig);

        $plaintextAsker->expects($this->once())
            ->method('askQuestion')
            ->with()
            ->will($this->returnValue($plaintextValue));

        $this->setUpAlgorithmConfigurationGetEncryptionKeyConfig($algorithmConfig, $keyConfig);

        $this->setUpActiveKeyConfigurationProviderGetActiveKeyConfiguration(
            $keyProvided,
            $key,
            $keyConfig,
            $activeKeyConfig
        );

        $this->setUpTransformedKeyProviderGetTransformedKey($activeKeyConfig, $transformedKey);

        $this->setUpAlgorithmConfigurationGetEncrypter($algorithmConfig, $encrypter);

        $this->setUpTransformedKeyGetFinalKey($transformedKey, $key);

        $this->setUpEncrypterEncryptValue($encrypter, $plaintextValue, $key, $encryptedValue);

        $this->setUpCryptoRendererRenderOutput($encryptedValue, $transformedKey, $output);

        $this->processor->renderEncryptOutput($request, $output);
    }

    /**
     * Create mock for ActiveKeyConfigurationProviderInterface.
     *
     * @return ActiveKeyConfigurationProviderInterface|MockObject
     */
    private function createActiveKeyConfigurationProviderInterfaceMock()
    {
        return $this->getMockBuilder(ActiveKeyConfigurationProviderInterface::class)->getMock();
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
     * Create mock for AlgorithmConfiguration.
     *
     * @return AlgorithmConfiguration|MockObject
     */
    private function createAlgorithmConfigurationMock()
    {
        return $this->getMockBuilder(AlgorithmConfiguration::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * Create mock for AlgorithmIdValidatorInterface.
     *
     * @return AlgorithmIdValidatorInterface|MockObject
     */
    private function createAlgorithmIdValidatorInterfaceMock()
    {
        return $this->getMockBuilder(AlgorithmIdValidatorInterface::class)->getMock();
    }

    /**
     * Create mock for CryptRendererInterface.
     *
     * @return CryptRendererInterface|MockObject
     */
    private function createCryptRendererInterfaceMock()
    {
        return $this->getMockBuilder(CryptRendererInterface::class)->getMock();
    }

    /**
     * Create mock for EncrypterInterface.
     *
     * @return EncrypterInterface|MockObject
     */
    private function createEncrypterInterfaceMock()
    {
        return $this->getMockBuilder(EncrypterInterface::class)->getMock();
    }

    /**
     * Create mock for KeyConfiguration.
     *
     * @return KeyConfiguration|MockObject
     */
    private function createKeyConfigurationMock()
    {
        return $this->getMockBuilder(KeyConfiguration::class)->getMock();
    }

    /**
     * Create mock for OutputInterface.
     *
     * @return OutputInterface|MockObject
     */
    private function createOutputInterfaceMock()
    {
        return $this->getMockBuilder(OutputInterface::class)->getMock();
    }

    /**
     * Create mock for QuestionAskerInterface.
     *
     * @return QuestionAskerInterface|MockObject
     */
    private function createQuestionAskerInterfaceMock()
    {
        return $this->getMockBuilder(QuestionAskerInterface::class)->getMock();
    }

    /**
     * Create mock for TransformedKey.
     *
     * @return TransformedKey|MockObject
     */
    private function createTransformedKeyMock()
    {
        return $this->getMockBuilder(TransformedKey::class)->getMock();
    }

    /**
     * Create mock for TransformedKeyProviderInterface.
     *
     * @return TransformedKeyProviderInterface|MockObject
     */
    private function createTransformedKeyProviderInterfaceMock()
    {
        return $this->getMockBuilder(TransformedKeyProviderInterface::class)->getMock();
    }

    /**
     * Set up ActiveKeyConfigurationProvider: getActiveKeyConfiguration.
     *
     * @param bool             $keyProvided
     * @param string           $key
     * @param KeyConfiguration $keyConfig
     * @param KeyConfiguration $activeKeyConfig
     */
    private function setUpActiveKeyConfigurationProviderGetActiveKeyConfiguration(
        $keyProvided,
        $key,
        KeyConfiguration $keyConfig,
        KeyConfiguration $activeKeyConfig
    ) {
        $this->activeKeyConfigProvider->expects($this->once())
            ->method('getActiveKeyConfiguration')
            ->with(
                $this->identicalTo($keyProvided),
                $this->identicalTo($key),
                $this->identicalTo($keyConfig)
            )
            ->will($this->returnValue($activeKeyConfig));
    }

    /**
     * Set up algorithm configuration container: get algorithm configuration.
     *
     * @param string                 $algorithmId
     * @param AlgorithmConfiguration $algorithmConfig
     */
    private function setUpAlgorithmConfigurationContainerGetAlgorithmConfiguration(
        $algorithmId,
        AlgorithmConfiguration $algorithmConfig
    ) {
        $this->algorithmConfigContainer->expects($this->once())
            ->method('get')
            ->with($this->identicalTo($algorithmId))
            ->will($this->returnValue($algorithmConfig));
    }

    /**
     * Set up algorithm configuration: get encrypter.
     *
     * @param AlgorithmConfiguration|MockObject $algorithmConfig
     * @param EncrypterInterface                $encrypter
     */
    private function setUpAlgorithmConfigurationGetEncrypter(
        AlgorithmConfiguration $algorithmConfig,
        EncrypterInterface $encrypter
    ) {
        $algorithmConfig->expects($this->once())
            ->method('getEncrypter')
            ->with()
            ->will($this->returnValue($encrypter));
    }

    /**
     * Set up AlgorithmConfiguration: getEncryptionKeyConfig.
     *
     * @param AlgorithmConfiguration|MockObject $algorithmConfig
     * @param KeyConfiguration                  $keyConfig
     */
    private function setUpAlgorithmConfigurationGetEncryptionKeyConfig(
        AlgorithmConfiguration $algorithmConfig,
        KeyConfiguration $keyConfig
    ) {
        $algorithmConfig->expects($this->once())
            ->method('getEncryptionKeyConfig')
            ->with()
            ->will($this->returnValue($keyConfig));
    }

    /**
     * Set up CryptoRenderer: renderOutput.
     *
     * @param string          $encryptedValue
     * @param TransformedKey  $transformedKey
     * @param OutputInterface $output
     */
    private function setUpCryptoRendererRenderOutput(
        $encryptedValue,
        TransformedKey $transformedKey,
        OutputInterface $output
    ) {
        $this->renderer->expects($this->once())
            ->method('renderOutput')
            ->with(
                $this->identicalTo($encryptedValue),
                $this->identicalTo($transformedKey),
                $this->identicalTo($output)
            );
    }

    /**
     * Set up encrypter: encrypt value.
     *
     * @param EncrypterInterface|MockObject $encrypter
     * @param string                        $plaintextValue
     * @param string                        $key
     * @param string                        $encryptedValue
     */
    private function setUpEncrypterEncryptValue(EncrypterInterface $encrypter, $plaintextValue, $key, $encryptedValue)
    {
        $encrypter->expects($this->once())
            ->method('encryptValue')
            ->with(
                $this->identicalTo($plaintextValue),
                $this->identicalTo($key)
            )
            ->will($this->returnValue($encryptedValue));
    }

    /**
     * Set up TransformedKey: getFinalKey.
     *
     * @param TransformedKey|MockObject $transformedKey
     * @param string                    $key
     */
    private function setUpTransformedKeyGetFinalKey(TransformedKey $transformedKey, $key)
    {
        $transformedKey->expects($this->once())
            ->method('getFinalKey')
            ->with()
            ->will($this->returnValue($key));
    }

    /**
     * Set up TransformedKeyProvider: getTransformedKey.
     *
     * @param KeyConfiguration $activeKeyConfig
     * @param TransformedKey   $transformedKey
     */
    private function setUpTransformedKeyProviderGetTransformedKey(
        KeyConfiguration $activeKeyConfig,
        TransformedKey $transformedKey
    ) {
        $this->transformedKeyProvider->expects($this->once())
            ->method('getTransformedKey')
            ->with($this->identicalTo($activeKeyConfig))
            ->will($this->returnValue($transformedKey));
    }
}
