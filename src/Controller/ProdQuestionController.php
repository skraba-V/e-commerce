<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\ProdQuestion;
use App\Form\ProdQuestionType;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ProdQuestionRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/question")
 */
class ProdQuestionController extends AbstractController
{
    /**
     * @Route("/", name="questionIndex")
     */
    public function index(ProdQuestionRepository $productQuestionRepository): Response
    {
        return $this->render('prod_question/index.html.twig', [
            'questions' => $productQuestionRepository->findAll(),
        ]);
    }   

    /**
     * @Route("/new/{id}", name="newQuestion")
     */
    public function new(Request $request, ProdQuestionRepository $prodQuestionRepository,$id, ManagerRegistry $doctrine): Response
    {
        $prodQuestion = new ProdQuestion();
        $user = $this->getUser();
        $time = new \DateTime('now');
        
        $product = $doctrine->getRepository(Product::class)->find($id);
        
        $form = $this->createForm(ProdQuestionType::class, $prodQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            // $user;   
            $prodQuestion->setFkUserId($user);
            $prodQuestion->setFkProductId($product);
            $prodQuestion->setQuestionDate($time);
            $prodQuestionRepository->add($prodQuestion);

            return $this->redirectToRoute('app_product_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prod_question/_form.html.twig', [
            'prod_question' => $prodQuestion,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="showQuestion", methods={"GET"})
     */
    public function show(ProdQuestion $prodQuestion): Response
    {
        return $this->render('prod_question/show.html.twig', [
            'prod_question' => $prodQuestion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_prod_question_edit")
     */
    public function edit(Request $request, ProdQuestion $prodQuestion, ProdQuestionRepository $prodQuestionRepository): Response
    {
        $form = $this->createForm(ProdQuestionType::class, $prodQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prodQuestionRepository->add($prodQuestion);
            return $this->redirectToRoute('questionIndex', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prod_question/edit.html.twig', [
            'prod_question' => $prodQuestion,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_prod_question_delete", methods={"POST"})
     */
    public function delete(Request $request, ProdQuestion $prodQuestion, ProdQuestionRepository $prodQuestionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prodQuestion->getId(), $request->request->get('_token'))) {
            $prodQuestionRepository->remove($prodQuestion);
        }

        return $this->redirectToRoute('questionIndex', [], Response::HTTP_SEE_OTHER);
    }
}
