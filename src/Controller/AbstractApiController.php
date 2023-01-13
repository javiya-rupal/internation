<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AbstractApiController extends AbstractController
{
    const RESPONSE_STATUS_CODE_BAD_REQUEST = 400;

    const RESPONSE_STATUS_CODE_NOT_FOUND = 404;

    const RESPONSE_STATUS_CODE_SUCCESS = 200;

    public function response(bool $success, string $message, int $code)
    {
        return new JsonResponse(
                ['success' => $success, 'message' => $message], $code
            ); 
    }
}