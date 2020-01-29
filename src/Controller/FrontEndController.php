<?php


namespace App\Controller;

use App\Libs\DataLibrary;
use App\Libs\SalesLibrary;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class FrontEndController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param DataLibrary $dataLibrary
     * @return Response
     */
    public function index(DataLibrary $dataLibrary)
    {
        try {
            $dataLibrary->initializeData();
            return $this->render('FrontEnd/index.html.twig', [
                'products' => $dataLibrary->getProducts(),
                'has_error' => false,
                'error_msg' => ""
            ]);
        } catch (\Exception $exc) {
            return $this->render('FrontEnd/index.html.twig', [
                'has_error' => true,
                'error_msg' => $exc->getMessage()
            ]);
        }
    }

    /**
     * @Route("/process-order", name="process-order")
     * @param Request $request
     * @param SalesLibrary $salesLibrary
     * @param DataLibrary $dataLibrary
     * @return Response
     * @throws \Exception
     */
    public function processOrder(Request $request, SalesLibrary $salesLibrary, DataLibrary $dataLibrary)
    {
        sleep(1);
        $dataLibrary->initializeData();
        $products = $dataLibrary->getProducts();
        $orderedProducts = [];
        $orderBilling = [
            'subtotal' => 0,
            'total' => 0,
            'shipping' => 0,
            'products' => $orderedProducts
        ];
        foreach ($products as $product) {
            $quantity = intval($request->request->get($product['code'], 0));
            $orderedProducts[$product['code']] = [
                'quantity' => $quantity,
                'price' => $product['price'],
                'discount' => 0,
                'subtotal' => $product['price'] * $quantity
            ];
        }
        $orderedProducts = $salesLibrary->applyPromotions($orderedProducts);
        $orderBilling['subtotal'] = $salesLibrary->getSubTotal($orderedProducts);
        $orderBilling['shipping'] = $salesLibrary->getShippingCost($orderBilling['subtotal']);

        $orderBilling['total'] = $orderBilling['subtotal'] + $orderBilling['shipping'];

        setlocale(LC_MONETARY, "en_US");
        $orderBilling['subtotal'] = money_format('%i', $orderBilling['subtotal']);
        $orderBilling['shipping'] = money_format('%i', $orderBilling['shipping']);
        $orderBilling['total'] = money_format('%i', $orderBilling['total']);
        return $this->json($orderBilling);
    }
}