<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\ShoppingCartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\ShipCompRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class PaypalController extends AbstractController
{
    /**
     * @Route("/paypal", name="app_paypal")
     */
    public function index(ShoppingCartRepository $shopcart): Response
    {
        $userid = $this->getUser();
        // dd($userid);
        $items = $shopcart->findBy(['fk_userId' => $userid, 'fk_order' => NULL]);
        // dd($items);
        $total = 0;
        foreach($items as $val){
            $price = $val->getFkProductId()->getPrice();
            $discount = $val->getFkProductId()->getDiscount();
            $amount = $val->getAmount();
            $total += $price * ((100-$discount)/100) * $amount;
        }

        return $this->render('paypal/index.html.twig', [
            'total' => $total,
        ]);
    }

    /**
     * @Route("/paypal/success", name="app_paypal_success")
     */
    public function successMsg(ShoppingCartRepository $shopcart, ShipCompRepository $shipcomp, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $user = $this->getUser();
        // dd($userid);
        $items = $shopcart->findBy(['fk_userId' => $user, 'fk_order' => NULL]);
        // dd($items);
        $order = new Order;
        $total = 0;
        foreach($items as $val){
            $price = $val->getFkProductId()->getPrice();
            $discount = $val->getFkProductId()->getDiscount();
            $amount = $val->getAmount();
            $product = $val->getFkProductId();
            $stock = $product->getStock();
            $product->setStock($stock - $amount);
            $total += $price * ((100-$discount)/100) * $amount;
            $val->setFkOrder($order);
        }
        // dd($total);

        $shipping = $shipcomp->find(1);
        $order->setFkShippingComp($shipping);
        $order->setFkUserId($user);
        $date = new \DateTime('now');
        $order->setOrderDate($date);
        $order->setTotal($total);
        $entityManager->persist($order);
        $entityManager->flush();

        $usermail = $user->getEmail();
        $email = (new Email())
            ->from('symfonymailer2022@gmail.com')
            ->to($usermail)
            ->subject('Time for Symfony Mailer!')
            ->text('This will be your invoice.. at some point.')
            // ->html('<p>See Twig integration for better HTML integration!</p>');
            ;
        $mailer->send($email);

        $this->addFlash('success', 'Success! Thank you for your payment.');
        return $this->redirectToRoute('app_home');
    }

    /**
     * @Route("/paypal/error", name="app_paypal_error")
     */
    public function errorMsg(): Response
    {
        $this->addFlash('notice', 'Something went wrong. Please check your billing details and try again.');
        return $this->redirectToRoute('app_home');
    }
}