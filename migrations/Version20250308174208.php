<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250308174208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medical_record (id VARCHAR(36) NOT NULL, doctor_id VARCHAR(36) NOT NULL, patient_id VARCHAR(36) NOT NULL, diagnosis TEXT NOT NULL, treatment TEXT NOT NULL, date_start TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, active BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F06A283E87F4FB17 ON medical_record (doctor_id)');
        $this->addSql('CREATE INDEX IDX_F06A283E6B899279 ON medical_record (patient_id)');
        $this->addSql('ALTER TABLE medical_record ADD CONSTRAINT FK_F06A283E87F4FB17 FOREIGN KEY (doctor_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE medical_record ADD CONSTRAINT FK_F06A283E6B899279 FOREIGN KEY (patient_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE medical_record DROP CONSTRAINT FK_F06A283E87F4FB17');
        $this->addSql('ALTER TABLE medical_record DROP CONSTRAINT FK_F06A283E6B899279');
        $this->addSql('DROP TABLE medical_record');
    }
}
