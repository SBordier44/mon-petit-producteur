<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Farm;
use App\Repository\FarmRepository;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

final class FarmListener
{
    public function __construct(
        private readonly SluggerInterface $slugger,
        private readonly FarmRepository $farmRepository
    ) {
    }

    public function preUpdate(Farm $farm, PreUpdateEventArgs $eventArgs): void
    {
        if ($eventArgs->hasChangedField('name')) {
            $this->setSlug($farm);
        }
    }

    public function prePersist(Farm $farm): void
    {
        $this->setSlug($farm);
    }

    private function setSlug(Farm $farm): void
    {
        $slug = $this->farmRepository->getNextSlug($this->slugger->slug($farm->getName())->lower()->toString());
        $farm->setSlug($slug);
    }
}
