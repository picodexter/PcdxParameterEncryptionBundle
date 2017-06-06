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
use Picodexter\ParameterEncryptionBundle\Console\Helper\AlgorithmIdValidatorInterface;
use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAskerInterface;
use Picodexter\ParameterEncryptionBundle\Console\Processor\DecryptProcessor;
use Picodexter\ParameterEncryptionBundle\Console\Request\DecryptRequest;
use Picodexter\ParameterEncryptionBundle\Encryption\Decrypter\DecrypterInterface;
use Picodexter\ParameterEncryptionBundle\Exception\Console\UnknownAlgorithmIdException;
use Symfony\Component\Console\Output\OutputInterface;

class DecryptProcessorTest extends \PHPUnit_Framework_TestCase
{
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
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->algorithmConfigContainer = $this->createAlgorithmConfigurationContainerInterfaceMock();
        $this->algorithmIdValidator = $this->createAlgorithmIdValidatorInterfaceMock();

        $this->processor = new DecryptProcessor($this->algorithmConfigContainer, $this->algorithmIdValidator);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->processor = null;
        $this->algorithmConfigContainer = null;
    }

    /**
     * @expectedException \Picodexter\ParameterEncryptionBundle\Exception\Console\UnknownAlgorithmIdException
     */
    public function testRenderDecryptOutputExceptionUnknownAlgorithmId()
    {
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
        $encryptedValue = 'this is encrypted';
        $decryptedValue = 'decrypted value';

        $request = new DecryptRequest(
            $algorithmId,
            $this->createQuestionAskerInterfaceMock(),
            $encryptedValue,
            $key,
            true
        );
        $output = $this->createOutputInterfaceMock();
        $algorithmConfig = $this->createAlgorithmConfigurationMock();
        $decrypter = $this->createDecrypterInterfaceMock();

        $this->setUpAlgorithmConfigurationContainerGetAlgorithmConfiguration($algorithmId, $algorithmConfig);

        $this->setUpAlgorithmConfigurationGetDecrypter($algorithmConfig, $decrypter);

        $this->setUpDecrypterDecryptValue($decrypter, $encryptedValue, $key, $decryptedValue);

        $this->setUpOutputForDefaultResult($output, $key, $decryptedValue);

        $this->processor->renderDecryptOutput($request, $output);
    }

    public function testRenderDecryptOutputSuccessPlaintextValueFromQuestionAsker()
    {
        $algorithmId = 'algo_01';
        $key = 'secret key';
        $encryptedValue = 'decrypt me';
        $decryptedValue = 'decrypted value';

        $encryptedAsker = $this->createQuestionAskerInterfaceMock();
        $request = new DecryptRequest(
            $algorithmId,
            $encryptedAsker,
            null,
            $key,
            true
        );
        $output = $this->createOutputInterfaceMock();
        $algorithmConfig = $this->createAlgorithmConfigurationMock();
        $decrypter = $this->createDecrypterInterfaceMock();

        $this->setUpAlgorithmConfigurationContainerGetAlgorithmConfiguration($algorithmId, $algorithmConfig);

        $encryptedAsker->expects($this->once())
            ->method('askQuestion')
            ->with()
            ->will($this->returnValue($encryptedValue));

        $this->setUpAlgorithmConfigurationGetDecrypter($algorithmConfig, $decrypter);

        $this->setUpDecrypterDecryptValue($decrypter, $encryptedValue, $key, $decryptedValue);

        $this->setUpOutputForDefaultResult($output, $key, $decryptedValue);

        $this->processor->renderDecryptOutput($request, $output);
    }

    public function testRenderDecryptOutputSuccessKeyFromAlgorithmConfiguration()
    {
        $algorithmId = 'algo_01';
        $key = 'some key';
        $encryptedValue = 'decrypt me';
        $decryptedValue = 'decrypted value';

        $request = new DecryptRequest(
            $algorithmId,
            $this->createQuestionAskerInterfaceMock(),
            $encryptedValue,
            '',
            false
        );
        $output = $this->createOutputInterfaceMock();
        $algorithmConfig = $this->createAlgorithmConfigurationMock();
        $decrypter = $this->createDecrypterInterfaceMock();

        $this->setUpAlgorithmConfigurationContainerGetAlgorithmConfiguration($algorithmId, $algorithmConfig);

        $algorithmConfig->expects($this->once())
            ->method('getDecryptionKey')
            ->with()
            ->will($this->returnValue($key));

        $this->setUpAlgorithmConfigurationGetDecrypter($algorithmConfig, $decrypter);

        $this->setUpDecrypterDecryptValue($decrypter, $encryptedValue, $key, $decryptedValue);

        $this->setUpOutputForDefaultResult($output, $key, $decryptedValue);

        $this->processor->renderDecryptOutput($request, $output);
    }

    public function testRenderDecryptOutputSuccessQuietOutput()
    {
        $algorithmId = 'algo_01';
        $key = 'some key';
        $encryptedValue = 'decrypt me';
        $decryptedValue = 'decrypted me';

        $request = new DecryptRequest(
            $algorithmId,
            $this->createQuestionAskerInterfaceMock(),
            $encryptedValue,
            $key,
            true
        );
        $output = $this->createOutputInterfaceMock();
        $algorithmConfig = $this->createAlgorithmConfigurationMock();
        $decrypter = $this->createDecrypterInterfaceMock();

        $this->setUpAlgorithmConfigurationContainerGetAlgorithmConfiguration($algorithmId, $algorithmConfig);

        $this->setUpAlgorithmConfigurationGetDecrypter($algorithmConfig, $decrypter);

        $this->setUpDecrypterDecryptValue($decrypter, $encryptedValue, $key, $decryptedValue);

        $output->expects($this->once())
            ->method('getVerbosity')
            ->with()
            ->will($this->returnValue(OutputInterface::VERBOSITY_QUIET));

        $this->setUpOutputForQuietResult($output, $decryptedValue);

        $this->processor->renderDecryptOutput($request, $output);
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
     * Create mock for DecrypterInterface.
     *
     * @return DecrypterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createDecrypterInterfaceMock()
    {
        return $this->getMockBuilder(DecrypterInterface::class)->getMock();
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
     * Set up decrypter: decrypt value.
     *
     * @param DecrypterInterface|\PHPUnit_Framework_MockObject_MockObject $decrypter
     * @param string                                                      $encryptedValue
     * @param string|null                                                 $key
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
     * Set up output: for default result.
     *
     * @param OutputInterface|\PHPUnit_Framework_MockObject_MockObject $output
     * @param string|null                                              $key
     * @param string                                                   $decryptedValue
     */
    private function setUpOutputForDefaultResult(OutputInterface $output, $key, $decryptedValue)
    {
        $output->expects($this->exactly(2))
            ->method('writeln')
            ->withConsecutive(
                [$this->identicalTo('Decryption key:  "'.$key.'"')],
                [$this->identicalTo('Decrypted value: "'.$decryptedValue.'"')]
            );
    }

    /**
     * Set up output: for quiet result.
     *
     * @param OutputInterface|\PHPUnit_Framework_MockObject_MockObject $output
     * @param string                                                   $decryptedValue
     */
    private function setUpOutputForQuietResult(OutputInterface $output, $decryptedValue)
    {
        $output->expects($this->once())
            ->method('writeln')
            ->with(
                $this->identicalTo($decryptedValue),
                $this->identicalTo(OutputInterface::VERBOSITY_QUIET)
            );
    }
}
