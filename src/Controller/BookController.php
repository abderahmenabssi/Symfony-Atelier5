<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Form\AbderahmenType;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Form;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('/addbook', name: 'addbook')]
    public function addbook(ManagerRegistry $managerRegistry,Request $req,): Response
    {
        $em=$managerRegistry->getManager();
        $book = new Book();    
        $form=$this->createForm(BookType::class,$book);
        $form->handleRequest($req);
        $authors = $book->getAuthor();
        if($form->isSubmitted()and $form -> isValid()){
            $book->isPublished('true');
            if($authors instanceof Author)
            {       
                $authors->setNbrlivre($authors->getNbrlivre()+1);
            }
            
        $em->persist($book);
        $em->flush();
        return $this->redirectToRoute('showbook');
    }
    return $this->renderForm('book/addbook.html.twig', [
        'f'=>$form
    ]);}

    #[Route('/showbook', name: 'showbook')]
    public function showbook(BookRepository $bookRepository,Request $req): Response
    {   $books=$bookRepository->orderbytitle(); //trier par orddre de titre 
        //$book=$bookRepository->showbynbrbook(); //afficher les livres dont l'auteur a plus que 35 livres
        
        $searchform=$this->createForm(AbderahmenType::class);
        $searchform->handleRequest($req);
        //var_dump($searchform).die();
       
        if($searchform->isSubmitted()){
            $datainput=$searchform->get('ref')->getData();
            $books=$bookRepository->searchref($datainput);
        }
        //$books=$bookRepository->updateCategory(); //changer la catégorie des livres de “William Shakespear”
    return $this->render('book/showbook.html.twig', [
        
        'books'=>$books,
        'f' =>$searchform->createView(),
       
        
    ]);
    
       
    }

    #[Route('editbook/{ref}=', name: 'editbook')]
public function editbook( $ref ,BookRepository $repository1,ManagerRegistry $ManagerRegistry,Request $req):Response
{
  //var_dump($id) . die();
  $en =$ManagerRegistry->getManager();
  $dataid=$repository1->find($ref);
  $form=$this->createform(BookType::class,$dataid);
  $form->handleRequest($req);
if ($form->isSubmitted() and $form->isValid())
{

$en->persist($dataid);
$en->flush();
return $this->redirectToRoute("showbook");
}
    return $this->renderForm("book/edit.html.twig",[
        'formedit' => $form]);
}
#[Route('deletebook/{ref}', name: 'deletebook')]
    public function deletebook($ref,BookRepository $repository2,ManagerRegistry $ManagerRegistry,Request $req): Response
    { $en =$ManagerRegistry->getManager();
        $fin=$repository2->find($ref);
        $en->remove($fin);
        $en->flush();
        return $this->redirectToRoute("showbook");
    }
    #[Route('showdetaille/{ref}', name: 'showdetaille')]
    public function showdetaille($ref,BookRepository $repository2): Response
{ 
    $fin=$repository2->find($ref);
  if(!$fin)
  return $this->redirectToRoute("showbook");
else

    return $this->render("book/showdetaille.html.twig",[
        'd'=>$fin]);
}



}
