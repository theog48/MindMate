<?php

namespace App\Repository;

use App\Entity\MotCle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MotCle>
 */
class MotCleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotCle::class);
    }

    // // Méthode pour récupérer tous les tags existants (par exemple, tous les noms de mots-clés)
    // public function findAllTags(): array
    // {
    //     // Utilisation de la méthode createQueryBuilder pour récupérer uniquement les noms de tags
    //     $query = $this->createQueryBuilder('m')
    //         ->select('m.nom') // Sélectionner seulement le nom du mot clé
    //         ->getQuery();

    //     // Exécuter la requête et retourner le résultat
    //     return $query->getResult();
    // }


    //    /**
    //     * @return MotCle[] Returns an array of MotCle objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?MotCle
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
