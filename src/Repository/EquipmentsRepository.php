<?php

namespace App\Repository;

use App\Entity\Equipments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Equipments>
 *
 * @method Equipments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Equipments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Equipments[]    findAll()
 * @method Equipments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipmentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Equipments::class);
    }



    public function deleteEquipment($id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            DELETE FROM equipments
            WHERE id = :id
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);

    }

    public function findEquipmentById($id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM equipments
            WHERE id = ?
            ';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

    }

}
