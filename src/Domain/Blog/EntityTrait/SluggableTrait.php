<?php

namespace App\Domain\Blog\EntityTrait;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\String\Slugger\SluggerInterface;

trait SluggableTrait
{
    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Regex(pattern="/^[a-z0-9-]+$/")
     */
    private $slug;

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    abstract public function __toString(): string;

    public function computeSlug(SluggerInterface $slugger): void
    {
        if (empty($this->slug) || '-' === $this->slug) {
            $this->slug = (string) $slugger->slug((string) $this)->lower();
        }
    }
}
