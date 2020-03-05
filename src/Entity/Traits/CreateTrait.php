<?php

namespace App\Entity\Traits;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;
use Exception;

trait CreateTrait
{
    /**
     * @ORM\Column(type="datetime")
     *
     * @var DateTime
     */
    private $createdAt;

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @throws Exception
     */
    public function prePersist()
    {
        $this->createdAt = new DateTime('now', new DateTimeZone('Europe/Warsaw'));
    }
}
