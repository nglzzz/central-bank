<?php

namespace App\Controller\Api\V1;

use App\Handler\Currency\RateHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/currency', name: 'api_v1_currency_')]
final class CurrencyController extends AbstractController
{
    #[Route('/rate', name: 'app_currency')]
    public function rate(Request $request, RateHandler $handler): Response
    {
        $date = $request->query->get('date', \date('Y-m-d'));
        $currency = $request->query->get('currency');
        $baseCurrency = $request->query->get('base_currency');

        if (empty($date) || empty($currency)) {
            return $this->json([
              'message' => 'Bad request'
            ], Response::HTTP_BAD_REQUEST);
        }

        $rate = $handler->getRate(new \DateTimeImmutable($date), $currency, $baseCurrency);

        return $this->json($rate);
    }
}
