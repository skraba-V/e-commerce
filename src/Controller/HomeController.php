<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Product;
use App\Entity\Review;
use App\Entity\ShoppingCart;
use App\Entity\User;
use App\Form\LocationType;
use App\Form\ReviewType;
use App\Form\UserType;
use App\Repository\ProductRepository;
use App\Repository\ReviewRepository;
use App\Repository\ShoppingCartRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;

/**
 * @Route("/home")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/cart/{id}", name="app_cart_add", methods={"GET"})
     */
    public function addCart($id, Product $product, ShoppingCartRepository $shopcart, Request $request): Response
    {
        $amount = $request->query->get('amount');
        $stock = $product->getStock();
        // dd($stock);
        if($stock - $amount < 0){
            $this->addFlash('notice', 'Ordering amount is bigger than stock.');
            return $this->redirectToRoute('app_product_show', ['id' => $id]);
        }
        else{
            $userid = $this->getUser();
            $cart = $shopcart->findOneBy(array('fk_userId' => $userid, 'fk_productId' => $id, 'fk_order' => NULL));
            // dd($cart);
            if($cart){
                $oldamount = $cart->getAmount();
                $newamount = $oldamount + $amount;
                if($stock - $newamount < 0){
                    $this->addFlash('notice', 'The new total ordering amount would be bigger than stock.');
                    return $this->redirectToRoute('app_product_show', ['id' => $id]);
                }
                else{
                    $cart->setAmount($newamount);
                    $shopcart->add($cart);
                }
            }
            else{
                $cart = new ShoppingCart();
                $cart->setFkUserId($this->getUser());
                $cart->setFkProductId($product);
                $cart->setAmount($amount);
                // dd($cart);
                $shopcart->add($cart);
            }

            return $this->redirectToRoute('app_product_show', ['id' => $id]);
        }
    }

    /**
     * @Route("/cart", name="app_cart_show", methods={"GET"})
     */
    public function showCart(ShoppingCartRepository $shopcart): Response
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

        return $this->render('home/cart.html.twig', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    /**
     * @Route("/cart/delete/{id}", name="app_cart_delete", methods={"GET"})
     */
    public function deleteCartItem(ShoppingCartRepository $shopcart, $id): Response
    {
        $userid = $this->getUser();
        // dd($userid);
        $item = $shopcart->find($id);
        // dd($item);
        $shopcart->remove($item);

        return $this->redirectToRoute('app_cart_show');
    }

    /**
     * @Route("/order", name="app_cart_order") // try "/cart/order" for an error
     */
    public function orderCart(ShoppingCartRepository $shopcart): Response
    {
        $userid = $this->getUser();
        $items = $shopcart->findBy(['fk_userId' => $userid, 'fk_order' => NULL]);
        $error = false;
        foreach($items as $val){
            $amount = $val->getAmount();
            $stock = $val->getFkProductId()->getStock();
            if($stock - $amount < 0){
                $error = true;
                break;
            }

        }

        if($error){
            $this->addFlash('notice', 'Order amount is bigger than stock! Program anything to do something about this');
            return $this->redirectToRoute('app_home');
        }
        else{
            return $this->redirectToRoute('app_paypal');
        }
    }

    /**
     * @Route("/review/{id}", name="app_product_review")
     */
    public function reviewProduct($id, Request $request, ProductRepository $product, ReviewRepository $revrep): Response
    {
        $review = new Review();
        $text = $request->query->get('review');
        $rating = $request->query->get('rating3');
        $user = $this->getUser();
        $prodid = $product->find($id);
        $review->setFkUserId($user);
        $review->setFkProductId($prodid);
        $review->setRating($rating);
        $review->setReview($text);
        $revrep->add($review);

        return $this->redirectToRoute('app_product_show', ['id' => $id]);
    }

    /**
     * @Route("/review/{id}/delete/{prodid}", name="app_review_delete")
     */
    public function deleteReview($id, Request $request, ReviewRepository $revrep, $prodid): Response
    {
        $review = $revrep->find($id);
        $revrep->remove($review);

        return $this->redirectToRoute('app_product_show', ['id' => $prodid]);
    }

    /**
     * @Route("/show", name="app_user_show", methods={"GET"})
     */
    public function show(): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/edit", name="app_user_edit", methods={"GET", "POST"})
     */
    public function edit(FileUploader $fileUploader, Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
        $loc = new Location();
        $loc->setZip($user->getFkLocation()->getZip());
        $loc->setCity($user->getFkLocation()->getCity());
        $loc->setCountry($user->getFkLocation()->getCountry());

        $form = $this->createForm(UserType::class, $user);
        $formloc = $this->createForm(LocationType::class, $loc);
        $form->handleRequest($request);
        $formloc->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // handle location (available as fk in user entity)
            
            $country = $formloc->get('country')->getData();
            $city = $formloc->get('city')->getData();
            $zip = $formloc->get('zip')->getData();
            $location = $doctrine->getRepository(Location::class)->findOneBy(array('country' => $country, 'city' => $city, 'zip' => $zip));
            // if country is found in location table (1st column), loop through and check if city and zip also exist
            if(!$location){
                $location = new Location();
                $location->setCity($city);
                $location->setCountry($country);
                $location->setZip($zip);

                $entityManager->persist($location);
                $entityManager->flush();
            }

            $pictureFile = $form->get('pictureUrl')->getData();
            //pictureUrl is the name given to the input field
            if ($pictureFile) {
                $pictureFileName = $fileUploader->upload($pictureFile);
                $user->setPicture($pictureFileName);
            }
            $user->setFkLocation($location);
            $userRepository->add($user);
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'formloc' => $formloc,
        ]);
    }

}
