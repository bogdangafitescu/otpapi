<?php

namespace Tests\Controller;

use PHPUnit\Framework\TestCase;
use Simplex\Framework;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use App\Controller\ApiController;

class ApiTest extends TestCase
{
    /**
     * Unit test the otp generate feature
     */
    public function testGenerateOtp()
    {
        $api = new ApiController();
        $request = new Request([], array('uid' => 'test_user'));
        $result = $api->generateOtpAction($request, 1);
        $otpResponse = json_decode($result->getContent(), 1);

        $this->assertInstanceOf(Response::class, $result);
        $this->assertIsArray($otpResponse, 'Otp response is not an array');
        $this->assertArrayHasKey('otp', $otpResponse, 'The `otp` key is missing');
        $this->assertEquals(4, strlen($otpResponse['otp']), 'The `otp` doesn`t have 4 digits');
    }
}