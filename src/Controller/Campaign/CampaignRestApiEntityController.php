<?php

namespace App\Controller\Campaign;

use App\Controller\AbstractRestApiEntityController;
use App\Entity\Campaign;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AbstractRestApiEntityController.
 *
 * @Route("/api/campaign", name="api_campaign")
 */
class CampaignRestApiEntityController extends AbstractRestApiEntityController
{
    protected function getEntityClass(): string
    {
        return Campaign::class;
    }

    /**
     * Get action.
     *
     * @Route("/get/{id}", name="get", methods={"GET"}, requirements={"id"="\d+"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns entity as array",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Campaign::class, groups={"full"}))
     *     )
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     description="The field used to find entity"
     * )
     * @SWG\Tag(name="Campaign entity")
     */
    public function getAction(int $id): JsonResponse
    {
        return parent::getAction($id);
    }
}
