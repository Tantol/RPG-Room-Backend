<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AbstractRestApiEntityController.
 *
 * @Route("/api", name="abstract_api")
 */
abstract class AbstractRestApiEntityController extends AbstractController
{
    const NOT_FOUND_RESPONSE = [
        'status' => 404,
        'errors' => 'Entity not found',
    ];

    /** @var EntityManagerInterface $entityManager */
    protected $entityManager;

    /**
     * AbstractRestApiEntityController constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Get action.
     *
     * @Route("/get/{id}", name="get", methods={"GET"}, requirements={"id"="\d+"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns entity as array"
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="integer",
     *     description="The field used to find entity"
     * )
     * @SWG\Tag(name="Abstract entity")
     */
    public function getAction(int $id): JsonResponse
    {
        if (!$entity = $this->getRepository()->find($id)) {
            return $this->response(self::NOT_FOUND_RESPONSE, 404);
        }

        return $this->response($entity);
    }

    abstract protected function getEntityClass(): string;

    protected function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository($this->getEntityClass());
    }

    /**
     * @param array|object $data
     */
    protected function response($data, int $status = 200, array $headers = []): JsonResponse
    {
        return new JsonResponse($data, $status, $headers);
    }
}
