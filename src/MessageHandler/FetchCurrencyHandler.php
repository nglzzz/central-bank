<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\FetchCurrencyMessage;
use App\Service\CurrencyRateService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class FetchCurrencyHandler
{
    public function __construct(private readonly CurrencyRateService $currencyRateService)
    {
    }

    public function __invoke(FetchCurrencyMessage $message): void
    {
        $endDate = new \DateTime();
        $startDate = (new \DateTime())->modify('-' . $message->getDays() . ' days');

        $interval = new \DateInterval('P1D');
        $dateRange = new \DatePeriod($startDate, $interval, $endDate);

        $succeed = 0;
        $failed = 0;
        foreach ($dateRange as $date) {
            $sync = $this->currencyRateService->getByDate($date);

            if ($sync) {
                $succeed++;
            } else {
                $failed++;
            }
        }

        printf(
            'Days: %d, Succeed: %d, Failed: %d',
            $message->getDays(),
            $succeed,
            $failed,
        );
    }
}
