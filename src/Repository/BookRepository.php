<?php

namespace App\Repository;

use App\Entity\Book;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function searchref($ref){    //recherche avec ref
        return $this->createQueryBuilder('b')
        ->where('b.ref =:ref')
        ->setParameter('ref',$ref)
        ->getQuery()
        ->getResult();
    }
    public function orderbytitle(){
        return $this ->createQueryBuilder('b')
        ->orderBy('b.title','Asc') //trier avec le titre 
        ->getQuery()
        ->getResult();

    }
    public function showbynbrbook(){
        return $this ->createQueryBuilder('b')
        ->join('b.Author','a')
        ->addSelect('a')
        ->where('b.publicationDdate < :year')
        ->where('a.nbrlivre > :nbrLivremax')
        //->setParameter('year', new DateTime('2023-01-01'))
        ->setParameter('nbrLivremax', 35)         
        ->getQuery()
        ->getResult();                
    }
    public function updateCategory()
    {
        $qb = $this->createQueryBuilder('b')
        ->join('b.Author', 'a')
        ->where('a.username = :authorName')
        ->setParameter('authorName', 'William Shakespeare')
        ->getQuery();
    $books = $qb->getResult();
    foreach ($books as $book) {
        $book->setCategory('Romance');
    }
    $this->_em->flush();
    }   

    public function getSum()
    {
        return $this->createQueryBuilder('b')
            ->select('SUM(b.nbrlivre) as total')
            ->where('b.category = :category')
            ->setParameter('category', 'Science Fiction')
            ->getQuery()
            ->getSingleScalarResult();
    }
    

//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
