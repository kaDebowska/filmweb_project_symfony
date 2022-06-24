<?php
/**
 * User detail repository
 */
namespace App\Repository;

use App\Entity\UserDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class UserDetailRepository
 *
 * @extends ServiceEntityRepository<UserDetail>
 *
 * @method UserDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserDetail[]    findAll()
 * @method UserDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserDetailRepository extends ServiceEntityRepository
{
    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserDetail::class);
    }
    /**
     * Save entity.
     *
     * @param UserDetail $userDetail UserDetail entity
     */
    public function save(UserDetail $userDetail): void
    {
        $this->_em->persist($userDetail);
        $this->_em->flush();
    }

//    /**
//     * @return UserDetail[] Returns an array of UserDetail objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserDetail
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
