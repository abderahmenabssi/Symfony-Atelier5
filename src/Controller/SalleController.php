<?php

namespace App\Controller;
use App\Entity\Salle;
use App\Form\SalleType;
use App\Repository\SalleRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SalleController extends AbstractController
{
    #[Route('/salle', name: 'app_salle')]
    public function index(): Response
    {
        return $this->render('salle/index.html.twig', [
            'controller_name' => 'SalleController',
        ]);
    }
    #[Route('/addsalle', name: 'addsalle')]
    public function addsalle(ManagerRegistry $managerRegistry,Request $req): Response
    {
        $em=$managerRegistry->getManager();
        $salle = new Salle();    
        $form=$this->createForm(SalleType::class,$salle);
        $form->handleRequest($req);
        if($form->isSubmitted()and $form -> isValid()){

        $em->persist($salle);
        $em->flush();
        return $this->redirectToRoute('showsalle');
    }
    return $this->renderForm('salle/addsalle.html.twig', [
        'f'=>$form
    ]);}

    #[Route('/showsalle', name: 'showsalle')]
    public function showsalle(SalleRepository $salleRepository): Response
    {   $salle=$salleRepository->findAll();
        return $this->render('salle/showsalle.html.twig', [
            'salle'=>$salle
        ]);
    }
    #[Route('edit/{id}=', name: 'edit')]
    public function edit( $id ,SalleRepository $repository1,ManagerRegistry $ManagerRegistry,Request $req):Response
    {
      //var_dump($id) . die();
      $en =$ManagerRegistry->getManager();
      $dataid=$repository1->find($id);
      $form=$this->createform(SalleType::class,$dataid);
      $form->handleRequest($req);
    if ($form->isSubmitted() and $form->isValid())
    {
    
    $en->persist($dataid);
    $en->flush();
    return $this->redirectToRoute("showsalle");
    }
        return $this->renderForm("salle/edit1.html.twig",[
            'formedit' => $form]);
    }
    #[Route('delete/{id}', name: 'delete')]
        public function delete($id,SalleRepository $repository2,ManagerRegistry $ManagerRegistry,Request $req): Response
        { $en =$ManagerRegistry->getManager();
            $fin=$repository2->find($id);
            $en->remove($fin);
            $en->flush();
            return $this->redirectToRoute("showsalle");
        }
}
