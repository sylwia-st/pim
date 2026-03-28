<?php
declare(strict_types = 1);

namespace App\EntityListener;

use App\Domain\Event\ProductPriceChanged;
use App\Entity\Product;
use App\Entity\PriceHistory;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class ProductListener
{
    public function __construct(
        private EventDispatcherInterface $dispatcher,
        private MessageBusInterface $messageBus,
    ) {
    }

    /**
     * @throws \Symfony\Component\Messenger\Exception\ExceptionInterface
     */
    public function postUpdate(Product $product, LifecycleEventArgs $args)
    : void {
        $em        = $args->getObjectManager();
        $uow       = $em->getUnitOfWork();
        $changeset = $uow->getEntityChangeSet($product);
        if (!isset($changeset['price'])) {
            return;
        }

        [$oldPrice, $newPrice] = $changeset['price'];
        $oldPrice = number_format((float)$oldPrice, 3, '.', '');
        $newPrice = number_format((float)$newPrice, 3, '.', '');
        if ($oldPrice === $newPrice) {
            return;
        }
        $history = new PriceHistory();
        $history->setProduct($product);
        $history->setOldPrice($oldPrice);
        $history->setNewPrice($newPrice);
        $history->setTimestamp(time());
        $product->addPriceHistory($history);
        $em->persist($history);
        $em->flush();

        $this->dispatcher->dispatch(new ProductPriceChanged($product, $oldPrice, $newPrice));
        $event = new ProductPriceChanged($product, $oldPrice, $newPrice);
        $this->messageBus->dispatch($event);
    }
}
