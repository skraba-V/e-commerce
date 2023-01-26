<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\ProdAnswer;
use App\Form\ProdAnswerType;
use App\Entity\ProdQuestion;
use App\Form\ProdQuestionType;
use App\Repository\ProdAnswerRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ProdQuestionRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/answer")
 */
class ProdAnswerController extends AbstractController
{
    /**
     * @Route("/", name="app_answer_index")
     */
    public function index(ProdAnswerRepository $prodAnswerRepository): Response
    {
        return $this->render('prod_answer/index.html.twig', [
            'prod_answers' => $prodAnswerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="app_prod_answer_new")
     */
    public function new($id, Request $request, ProdAnswerRepository $prodAnswerRepository, ManagerRegistry $doctrine,ProdQuestionRepository $prodQuestionRepository): Response
    {
        $prodAnswer = new ProdAnswer();
        $user = $this->getUser();
        $time = new \DateTime('now');
        $product = $doctrine->getManager()->getRepository(Product::class)->find($id);
        $form = $this->createForm(ProdAnswerType::class, $prodAnswer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $question = $prodQuestionRepository->find($id); 
            $prodAnswer->setFkUserId($user);
            $prodAnswer->setAnswerDate($time);
            $prodAnswer->setFkQuestionId($question);
            $prodAnswerRepository->add($prodAnswer);
            return $this->redirectToRoute('app_product_show', ['id' => $question->getFkProductId()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prod_answer/new.html.twig', [
            'prod_answer' => $prodAnswer,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/show/{id}", name="app_prod_answer_show")
     */
    public function show(ProdAnswer $prodAnswer): Response
    {
        return $this->render('prod_answer/show.html.twig', [
            'prod_answer' => $prodAnswer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_prod_answer_edit")
     */
    public function edit(Request $request, ProdAnswer $prodAnswer, ProdAnswerRepository $prodAnswerRepository): Response
    {
        $form = $this->createForm(ProdAnswerType::class, $prodAnswer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prodAnswerRepository->add($prodAnswer);
            return $this->redirectToRoute('app_answer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prod_answer/edit.html.twig', [
            'prod_answer' => $prodAnswer,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_prod_answer_delete", methods={"POST"})
     */
    public function delete(Request $request, ProdAnswer $prodAnswer, ProdAnswerRepository $prodAnswerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prodAnswer->getId(), $request->request->get('_token'))) {
            $prodAnswerRepository->remove($prodAnswer);
        }

        return $this->redirectToRoute('app_answer_index', [], Response::HTTP_SEE_OTHER);
    }
}
