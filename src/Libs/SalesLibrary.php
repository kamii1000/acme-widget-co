<?php


namespace App\Libs;


class SalesLibrary
{
    private $dataLibrary;

    public function __construct(DataLibrary $dataLibrary)
    {
        $this->dataLibrary = $dataLibrary;
    }

    public function getSubTotal($orderedProducts)
    {
        $subtotal = 0;
        foreach ($orderedProducts as $orderedProduct) {
            $subtotal += $orderedProduct['subtotal'];
        }
        return $subtotal;
    }

    public function getShippingCost($subtotal)
    {
        $shippingRules = $this->dataLibrary->getShippingRules();
        $shippingCost = 0;
        if ($subtotal <= 0) {
            return $shippingCost;
        }
        foreach ($shippingRules as $shippingRule) {
            $min_order = floatval($shippingRule['min_order']);
            $max_order = floatval($shippingRule['max_order']);
            if (intval($subtotal) >= intval($min_order)
                && intval($subtotal) <= intval($max_order)) {
                $shippingCost = $shippingRule['cost'];
            }
        }
        return $shippingCost;
    }

    public function applyPromotions($orderedProducts)
    {
        $promotions = $this->dataLibrary->getPromotions();
        foreach ($promotions as $promotion) {
            $start_date_obj = new \DateTime($promotion['start_date']);
            $end_date_obj = new \DateTime($promotion['end_date']);
            if ($start_date_obj <= new \DateTime('now') && $end_date_obj >= new \DateTime('now')) {

                if ($orderedProducts[$promotion['if_product_code']]['quantity'] >= $promotion['if_min_order']
                    && $orderedProducts[$promotion['then_discounted_product']]['quantity'] > 0
                    && (
                        (
                            $promotion['if_product_code'] == $promotion['then_discounted_product']
                            && $orderedProducts[$promotion['then_discounted_product']]['quantity'] > $promotion['if_min_order']
                        ) ||
                        ($promotion['if_product_code'] != $promotion['then_discounted_product'])
                    )
                ) {

                    $quantityToDiscount = $orderedProducts[$promotion['then_discounted_product']]['quantity'] > $promotion['then_discounted_product_quantity'] ? $promotion['then_discounted_product_quantity'] : $orderedProducts[$promotion['then_discounted_product']]['quantity'];
                    $orderedProducts[$promotion['then_discounted_product']]['discount'] = ($quantityToDiscount * $orderedProducts[$promotion['then_discounted_product']]['price']) / 100 * $promotion['then_discount_percentage'];
                    $orderedProducts[$promotion['then_discounted_product']]['subtotal'] = $orderedProducts[$promotion['then_discounted_product']]['subtotal'] - $orderedProducts[$promotion['then_discounted_product']]['discount'];
                    break;

                }

            }
        }
        return $orderedProducts;
    }
}