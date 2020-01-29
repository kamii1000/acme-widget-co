<?php


namespace App\Libs;


use Symfony\Component\Config\Definition\Exception\Exception;

class DataLibrary
{
    private $products;
    private $shippingRules;
    private $promotions;

    private $kernelProjectDir;

    public function __construct($kernelProjectDir)
    {
        $this->kernelProjectDir = $kernelProjectDir;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function getShippingRules()
    {
        return $this->shippingRules;
    }

    public function getPromotions()
    {
        return $this->promotions;
    }

    public function initializeData()
    {
        $this->loadInitialProducts();
        $this->loadInitialShippingRules();
        $this->loadInitialPromotions();
    }

    private function loadInitialProducts()
    {
        $productsStr = file_get_contents($this->kernelProjectDir . "/demo_data/products.json");
        $this->products = json_decode($productsStr, true);
    }

    private function loadInitialShippingRules()
    {
        $shippingRulesStr = file_get_contents($this->kernelProjectDir . "/demo_data/shipping_rules.json");
        $this->shippingRules = $this->validateShippingRules(json_decode($shippingRulesStr, true));
    }

    private function loadInitialPromotions()
    {
        $shippingRulesStr = file_get_contents($this->kernelProjectDir . "/demo_data/promotions.json");
        $this->promotions = json_decode($shippingRulesStr, true);
    }

    private function validateShippingRules($shippingRules)
    {
        // Validate Shipping Rules
        foreach ($shippingRules as $index => $shippingRule) {
            if ($shippingRule['min_order'] > $shippingRule['max_order']) {
                throw new Exception("Invalid shipping rule, min_order must be less than or equal to max_order.");
            }
        }
        for ($i = 0; $i < count($shippingRules); $i++) {
            $currentRule = $shippingRules[$i];
            for ($j = $i + 1; $j < count($shippingRules); $j++) {
                $nextRule = $shippingRules[$j];
                if (
                    ($currentRule['min_order'] >= $nextRule['min_order']
                        && $currentRule['min_order'] <= $nextRule['max_order'])
                    ||
                    ($currentRule['max_order'] >= $nextRule['min_order']
                        && $currentRule['max_order'] <= $nextRule['max_order'])
                ) {
                    throw new Exception("Invalid shipping rule, there is a conflict in shipping rules.");
                }
            }
        }
        // Sort Shipping Rules
        for ($i = 0; $i < count($shippingRules); $i++) {
            $min = $i;
            for ($j = $i + 1; $j < count($shippingRules); $j++) {
                if ($shippingRules[$min]['min_order'] > $shippingRules[$j]['min_order']) {
                    $min = $j;
                }
            }
            $temp = $shippingRules[$min];
            $shippingRules[$min] = $shippingRules[$i];
            $shippingRules[$i] = $temp;
        }
        return $shippingRules;
    }
}