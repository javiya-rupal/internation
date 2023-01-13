<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\GroupRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GroupUserController extends AbstractApiController
{
    /**
     * @Route("/api/groupUser/assign", name="assign_group_user", methods={"POST"})
     */
    public function assignGroupAction(
        Request $request,
        GroupRepository $groupRepository,
        UserRepository $userRepository
    ): Response {
        $groupUserData = json_decode($request->getContent(), true);

        $group = $groupRepository->findOneBy([
            'id' => $groupUserData['group_id'],
        ]);

        if (!$group) {
            return $this->response(
                false,
                'Group not found!',
                self::RESPONSE_STATUS_CODE_NOT_FOUND
            );
        }

        $user = $userRepository->findOneBy([
            'id' => $groupUserData['user_id'],
        ]);

        if (!$user) {
            return $this->response(
                false,
                'User not found!',
                self::RESPONSE_STATUS_CODE_NOT_FOUND
            );
        }

        if ($group->getGroupUsers()->contains($user)) {
            return $this->response(
                false,
                'User is already assigned to this Group!',
                self::RESPONSE_STATUS_CODE_BAD_REQUEST
            );
        }

        $groupRepository->addGroupUser($group, $user, true);

        return $this->response(
            true,
            'Group assigned successfully',
            self::RESPONSE_STATUS_CODE_SUCCESS
        );
    }

    /**
     * @Route("/api/groupUser/remove", name="remove_group_user", methods={"POST"})
     */
    public function removeGroupUserAction(
        Request $request,
        GroupRepository $groupRepository,
        UserRepository $userRepository
    ): Response {
        $groupUserData = json_decode($request->getContent(), true);

        $group = $groupRepository->findOneBy([
            'id' => $groupUserData['group_id'],
        ]);

        if (!$group) {
            return $this->response(
                false,
                'Group not found!',
                self::RESPONSE_STATUS_CODE_NOT_FOUND
            );
        }

        $userId = $groupUserData['user_id'];
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

        if (!$group->getGroupUsers()->contains($user)) {
            return $this->response(
                false,
                'User is not assigned to this Group',
                self::RESPONSE_STATUS_CODE_BAD_REQUEST
            );
        }

        $groupRepository->removeGroupUser($group, $user, true);

        return $this->response(
            true,
            'User removed from Group successfully',
            self::RESPONSE_STATUS_CODE_SUCCESS
        );
    }
}