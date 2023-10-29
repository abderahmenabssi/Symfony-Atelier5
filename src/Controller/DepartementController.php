<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Form\DepartementType;
use App\Repository\DepartementRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepartementController extends AbstractController
{
    #[Route('/departement', name: 'app_departement')]
    public function index(): Response
    {
        return $this->render('departement/index.html.twig', [
            'controller_name' => 'DepartementController',
        ]);
    }
    #[Route('/showdepartement', name: 'showdepartement')]
    public function showdepartement(DepartementRepository $departementRepository): Response
    {   $departement=$departementRepository->findAll();
        return $this->render('Departement/showdepartement.html.twig', [
            'departement'=>$departement
        ]);
    }

    #[Route('/adddepartement', name: 'adddepartement')]
    public function adddepartement(ManagerRegistry $managerRegistry,Request $req): Response
    {
        $em=$managerRegistry->getManager();
        $departement = new Departement();    
        $form=$this->createForm(DepartementType::class,$departement);
        $form->handleRequest($req);
        if($form->isSubmitted()and $form -> isValid()){

        $em->persist($departement);
        $em->flush();
        return $this->redirectToRoute('showdepartement');
    }
    return $this->renderForm('departement/adddepartement.html.twig', [
        'f'=>$form
    ]);}
    #[Route('edit1/{id}=', name: 'edit1')]
    public function edit1( $id ,DepartementRepository $repository1,ManagerRegistry $ManagerRegistry,Request $req):Response
    {
      //var_dump($id) . die();
      $en =$ManagerRegistry->getManager();
      $dataid=$repository1->find($id);
      $form=$this->createform(DepartementType::class,$dataid);
      $form->handleRequest($req);
    if ($form->isSubmitted() and $form->isValid())
    {
    
    $en->persist($dataid);
    $en->flush();
    return $this->redirectToRoute("showdepartement");
    }
        return $this->renderForm("departement/edit.html.twig",[
            'formedit' => $form]);
    }
    #[Route('delete1/{id}', name: 'delete1')]
    public function delete1($id,DepartementRepository $repository2,ManagerRegistry $ManagerRegistry,Request $req): Response
    { $em =$ManagerRegistry->getManager();
        $fin=$repository2->find($id);
        $em->remove($fin);
        $em->flush();
        return $this->redirectToRoute("showdepartement");
    }

    



}
