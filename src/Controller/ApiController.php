<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
class ApiController
{
    /**
     * @Route("/generate-otp")
     */
    public function generateOtpAction(Request $request)
    {
        $userId = $request->get('uid');
        $otp = str_pad(rand(0, pow(10, 4) - 1), 4, '0', STR_PAD_LEFT);

        $session = new Session();
        $session->start();
        $session->set($userId, [$otp, time()]);

        $response = new JsonResponse(array('otp' => $otp));

        return $response;
    }

    /**
     * @Route("/validate-otp")
     */
    public function validateOtpAction(Request $request)
    {
        $userId = $request->get('uid');
        $otp = $request->get('otp');
        $isValid = 'false';

        $session = new Session();
        $session->start();

        $sessionData = $session->get($userId);
        if (isset($sessionData)) {
            if($sessionData[0] == $otp && ($sessionData[1] + 121 > time())) {
                $isValid = 'true';
            } else $session->remove($userId);
        }

        $response = new JsonResponse(array('is_valid' => $isValid));

        return $response;
    }

    /**
     * @Route("/test")
     */
    public function testSession()
    {
        $session = new Session();
        $session->start();

        return new JsonResponse($session->all());
    }
}