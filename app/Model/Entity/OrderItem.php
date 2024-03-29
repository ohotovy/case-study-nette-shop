<?php
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\DTO\ProductBasketInsert;
use App\DTO\ProductBasketIncrease;

#[ORM\Entity]
#[ORM\Table(name: 'order_product')]
class OrderItem
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    #[ORM\Column]
    private int $qty = 1;
    #[ORM\Column(name: 'unit_price', type: Types::DECIMAL, precision: 10, scale: 2)]
    private float $unitPrice;

    // Needed separately for checking in basket, if there should be new record or we're adding
    // a new record (i.e. we're adding a new product to basket) or not (i.e. we're increasing quantity)
    #[ORM\Column(name: 'order_id')]
    private int $orderId;
    #[ORM\Column(name: 'product_id')]
    private int $productId;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private Order $order;
    #[ORM\ManyToOne(inversedBy: 'inOrders')]
    private Product $product;

    // getters

    public function getId() : int
    {
        return $this->id;
    }

    public function getProductName() : string
    {
        return $this->product->getName();
    }

    public function getProductPrice() : string
    {
        return $this->product->getPrice();
    }

    public function getQuantity() : int
    {
        return $this->qty;
    }

    public function getPrice() : float
    {
        return $this->unitPrice;
    }

    public function getTotalPrice() : float
    {
        return $this->unitPrice * $this->qty;
    }

    // setters

    public function addNewToBasket(ProductBasketInsert $data) : void
    {
        $this->product = $data->product;
        $this->order = $data->order;
        $this->qty = $data->qty;
        $this->unitPrice = $this->getProductPrice();
    }

    public function addBasketIncrease(ProductBasketIncrease $data) : void
    {
        $this->qty += $data->qty;
    }

    public function setBasketValue(ProductBasketIncrease $data) : void
    {
        $this->qty = $data->qty;
    }
}