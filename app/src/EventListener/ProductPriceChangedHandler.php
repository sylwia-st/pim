<?php
declare(strict_types = 1);

namespace App\EventListener;

use App\Domain\Event\ProductPriceChanged;
use Psr\Log\LoggerInterface;

class ProductPriceChangedHandler
{

    public function __construct(private LoggerInterface $logger)
    {
    }

    public function __invoke(ProductPriceChanged $event)
    {
        $product = $event->getProduct();
        $this->logger->info(sprintf(
            'Product price changed. Product name: %s (from: %s to: %s)',
            $product->getName(),
            $event->getOldPrice(),
            $event->getNewPrice()
        ));

    }
}
