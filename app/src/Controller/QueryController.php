<?php

namespace App\Controller;

use DateTime;
use App\Request\QueryRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Cache\ICacheService;

class QueryController extends AbstractController
{
    #[Route('/query', name: 'app_query')]
    public function index(QueryRequest $request, ICacheService $cacheService): JsonResponse
    {
        $query = $request->getRequest()->query->all();
        return $this->json([
            'data' => $cacheService->get(
                $query['datamarts'],
                new DateTime($query['date_time_from']),
                new Datetime($query['date_time_to'])
            ),
        ]);
    }
}
