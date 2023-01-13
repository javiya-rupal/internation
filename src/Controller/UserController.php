<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractApiController
{
    /**
     * @Route("/api/users", name="app_users", methods={"GET"})
     */
    public function indexAction(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'userName' => $user->getUserName(),
            ];
        }

        return new JsonResponse($data, self::RESPONSE_STATUS_CODE_SUCCESS);
    }

    /**
     * @Route("/api/users", name="create_user", methods={"POST"})
     */
    public function createAction(Request $request, UserRepository $userRepository): Response
    {
        $userData = json_decode($request->getContent(), true);

        $user = new User();
        $user->setUsername($userData['username']);

        $userRepository->save($user, true);

        return $this->response(
            true,
            'User created successfully',
            self::RESPONSE_STATUS_CODE_SUCCESS
        );
    }

    /**
     * @Route("/api/users/{userId}", name="delete_user", methods={"DELETE"}, requirements={"id": "\d+"})
     */
    public function deleteAction(Request $request, UserRepository $userRepository): Response
    {
        $userId = $request->get('userId');

        $user = $userRepository->findOneBy([
            'id' => $userId,
        ]);

        if (!$user) {
            return $this->response(
                false,
                'User not found!',
                self::RESPONSE_STATUS_CODE_NOT_FOUND
            );
        }

        $userRepository->remove($user, true);

        return $this->response(
            true,
            'User deleted successfully',
            self::RESPONSE_STATUS_CODE_SUCCESS
        );
    }
}