<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Renderer;

use Picodexter\ParameterEncryptionBundle\Console\Processor\TransformedKey;
use Picodexter\ParameterEncryptionBundle\Console\Renderer\AbstractCryptRenderer;
use Symfony\Component\Console\Output\OutputInterface;

class AbstractCryptRendererTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractCryptRenderer|DummyAbstractCryptRenderer
     */
    private $renderer;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->renderer = new DummyAbstractCryptRenderer();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->renderer = null;
    }

    public function testRenderOutputSuccessGeneratedKey()
    {
        $result = 'the result';

        $transformedKey = $this->createTransformedKeyMock();
        $output = $this->createOutputInterfaceMock();

        $this->setUpOutputGetVerbosity($output, OutputInterface::VERBOSITY_NORMAL);

        $this->setUpTransformedKeyHasChanged($transformedKey, true);

        $output->expects($this->exactly(2))
            ->method('writeln')
            ->withConsecutive(
                [$this->identicalTo(DummyAbstractCryptRenderer::MESSAGE_FOR_GENERATED_KEY)],
                [$this->identicalTo(DummyAbstractCryptRenderer::MESSAGE_FOR_RESULT)]
            );

        $this->renderer->renderOutput($result, $transformedKey, $output);
    }

    public function testRenderOutputSuccessQuiet()
    {
        $result = 'the result';

        $transformedKey = $this->createTransformedKeyMock();
        $output = $this->createOutputInterfaceMock();

        $this->setUpOutputGetVerbosity($output, OutputInterface::VERBOSITY_QUIET);

        $output->expects($this->once())
            ->method('writeln')
            ->with(
                $this->identicalTo($result),
                OutputInterface::VERBOSITY_QUIET
            );

        $this->renderer->renderOutput($result, $transformedKey, $output);
    }

    public function testRenderOutputSuccessStaticKey()
    {
        $result = 'the result';

        $transformedKey = $this->createTransformedKeyMock();
        $output = $this->createOutputInterfaceMock();

        $this->setUpOutputGetVerbosity($output, OutputInterface::VERBOSITY_NORMAL);

        $this->setUpTransformedKeyHasChanged($transformedKey, false);

        $output->expects($this->exactly(2))
            ->method('writeln')
            ->withConsecutive(
                [$this->identicalTo(DummyAbstractCryptRenderer::MESSAGE_FOR_STATIC_KEY)],
                [$this->identicalTo(DummyAbstractCryptRenderer::MESSAGE_FOR_RESULT)]
            );

        $this->renderer->renderOutput($result, $transformedKey, $output);
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
     * Create mock for TransformedKey.
     *
     * @return TransformedKey|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createTransformedKeyMock()
    {
        return $this->getMockBuilder(TransformedKey::class)->getMock();
    }

    /**
     * Set up Output: getVerbosity.
     *
     * @param OutputInterface|\PHPUnit_Framework_MockObject_MockObject $output
     * @param int                                                      $verbosityLevel
     */
    private function setUpOutputGetVerbosity(OutputInterface $output, $verbosityLevel)
    {
        $output->expects($this->once())
            ->method('getVerbosity')
            ->with()
            ->will($this->returnValue($verbosityLevel));
    }

    /**
     * Set up TransformedKey: hasChanged.
     *
     * @param TransformedKey|\PHPUnit_Framework_MockObject_MockObject $transformedKey
     * @param bool                                                    $hasChanged
     */
    private function setUpTransformedKeyHasChanged(TransformedKey $transformedKey, $hasChanged)
    {
        $transformedKey->expects($this->once())
            ->method('hasChanged')
            ->with()
            ->will($this->returnValue($hasChanged));
    }
}
