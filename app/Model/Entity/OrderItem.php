<?php
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'order_product')]
class OrderItem
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private Order $order;
    #[ORM\ManyToOne(inversedBy: 'inOrders')]
    private Product $product;

    #[ORM\Column]
    private int $amount = 1;

    #[ORM\Column(name: 'unit_price', type: Types::DECIMAL, precision: 10, scale: 2)]
    private float $unitPrice;

    public function __construct(
    )
    {
        // $this->order = $order;
        // $this->product = $product;
        // $this->offeredPrice = $product->getCurrentPrice();
    }

    public function getProductName() : string
    {
        return $this->product->getName();
    }

    public function getTotalPrice() : float
    {
        return $this->unitPrice * $this->amount;
    }
}