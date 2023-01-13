<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Group;
use App\Repository\GroupRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GroupController extends AbstractApiController
{
    /**
     * @Route("/api/groups", name="app_groups", methods={"GET"})
     */
    public function indexAction(GroupRepository $groupRepository): Response
    {
        $groups = $groupRepository->findAll();

        foreach ($groups as $group) {
            $data[] = [
                'id' => $group->getId(),
                'groupName' => $group->getGroupname(),
            ];
        }

        return new JsonResponse($data, self::RESPONSE_STATUS_CODE_SUCCESS);
    }

    /**
     * @Route("/api/groups", name="create_group", methods={"POST"})
     */
    public function createAction(Request $request, GroupRepository $groupRepository): Response
    {
        $groupData = json_decode($request->getContent(), true);

        $group = new Group();
        $group->setGroupname($groupData['group_name']);

        $groupRepository->save($group, true);

        return $this->response(
            true,
            'Group created successfully',
            self::RESPONSE_STATUS_CODE_SUCCESS
        );
    }

    /**
     * @Route("/api/groups/{groupId}", name="delete_group", methods={"DELETE"}, requirements={"id": "\d+"})
     */
    public function deleteAction(Request $request, GroupRepository $groupRepository): Response
    {
        $groupId = $request->get('groupId');

        $group = $groupRepository->findOneBy([
            'id' => $groupId,
        ]);

        if (!$group) {
            return $this->response(
                false,
                'Group not found!',
                self::RESPONSE_STATUS_CODE_NOT_FOUND
            );
        }

        if ($group->getGroupUsers()->count() > 0) {
            return $this->response(
                false,
                'Group can not be deleted, it have users assigned',
                self::RESPONSE_STATUS_CODE_BAD_REQUEST
            );
        }

        $groupRepository->remove($group, true);

        return $this->response(
            true,
            'Group deleted successfully',
            self::RESPONSE_STATUS_CODE_SUCCESS
        );
    }
}