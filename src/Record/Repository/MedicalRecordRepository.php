<?php

namespace App\Record\Repository;

use App\Record\Domain\Model\MedicalRecord;
use App\Record\Domain\Ports\MedicalRecordInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MedicalRecord>
 *
 * @method MedicalRecord|null find($id, $lockMode = null, $lockVersion = null)
 * @method MedicalRecord|null findOneBy(array $criteria, array $orderBy = null)
 * @method MedicalRecord[]    findAll()
 * @method MedicalRecord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedicalRecordRepository extends ServiceEntityRepository implements MedicalRecordInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MedicalRecord::class);
    }

    public function save(MedicalRecord $medicalRecord): void
    {
        try {
            $this->getEntityManager()->persist($medicalRecord);
            $this->getEntityManager()->flush();
        } catch (UniqueConstraintViolationException) {
            throw new \Exception('A ocurrido un error, intente de nuevo o hable con el adminstrador');
        }
    }

    public function listAll(): array
    {
        $data = $this->findBy(['isActive' => true]);
        if (empty($data)) {
            return [];
        }

        return $data;
    }

    public function findById(string $id): ?MedicalRecord
    {
        return $this->find($id);
    }
}
