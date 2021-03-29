<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 */
class Admin
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adminname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $maildmin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="admin")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAdminname()
    {
        return $this->adminname;
    }

    /**
     * @param mixed $adminname
     */
    public function setAdminname($adminname): void
    {
        $this->adminname = $adminname;
    }

    /**
     * @return mixed
     */
    public function getMaildmin()
    {
        return $this->maildmin;
    }

    /**
     * @param mixed $maildmin
     */
    public function setMaildmin($maildmin): void
    {
        $this->maildmin = $maildmin;
    }


    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setAdmin($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getAdmin() === $this) {
                $product->setAdmin(null);
            }
        }

        return $this;
    }
}
