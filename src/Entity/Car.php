<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CarRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Car
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $coverImage;

    /**
     * @ORM\Column(type="integer")
     */
    private $mileage;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $oldOwner;

    /**
     * @ORM\Column(type="integer")
     */
    private $engineCc;

    /**
     * @ORM\Column(type="integer")
     */
    private $enginePower;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $fuel;

    /**
     * @ORM\Column(type="integer")
     */
    private $yearRelease;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $transmission;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $options;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="car")
     */
    private $images;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * Function that generates automatically the slug for the Car entity
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function initializeSlug(){
        if(empty($this->slug)){
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->brand." ".$this->model." ".rand());
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function setMileage(int $mileage): self
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getOldOwner(): ?int
    {
        return $this->oldOwner;
    }

    public function setOldOwner(int $oldOwner): self
    {
        $this->oldOwner = $oldOwner;

        return $this;
    }

    public function getEngineCc(): ?int
    {
        return $this->engineCc;
    }

    public function setEngineCc(int $engineCc): self
    {
        $this->engineCc = $engineCc;

        return $this;
    }

    public function getEnginePower(): ?int
    {
        return $this->enginePower;
    }

    public function setEnginePower(int $enginePower): self
    {
        $this->enginePower = $enginePower;

        return $this;
    }

    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    public function setFuel(string $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getYearRelease(): ?int
    {
        return $this->yearRelease;
    }

    public function setYearRelease(int $yearRelease): self
    {
        $this->yearRelease = $yearRelease;

        return $this;
    }

    public function getTransmission(): ?string
    {
        return $this->transmission;
    }

    public function setTransmission(string $transmission): self
    {
        $this->transmission = $transmission;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOptions(): ?string
    {
        return $this->options;
    }

    public function setOptions(string $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setCar($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getCar() === $this) {
                $image->setCar(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
