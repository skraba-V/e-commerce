<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProdAnswerRepository;
use App\Repository\ProdQuestionRepository;
use App\Repository\ProductRepository;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class StaticController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'products' => $productRepository->findBy(['hidden' => 0]),
        ]);
    }

    /**
     * @Route("/showproducts", name="app_homeproducts")
     */
    public function homeproducts(ProductRepository $productRepository): Response
    {
        return $this->render('home/home_products.html.twig', [
            'products' => $productRepository->findBy(['hidden' => 0]),
        ]);
    }



    /**
     * @Route("/contact", name="app_contact")
     */
    public function contact(): Response
    {
        return $this->render('home/contact.html.twig'
        );
    }

    /**
     * @Route("/search/", name="app_search")
     */
    public function search(ManagerRegistry $doctrine, Request $request): Response
    {
        $search = $request->query->get('search');
        //dd($search);
        $result = $doctrine->getRepository(Product::class)->findBy(array('name' => $search, 'hidden' => 0));
        // dd($result);
        if($result){
            return $this->render('home/home_products.html.twig', ['products' => $result]);
        }else{
            $this->addFlash('notice', 'Category empty or not found.');
            return $this->redirectToRoute('app_home');
        }
    }

    /**
     * @Route("/show/{id}", name="app_product_show", methods={"GET"})
     */
    public function showprod($id, Product $product, ReviewRepository $revrep, ProdQuestionRepository $prodquest, ProdAnswerRepository $prodans): Response
    {
        
        $review = $revrep->findBy(['fk_productId' => $id]);
        $rating = 0;
        $iter = 0;
        foreach($review as $val){
            $rating += $val->getRating();
            $iter += 1;
        }
        if($rating > 0){
            $avgrating = ceil($rating / $iter);
        }
        else{
            $avgrating = 0;
        }

        $questions = $prodquest->findBy(['fk_productId'=> $id]);
            $answersForQuestions = array();
            if ($questions){
                foreach($questions as $value){
                    $questionId = $value->getId();
                    $answers = $prodans->findBy(["fk_questionId"=>$questionId]);
                    if($answers != null){
                        array_push($answersForQuestions, $answers);
                    } else {
                        array_push($answersForQuestions, null);
                    }
                }
            }else {
                $answersForQuestions = 0;
            }
        // if(count($answersForQuestions) == 0 ){
        //     $answersForQuestions = 0;
        // }
        // dd($answersForQuestions);
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'reviews' => $review,
            'avg' => $avgrating,
            'questions' => $questions,
            'answers'=> $answersForQuestions,
        ]);
    }

    /**
     * @Route("/filter/", name="app_filter")
     */
    public function filter(ManagerRegistry $doctrine, Request $request): Response
    {
        $search = $request->query->get('filter');
        //dd($search);
        $result = $doctrine->getRepository(Product::class)->findBy(array('fk_category' => $search, 'hidden' => 0));
        // dd($result);
        if($result){
            return $this->render('home\home_products.html.twig', ['products' => $result]);
        }else{
            $this->addFlash('notice', 'Category empty or not found.');
            return $this->redirectToRoute('app_home');
        }
    }
}
