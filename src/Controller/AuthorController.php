<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AbssiType;
use App\Form\AuthorType;
use App\Form\MinmaxType;
use App\Form\SearchType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Form;

class AuthorController extends AbstractController
{

    public $authors = array(
        array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
        array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
        array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
        );
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }



    #[Route('/showauthor/{name}', name: 'app_showauthor')]
    public function showauthor($name): Response
    {
        return $this->render('author/show.html.twig', [
            'name'=>$name
        ]);
    }

    #[Route('/showtableauthor', name: 'app_showtableauthor')]
    public function showtableauthor(): Response
    {
        
            return $this->render('author/list.html.twig', [
                'author'=>$this->authors
            ]);
    }
    #[Route('/showauthorbyid/{id}', name: 'showauthorbyid')]
    public function showauthorbyid($id): Response
    {

       // var_dump($id).die();
        $author=null;
        foreach($this->authors as $authorD){
            if($authorD['id'] == $id){
                $author=$authorD;
            }
        }
        //var_dump($author).die();



        return $this->render('author/showauthorbyid.html.twig', [
            'author'=>$author
        ]);
    }

    #[Route('showdbauthor', name: 'showdbauthor')]
    public function showbdbauthor(AuthorRepository $authorRepository,Request $req): Response
    {   $authors=$authorRepository->orderbyemail(); //la liste des auteurs par ordre alphabétique des adresses email
        $form = $this->createForm(AbssiType::class);
        $form->handleRequest($req);
       if ($form ->isSubmitted()){
        $min =$form->get('min')->getData(); //valeur min de nbrLivre
        $max =$form->get('max')->getData(); ////valeur max de nbrLivre
       
      $authors=$authorRepository->minmax($min, $max); //l'autheur qui a nbrLivre entre min et max 
       }
        return $this->render('author/showdbauthor.html.twig', [
            'author' => $authors,
            'f' =>$form->createView(),
        
        ]);
    }

    
    #[Route('/addformauthor', name: 'addformauthor')]
    public function addformauthor(ManagerRegistry $managerRegistry,Request $req): Response
    {
        $em=$managerRegistry->getManager();
        $author = new Author();    
        $form=$this->createForm(AuthorType::class,$author);
        $form->handleRequest($req);
        if($form->isSubmitted()and $form -> isValid()){

        $em->persist($author);
        $em->flush();
        return $this->redirectToRoute('showdbauthor');
    }



        return $this->renderForm('author/addformauthor.html.twig', [
            'f'=>$form
        ]);
    }
    #[Route('editauthor/{id}=', name: 'editauthor')]
public function editauthor( $id ,AuthorRepository $repository1,ManagerRegistry $ManagerRegistry,Request $req):Response
{
  //var_dump($id) . die();
  $en =$ManagerRegistry->getManager();
  $dataid=$repository1->find($id);
  $form=$this->createform(AuthorType::class,$dataid);
  $form->handleRequest($req);
if ($form->isSubmitted() and $form->isValid())
{

$en->persist($dataid);
$en->flush();
return $this->redirectToRoute("showdbauthor");
}
    return $this->renderForm("author/edit.html.twig",[
        'formedit' => $form]);
}
#[Route('deleteauthor/{id}', name: 'deleteauthor')]
    public function deleteauthor($id,AuthorRepository $repository2,ManagerRegistry $ManagerRegistry,Request $req): Response
    { $en =$ManagerRegistry->getManager();
        $fin=$repository2->find($id);
        $en->remove($fin);
        $en->flush();
        return $this->redirectToRoute("showdbauthor");
    }
    #[Route('showbookauthor/{id}', name: 'showbookauthor')]
    public function showbookauthor($id,AuthorRepository $authorRepository): Response
    {   
        $book=$authorRepository->serachById($id);
        var_dump($book) . die;
        return $this->render('author/showbookauthor.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('deletenobooks', name: 'deletenobooks')]
    public function deletenobooks(Request $request, AuthorRepository $authorRepository): Response
    {
        $authorsWithoutBooks = $authorRepository->findAuthorsWithNoBooks();

        return $this->render('author/deletenobooks.html.twig', [
            'authorsWithoutBooks' => $authorsWithoutBooks,
        ]);
    }

    
}

