<?php

namespace App\Repository;

use App\Entity\Country;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Country|null find($id, $lockMode = null, $lockVersion = null)
 * @method Country|null findOneBy(array $criteria, array $orderBy = null)
 * @method Country[]    findAll()
 * @method Country[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CountryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Country::class);
    }

    // /**
    //  * @return Country[] Returns an array of Country objects
    //  */
//aproche query builder
    public function findByPopNumber($num)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.population > :num')
            ->setParameter('num', $num)
            ->orderBy('c.name', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
//approche DQL
    public function findAllCustom()
    {

      $em = $this->getEntityManager();
      $query = $em->createQuery(
        'SELECT c FROM App\Entity\Country c
        ');//renvois un tableau associatif de forme ['name=>'France]
      return $query->execute();

    }
    //approche DQL exemple2
    // public function findBySearch($search){
    //   $em = $this->getEntityManager();
    //   $query = $em->createQuery(SELECT c FROM App/Entity/Country)
    // }


    /*
    public function findOneBySomeField($value): ?Country
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
