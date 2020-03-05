<?php

namespace App\Entity;

use App\Entity\Traits\CreateTrait;
use App\Entity\Traits\EditTrait;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CampaignRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Campaign implements JsonSerializable
{
    use CreateTrait;
    use EditTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @var string
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}
