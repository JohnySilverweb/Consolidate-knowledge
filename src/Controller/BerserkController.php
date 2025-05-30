<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Berserk;
use App\Form\BerserkType;
use App\Repository\BerserkRepository;

final class BerserkController extends AbstractController
{
    #[Route('/', name: 'berserk_index')]
    public function index(): Response
    {
        return $this->render('berserk/index.html.twig');
    }
    
    #[Route('/berserk/form', name: 'berserk_form')]
    public function form(Request $request, EntityManagerInterface $em): Response
    {
        $berserk = new Berserk();
        $form = $this->createForm(BerserkType::class, $berserk);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($berserk);
            $em->flush();
            return $this->redirectToRoute('app_berserk');
        }

        return $this->render('berserk/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
 
    #[Route('/berserk/cards', name: 'berserk_cards')]
    public function cards(BerserkRepository $berserkRepository): Response
    {
        return $this->render('berserk/cards.html.twig', [
            'berserk' => $berserkRepository->findAll(),
        ]);
    }
}
