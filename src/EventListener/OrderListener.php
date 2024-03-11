<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Order;

final class OrderListener
{
    public function prePersist(Order $order): void
    {
        $order->setReference(str_replace(['.', ','], '', (string)microtime(true)));
    }
}
