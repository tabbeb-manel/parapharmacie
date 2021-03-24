<?php

namespace App\Entity;

use App\Repository\RoutineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=RoutineRepository::class)
 * @UniqueEntity( fields={"nameRoutine"}, message="ce nom existe déjà.")
 */
class Routine
{
    const Active= 'Activée';
    const Desactive= 'Désactivée';
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $nameRoutine;

    /**
     * @ORM\Column(type="string",columnDefinition="ENUM('Activée', 'Désactivée')", length=255, nullable=true)
     */
    private $notification;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="routines")
     */
    private $products;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="routines")
     */
    private $user;



    public function __construct()
    {
        $this->products = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameRoutine(): ?string
    {
        return $this->nameRoutine;
    }

    public function setNameRoutine(string $nameRoutine): self
    {
        $this->nameRoutine = $nameRoutine;

        return $this;
    }

    public function getNotification(): ?string
    {
        return $this->notification;
    }

    /**
     * @param mixed $notification
     */
    public function setNotification($notification): void
    {
        $this->notification = $notification;
    }



    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @param ArrayCollection $products
     */
    public function setProducts(ArrayCollection $products): void
    {
        $this->products = $products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
