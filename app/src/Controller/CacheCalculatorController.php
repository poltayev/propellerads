<?php

namespace App\Controller;

use App\Request\CalculateRequest;
use App\Service\Cache\ICacheService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CacheCalculatorController extends AbstractController
{
    #[Route('/calculate', name: 'app_cache_calculator')]
    public function calculate(CalculateRequest $request, ICacheService $cacheService): JsonResponse
    {
        $request_body = $request->getRequest()->toArray();
        $cacheService->calculate(
            $request_body['table_name'],
            new DateTime($request_body['datetime']),
            $request_body['data'] ?? []
        );

        return $this->json(['message' => 'Table updated successfully']);
    }
}
