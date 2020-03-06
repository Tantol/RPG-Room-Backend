<?php

namespace App\Entity\Traits;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;
use Exception;

trait EditTrait
{
    /**
     * @ORM\Column(type="datetime")
     *
     * @var DateTime
     */
    private $editedAt;

    public function getEditedAt(): DateTime
    {
        return $this->editedAt;
    }

    public function setEditedAt(DateTime $editedAt): self
    {
        $this->editedAt = $editedAt;

        return $this;
    }

    /**
     * @throws Exception
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->editedAt = new DateTime('now', new DateTimeZone('Europe/Warsaw'));
    }
}
