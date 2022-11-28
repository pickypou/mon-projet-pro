<?php

namespace App\Classe;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManagerInterface;

class Cart
{


    private $entityManager;

   
    private $requestStack;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->requestStack = $requestStack; $this->entityManager = $entityManager;

    }
    public function add($id)
    {
        $session = $this->requestStack->getSession();
        $this->session =$session;

        $cart = $this->session->get('cart', []);


        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);
    }


    public function get()

    {
        $session = $this->requestStack->getSession();
        $this->session =$session;

        return  $this->session->get('cart');
    }

    public function remove()

    {
        $session = $this->requestStack->getSession();
        $this->session =$session;

        return  $this->session->remove('cart');
    }

    public function delete($id)
    {
        $session = $this->requestStack->getSession();
        $this->session =$session;
        $cart = $this->session->get('cart', []);

        unset($cart[$id]);

        return $this->session->set('cart', $cart);
    }

    public function getFull()
    {
        $cartComplete = [];

        if ($this->get()) {
            foreach ($this->get() as $id => $quantity) {
                $product_object = $this->entityManager->getRepository(Product::class)->findOneById($id);

                if (!$product_object) {
                    $this->delete($id);
                    continue;
                }

                $cartComplete[] = [
                    'product' => $product_object,
                    'quantity' => $quantity
                ];
            }
        }

        return $cartComplete;
    }
    public function decrease($id)
    {
        $session = $this->requestStack->getSession();
        $this->session =$session;
        $cart = $this->session->get('cart', []);

        if ($cart[$id] > 1) {
            $cart[$id]--;
        } else {
            unset($cart[$id]);
        }

        return $this->session->set('cart', $cart);
    }




}
