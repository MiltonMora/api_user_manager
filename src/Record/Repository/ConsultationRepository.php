<?php

namespace App\Record\Repository;

use App\Record\Domain\Model\Consultation;
use App\Record\Domain\Ports\ConsultationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Consultation>
 *
 * @method Consultation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consultation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consultation[]    findAll()
 * @method Consultation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultationRepository extends ServiceEntityRepository implements ConsultationInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consultation::class);
    }

    public function save(Consultation $consultation): void
    {
        try {
            $this->getEntityManager()->persist($consultation);
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

    public function findById(string $id): ?Consultation
    {
        return $this->find($id);
    }
}
