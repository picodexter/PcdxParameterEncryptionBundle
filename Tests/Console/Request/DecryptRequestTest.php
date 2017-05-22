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
use Picodexter\ParameterEncryptionBundle\Console\Request\DecryptRequest;

class DecryptRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorKeyProvidedSuccessCast()
    {
        $requestData = $this->getDummyDecryptRequestData();

        $requestData['keyProvided'] = 'not a boolean';

        $request = $this->createDecryptRequestWithData($requestData);

        $this->assertTrue($request->isKeyProvided());

        $requestData['keyProvided'] = 0;

        $request = $this->createDecryptRequestWithData($requestData);

        $this->assertFalse($request->isKeyProvided());
    }

    public function testGetAlgorithmIdSuccess()
    {
        $requestData = $this->getDummyDecryptRequestData();

        $requestData['algorithmId'] = 'sample_algo_01';

        $request = $this->createDecryptRequestWithData($requestData);

        $this->assertSame($requestData['algorithmId'], $request->getAlgorithmId());

        $requestData['algorithmId'] = 'sample_algo_02';

        $request = $this->createDecryptRequestWithData($requestData);

        $this->assertSame($requestData['algorithmId'], $request->getAlgorithmId());
    }

    public function testGetEncryptedQuestionAskerSuccess()
    {
        $requestData = $this->getDummyDecryptRequestData();

        $requestData['encryptedAsker'] = $this->createQuestionAskerInterfaceMock();

        $request = $this->createDecryptRequestWithData($requestData);

        $this->assertSame($requestData['encryptedAsker'], $request->getEncryptedQuestionAsker());

        $requestData['encryptedAsker'] = $this->createQuestionAskerInterfaceMock();

        $request = $this->createDecryptRequestWithData($requestData);

        $this->assertSame($requestData['encryptedAsker'], $request->getEncryptedQuestionAsker());
    }

    public function testGetEncryptedValueSuccess()
    {
        $requestData = $this->getDummyDecryptRequestData();

        $requestData['encryptedValue'] = 'encrypted 1';

        $request = $this->createDecryptRequestWithData($requestData);

        $this->assertSame($requestData['encryptedValue'], $request->getEncryptedValue());

        $requestData['encryptedValue'] = 'encrypted 2';

        $request = $this->createDecryptRequestWithData($requestData);

        $this->assertSame($requestData['encryptedValue'], $request->getEncryptedValue());
    }

    public function testGetKeySuccess()
    {
        $requestData = $this->getDummyDecryptRequestData();

        $requestData['key'] = 'super secret key';

        $request = $this->createDecryptRequestWithData($requestData);

        $this->assertSame($requestData['key'], $request->getKey());

        $requestData['key'] = 'other secret key';

        $request = $this->createDecryptRequestWithData($requestData);

        $this->assertSame($requestData['key'], $request->getKey());
    }

    public function testIsKeyProvidedSuccess()
    {
        $requestData = $this->getDummyDecryptRequestData();

        $requestData['keyProvided'] = true;

        $request = $this->createDecryptRequestWithData($requestData);

        $this->assertSame($requestData['keyProvided'], $request->isKeyProvided());

        $requestData['keyProvided'] = false;

        $request = $this->createDecryptRequestWithData($requestData);

        $this->assertSame($requestData['keyProvided'], $request->isKeyProvided());
    }

    /**
     * Create decrypt request with data.
     *
     * @param array $requestData
     * @return DecryptRequest
     */
    private function createDecryptRequestWithData(array $requestData)
    {
        return new DecryptRequest(
            $requestData['algorithmId'],
            $requestData['encryptedAsker'],
            $requestData['encryptedValue'],
            $requestData['key'],
            $requestData['keyProvided']
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
     * Get dummy decrypt request data.
     *
     * @return array
     */
    private function getDummyDecryptRequestData()
    {
        return [
            'algorithmId'    => 'algo_01',
            'encryptedAsker' => $this->createQuestionAskerInterfaceMock(),
            'encryptedValue' => 'encrypted text',
            'key'            => 'secret key',
            'keyProvided'    => true,
        ];
    }
}
