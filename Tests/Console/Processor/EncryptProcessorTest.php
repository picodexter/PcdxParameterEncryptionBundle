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
use Picodexter\ParameterEncryptionBundle\Console\Processor\EncryptProcessor;
use Picodexter\ParameterEncryptionBundle\Console\Request\EncryptRequest;
use Picodexter\ParameterEncryptionBundle\Encryption\Encrypter\EncrypterInterface;
use Picodexter\ParameterEncryptionBundle\Exception\Console\UnknownAlgorithmIdException;
use Symfony\Component\Console\Output\OutputInterface;

class EncryptProcessorTest extends \PHPUnit_Framework_TestCase
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
     * @var EncryptProcessor
     */
    private $processor;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->algorithmConfigContainer = $this->createAlgorithmConfigurationContainerInterfaceMock();
        $this->algorithmIdValidator = $this->createAlgorithmIdValidatorInterfaceMock();

        $this->processor = new EncryptProcessor($this->algorithmConfigContainer, $this->algorithmIdValidator);
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
    public function testRenderEncryptOutputExceptionUnknownAlgorithmId()
    {
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
        $plaintextValue = 'to be encrypted';
        $encryptedValue = 'encrypted value';

        $request = new EncryptRequest(
            $algorithmId,
            $key,
            true,
            $this->createQuestionAskerInterfaceMock(),
            $plaintextValue
        );
        $output = $this->createOutputInterfaceMock();
        $algorithmConfig = $this->createAlgorithmConfigurationMock();
        $encrypter = $this->createEncrypterInterfaceMock();

        $this->setUpAlgorithmConfigurationContainerGetAlgorithmConfiguration($algorithmId, $algorithmConfig);

        $this->setUpAlgorithmConfigurationGetEncrypter($algorithmConfig, $encrypter);

        $this->setUpEncrypterEncryptValue($encrypter, $plaintextValue, $key, $encryptedValue);

        $this->setUpOutputForDefaultResult($output, $key, $encryptedValue);

        $this->processor->renderEncryptOutput($request, $output);
    }

    public function testRenderEncryptOutputSuccessPlaintextValueFromQuestionAsker()
    {
        $algorithmId = 'algo_01';
        $key = 'secret key';
        $plaintextValue = 'encrypt me';
        $encryptedValue = 'encrypted value';

        $plaintextAsker = $this->createQuestionAskerInterfaceMock();
        $request = new EncryptRequest(
            $algorithmId,
            $key,
            true,
            $plaintextAsker,
            null
        );
        $output = $this->createOutputInterfaceMock();
        $algorithmConfig = $this->createAlgorithmConfigurationMock();
        $encrypter = $this->createEncrypterInterfaceMock();

        $this->setUpAlgorithmConfigurationContainerGetAlgorithmConfiguration($algorithmId, $algorithmConfig);

        $plaintextAsker->expects($this->once())
            ->method('askQuestion')
            ->with()
            ->will($this->returnValue($plaintextValue));

        $this->setUpAlgorithmConfigurationGetEncrypter($algorithmConfig, $encrypter);

        $this->setUpEncrypterEncryptValue($encrypter, $plaintextValue, $key, $encryptedValue);

        $this->setUpOutputForDefaultResult($output, $key, $encryptedValue);

        $this->processor->renderEncryptOutput($request, $output);
    }

    public function testRenderEncryptOutputSuccessKeyFromAlgorithmConfiguration()
    {
        $algorithmId = 'algo_01';
        $key = 'some key';
        $plaintextValue = 'encrypt me';
        $encryptedValue = 'encrypted value';

        $request = new EncryptRequest(
            $algorithmId,
            '',
            false,
            $this->createQuestionAskerInterfaceMock(),
            $plaintextValue
        );
        $output = $this->createOutputInterfaceMock();
        $algorithmConfig = $this->createAlgorithmConfigurationMock();
        $encrypter = $this->createEncrypterInterfaceMock();

        $this->setUpAlgorithmConfigurationContainerGetAlgorithmConfiguration($algorithmId, $algorithmConfig);

        $algorithmConfig->expects($this->once())
            ->method('getEncryptionKey')
            ->with()
            ->will($this->returnValue($key));

        $this->setUpAlgorithmConfigurationGetEncrypter($algorithmConfig, $encrypter);

        $this->setUpEncrypterEncryptValue($encrypter, $plaintextValue, $key, $encryptedValue);

        $this->setUpOutputForDefaultResult($output, $key, $encryptedValue);

        $this->processor->renderEncryptOutput($request, $output);
    }

    public function testRenderEncryptOutputSuccessQuietOutput()
    {
        $algorithmId = 'algo_01';
        $key = 'some key';
        $plaintextValue = 'encrypt me';
        $encryptedValue = 'encrypted me';

        $request = new EncryptRequest(
            $algorithmId,
            $key,
            true,
            $this->createQuestionAskerInterfaceMock(),
            $plaintextValue
        );
        $output = $this->createOutputInterfaceMock();
        $algorithmConfig = $this->createAlgorithmConfigurationMock();
        $encrypter = $this->createEncrypterInterfaceMock();

        $this->setUpAlgorithmConfigurationContainerGetAlgorithmConfiguration($algorithmId, $algorithmConfig);

        $this->setUpAlgorithmConfigurationGetEncrypter($algorithmConfig, $encrypter);

        $this->setUpEncrypterEncryptValue($encrypter, $plaintextValue, $key, $encryptedValue);

        $output->expects($this->once())
            ->method('getVerbosity')
            ->with()
            ->will($this->returnValue(OutputInterface::VERBOSITY_QUIET));

        $this->setUpOutputForQuietResult($output, $encryptedValue);

        $this->processor->renderEncryptOutput($request, $output);
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
     * Create mock for EncrypterInterface.
     *
     * @return EncrypterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createEncrypterInterfaceMock()
    {
        return $this->getMockBuilder(EncrypterInterface::class)->getMock();
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
     * Set up algorithm configuration: get encrypter.
     *
     * @param AlgorithmConfiguration|\PHPUnit_Framework_MockObject_MockObject $algorithmConfig
     * @param EncrypterInterface                                              $encrypter
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
     * Set up encrypter: encrypt value.
     *
     * @param EncrypterInterface|\PHPUnit_Framework_MockObject_MockObject $encrypter
     * @param string                                                      $plaintextValue
     * @param string|null                                                 $key
     * @param string                                                      $encryptedValue
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
     * Set up output: for default result.
     *
     * @param OutputInterface|\PHPUnit_Framework_MockObject_MockObject $output
     * @param string|null                                              $key
     * @param string                                                   $encryptedValue
     */
    private function setUpOutputForDefaultResult(OutputInterface $output, $key, $encryptedValue)
    {
        $output->expects($this->exactly(2))
            ->method('writeln')
            ->withConsecutive(
                [$this->identicalTo('Encryption key:  "' . $key . '"')],
                [$this->identicalTo('Encrypted value: "' . $encryptedValue . '"')]
            );
    }

    /**
     * Set up output: for quiet result.
     *
     * @param OutputInterface|\PHPUnit_Framework_MockObject_MockObject $output
     * @param string                                                   $encryptedValue
     */
    private function setUpOutputForQuietResult(OutputInterface $output, $encryptedValue)
    {
        $output->expects($this->once())
            ->method('writeln')
            ->with(
                $this->identicalTo($encryptedValue),
                $this->identicalTo(OutputInterface::VERBOSITY_QUIET)
            );
    }
}
