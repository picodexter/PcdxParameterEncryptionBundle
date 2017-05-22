<?php

/*
 * This file is part of the PcdxParameterEncryptionBundle package.
 *
 * (c) picodexter <https://picodexter.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Picodexter\ParameterEncryptionBundle\Tests\Console\Request;

use Picodexter\ParameterEncryptionBundle\Console\Helper\QuestionAskerInterface;
use Picodexter\ParameterEncryptionBundle\Console\Request\EncryptRequest;

class EncryptRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorKeyProvidedSuccessCast()
    {
        $requestData = $this->getDummyEncryptRequestData();

        $requestData['keyProvided'] = 'not a boolean';

        $request = $this->createEncryptRequestWithData($requestData);

        $this->assertTrue($request->isKeyProvided());

        $requestData['keyProvided'] = 0;

        $request = $this->createEncryptRequestWithData($requestData);

        $this->assertFalse($request->isKeyProvided());
    }

    public function testGetAlgorithmIdSuccess()
    {
        $requestData = $this->getDummyEncryptRequestData();

        $requestData['algorithmId'] = 'sample_algo_01';

        $request = $this->createEncryptRequestWithData($requestData);

        $this->assertSame($requestData['algorithmId'], $request->getAlgorithmId());

        $requestData['algorithmId'] = 'sample_algo_02';

        $request = $this->createEncryptRequestWithData($requestData);

        $this->assertSame($requestData['algorithmId'], $request->getAlgorithmId());
    }

    public function testGetKeySuccess()
    {
        $requestData = $this->getDummyEncryptRequestData();

        $requestData['key'] = 'super secret key';

        $request = $this->createEncryptRequestWithData($requestData);

        $this->assertSame($requestData['key'], $request->getKey());

        $requestData['key'] = 'other secret key';

        $request = $this->createEncryptRequestWithData($requestData);

        $this->assertSame($requestData['key'], $request->getKey());
    }

    public function testIsKeyProvidedSuccess()
    {
        $requestData = $this->getDummyEncryptRequestData();

        $requestData['keyProvided'] = true;

        $request = $this->createEncryptRequestWithData($requestData);

        $this->assertSame($requestData['keyProvided'], $request->isKeyProvided());

        $requestData['keyProvided'] = false;

        $request = $this->createEncryptRequestWithData($requestData);

        $this->assertSame($requestData['keyProvided'], $request->isKeyProvided());
    }

    public function testGetPlaintextQuestionAskerSuccess()
    {
        $requestData = $this->getDummyEncryptRequestData();

        $requestData['plaintextAsker'] = $this->createQuestionAskerInterfaceMock();

        $request = $this->createEncryptRequestWithData($requestData);

        $this->assertSame($requestData['plaintextAsker'], $request->getPlaintextQuestionAsker());

        $requestData['plaintextAsker'] = $this->createQuestionAskerInterfaceMock();

        $request = $this->createEncryptRequestWithData($requestData);

        $this->assertSame($requestData['plaintextAsker'], $request->getPlaintextQuestionAsker());
    }

    public function testGetPlaintextValueSuccess()
    {
        $requestData = $this->getDummyEncryptRequestData();

        $requestData['plaintextValue'] = 'plain 1';

        $request = $this->createEncryptRequestWithData($requestData);

        $this->assertSame($requestData['plaintextValue'], $request->getPlaintextValue());

        $requestData['plaintextValue'] = 'plain 2';

        $request = $this->createEncryptRequestWithData($requestData);

        $this->assertSame($requestData['plaintextValue'], $request->getPlaintextValue());
    }

    /**
     * Create encrypt request with data.
     *
     * @param array $requestData
     * @return EncryptRequest
     */
    private function createEncryptRequestWithData(array $requestData)
    {
        return new EncryptRequest(
            $requestData['algorithmId'],
            $requestData['key'],
            $requestData['keyProvided'],
            $requestData['plaintextAsker'],
            $requestData['plaintextValue']
        );
    }

    /**
     * Create mock for QuestionAskerInterface.
     *
     * @return QuestionAskerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createQuestionAskerInterfaceMock()
    {
        return $this->getMockBuilder(QuestionAskerInterface::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * Get dummy encrypt request data.
     *
     * @return array
     */
    private function getDummyEncryptRequestData()
    {
        return [
            'algorithmId'    => 'algo_01',
            'key'            => 'secret key',
            'keyProvided'    => true,
            'plaintextAsker' => $this->createQuestionAskerInterfaceMock(),
            'plaintextValue' => 'plaintext',
        ];
    }
}
