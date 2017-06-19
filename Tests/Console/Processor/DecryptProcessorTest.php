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

use Picodexter\ParameterEncryptionBundle\Configuration\AlgorithmConfiguration;
use Picodexter\ParameterEncryptionBundle\Configuration\AlgorithmConfigurationContainerInterface;
use Picodexter\ParameterEncryptionBundle\Configuration\Key\KeyConfiguration;
use Picodexter\ParameterEncryptionBundle\Console\Helper\AlgorithmIdValidatorInterface;
use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAskerInterface;
use Picodexter\ParameterEncryptionBundle\Console\Processor\ActiveKeyConfigurationProviderInterface;
use Picodexter\ParameterEncryptionBundle\Console\Processor\DecryptProcessor;
use Picodexter\ParameterEncryptionBundle\Console\Processor\TransformedKey;
use Picodexter\ParameterEncryptionBundle\Console\Processor\TransformedKeyProviderInterface;
use Picodexter\ParameterEncryptionBundle\Console\Renderer\CryptRendererInterface;
use Picodexter\ParameterEncryptionBundle\Console\Request\DecryptRequest;
use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\DecrypterInterface;
use Picodexter\ParameterEncryptionBundle\Exception\Console\UnknownAlgorithmIdException;
use Symfony\Component\Console\Output\OutputInterface;

class DecryptProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ActiveKeyConfigurationProviderInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $activeKeyConfigProvider;

    /**
     * @var AlgorithmConfigurationContainerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $algorithmConfigContainer;

    /**
     * @var AlgorithmIdValidatorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $algorithmIdValidator;

    /**
     * @var DecryptProcessor
     */
    private $processor;

    /**
     * @var CryptRendererInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $renderer;

    /**
     * @var TransformedKeyProviderInterface|\PHPUnit_Framework_MockObject_MockObject
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

        $this->processor = new DecryptProcessor(
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

    public function testRenderDecryptOutputExceptionUnknownAlgorithmId()
    {
        $this->expectException(UnknownAlgorithmIdException::class);

        $algorithmId = 'doesnotexist';

        $request = new DecryptRequest(
            $algorithmId,
            $this->createQuestionAskerInterfaceMock(),
            'this is encrypted',
            'secret key',
            true
        );
        $output = $this->createOutputInterfaceMock();

        $this->algorithmIdValidator->expects($this->once())
            ->method('assertKnownAlgorithmId')
            ->with($this->identicalTo($algorithmId))
            ->will($this->throwException(new UnknownAlgorithmIdException($algorithmId)));

        $this->processor->renderDecryptOutput($request, $output);
    }

    public function testRenderDecryptOutputSuccessPlaintextValueFromRequest()
    {
        $algorithmId = 'algo_01';
        $key = 'secret key';
        $keyProvided = true;
        $encryptedValue = 'this is encrypted';
        $decryptedValue = 'decrypted value';

        $request = new DecryptRequest(
            $algorithmId,
            $this->createQuestionAskerInterfaceMock(),
            $encryptedValue,
            $key,
            $keyProvided
        );
        $output = $this->createOutputInterfaceMock();
        $algorithmConfig = $this->createAlgorithmConfigurationMock();
        $keyConfig = $this->createKeyConfigurationMock();
        $activeKeyConfig = $this->createKeyConfigurationMock();
        $decrypter = $this->createDecrypterInterfaceMock();
        $transformedKey = $this->createTransformedKeyMock();

        $this->setUpAlgorithmConfigurationContainerGetAlgorithmConfiguration($algorithmId, $algorithmConfig);

        $this->setUpAlgorithmConfigurationGetDecryptionKeyConfig($algorithmConfig, $keyConfig);

        $this->setUpActiveKeyConfigurationProviderGetActiveKeyConfiguration(
            $keyProvided,
            $key,
            $keyConfig,
            $activeKeyConfig
        );

        $this->setUpTransformedKeyProviderGetTransformedKey($activeKeyConfig, $transformedKey);

        $this->setUpAlgorithmConfigurationGetDecrypter($algorithmConfig, $decrypter);

        $this->setUpTransformedKeyGetFinalKey($transformedKey, $key);

        $this->setUpDecrypterDecryptValue($decrypter, $encryptedValue, $key, $decryptedValue);

        $this->setUpCryptoRendererRenderOutput($decryptedValue, $transformedKey, $output);

        $this->processor->renderDecryptOutput($request, $output);
    }

    public function testRenderDecryptOutputSuccessPlaintextValueFromQuestionAsker()
    {
        $algorithmId = 'algo_01';
        $key = 'secret key';
        $keyProvided = true;
        $encryptedValue = 'decrypt me';
        $decryptedValue = 'decrypted value';

        $encryptedAsker = $this->createQuestionAskerInterfaceMock();
        $request = new DecryptRequest(
            $algorithmId,
            $encryptedAsker,
            null,
            $key,
            $keyProvided
        );
        $output = $this->createOutputInterfaceMock();
        $algorithmConfig = $this->createAlgorithmConfigurationMock();
        $keyConfig = $this->createKeyConfigurationMock();
        $activeKeyConfig = $this->createKeyConfigurationMock();
        $decrypter = $this->createDecrypterInterfaceMock();
        $transformedKey = $this->createTransformedKeyMock();

        $this->setUpAlgorithmConfigurationContainerGetAlgorithmConfiguration($algorithmId, $algorithmConfig);

        $encryptedAsker->expects($this->once())
            ->method('askQuestion')
            ->with()
            ->will($this->returnValue($encryptedValue));

        $this->setUpAlgorithmConfigurationGetDecryptionKeyConfig($algorithmConfig, $keyConfig);

        $this->setUpActiveKeyConfigurationProviderGetActiveKeyConfiguration(
            $keyProvided,
            $key,
            $keyConfig,
            $activeKeyConfig
        );

        $this->setUpTransformedKeyProviderGetTransformedKey($activeKeyConfig, $transformedKey);

        $this->setUpAlgorithmConfigurationGetDecrypter($algorithmConfig, $decrypter);

        $this->setUpTransformedKeyGetFinalKey($transformedKey, $key);

        $this->setUpDecrypterDecryptValue($decrypter, $encryptedValue, $key, $decryptedValue);

        $this->setUpCryptoRendererRenderOutput($decryptedValue, $transformedKey, $output);

        $this->processor->renderDecryptOutput($request, $output);
    }

    /**
     * Create mock for ActiveKeyConfigurationProviderInterface.
     *
     * @return ActiveKeyConfigurationProviderInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createActiveKeyConfigurationProviderInterfaceMock()
    {
        return $this->getMockBuilder(ActiveKeyConfigurationProviderInterface::class)->getMock();
    }

    /**
     * Create mock for AlgorithmConfigurationContainerInterface.
     *
     * @return AlgorithmConfigurationContainerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createAlgorithmConfigurationContainerInterfaceMock()
    {
        return $this->getMockBuilder(AlgorithmConfigurationContainerInterface::class)->getMock();
    }

    /**
     * Create mock for AlgorithmConfiguration.
     *
     * @return AlgorithmConfiguration|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createAlgorithmConfigurationMock()
    {
        return $this->getMockBuilder(AlgorithmConfiguration::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * Create mock for AlgorithmIdValidatorInterface.
     *
     * @return AlgorithmIdValidatorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createAlgorithmIdValidatorInterfaceMock()
    {
        return $this->getMockBuilder(AlgorithmIdValidatorInterface::class)->getMock();
    }

    /**
     * Create mock for CryptRendererInterface.
     *
     * @return CryptRendererInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createCryptRendererInterfaceMock()
    {
        return $this->getMockBuilder(CryptRendererInterface::class)->getMock();
    }

    /**
     * Create mock for DecrypterInterface.
     *
     * @return DecrypterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createDecrypterInterfaceMock()
    {
        return $this->getMockBuilder(DecrypterInterface::class)->getMock();
    }

    /**
     * Create mock for KeyConfiguration.
     *
     * @return KeyConfiguration|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createKeyConfigurationMock()
    {
        return $this->getMockBuilder(KeyConfiguration::class)->getMock();
    }

    /**
     * Create mock for OutputInterface.
     *
     * @return OutputInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createOutputInterfaceMock()
    {
        return $this->getMockBuilder(OutputInterface::class)->getMock();
    }

    /**
     * Create mock for QuestionAskerInterface.
     *
     * @return QuestionAskerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createQuestionAskerInterfaceMock()
    {
        return $this->getMockBuilder(QuestionAskerInterface::class)->getMock();
    }

    /**
     * Create mock for TransformedKey.
     *
     * @return TransformedKey|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createTransformedKeyMock()
    {
        return $this->getMockBuilder(TransformedKey::class)->getMock();
    }

    /**
     * Create mock for TransformedKeyProviderInterface.
     *
     * @return TransformedKeyProviderInterface|\PHPUnit_Framework_MockObject_MockObject
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
     * Set up algorithm configuration: get decrypter.
     *
     * @param AlgorithmConfiguration|\PHPUnit_Framework_MockObject_MockObject $algorithmConfig
     * @param DecrypterInterface                                              $decrypter
     */
    private function setUpAlgorithmConfigurationGetDecrypter(
        AlgorithmConfiguration $algorithmConfig,
        DecrypterInterface $decrypter
    ) {
        $algorithmConfig->expects($this->once())
            ->method('getDecrypter')
            ->with()
            ->will($this->returnValue($decrypter));
    }

    /**
     * Set up AlgorithmConfiguration: getDecryptionKeyConfig.
     *
     * @param AlgorithmConfiguration|\PHPUnit_Framework_MockObject_MockObject $algorithmConfig
     * @param KeyConfiguration                                                $keyConfig
     */
    private function setUpAlgorithmConfigurationGetDecryptionKeyConfig(
        AlgorithmConfiguration $algorithmConfig,
        KeyConfiguration $keyConfig
    ) {
        $algorithmConfig->expects($this->once())
            ->method('getDecryptionKeyConfig')
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
     * Set up decrypter: decrypt value.
     *
     * @param DecrypterInterface|\PHPUnit_Framework_MockObject_MockObject $decrypter
     * @param string                                                      $encryptedValue
     * @param string                                                      $key
     * @param string                                                      $decryptedValue
     */
    private function setUpDecrypterDecryptValue(DecrypterInterface $decrypter, $encryptedValue, $key, $decryptedValue)
    {
        $decrypter->expects($this->once())
            ->method('decryptValue')
            ->with(
                $this->identicalTo($encryptedValue),
                $this->identicalTo($key)
            )
            ->will($this->returnValue($decryptedValue));
    }

    /**
     * Set up TransformedKey: getFinalKey.
     *
     * @param TransformedKey|\PHPUnit_Framework_MockObject_MockObject $transformedKey
     * @param string                                                  $key
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
