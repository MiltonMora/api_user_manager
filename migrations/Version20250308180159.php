<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250308180159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE consultation (id VARCHAR(36) NOT NULL, doctor_id VARCHAR(36) NOT NULL, patient_id VARCHAR(36) NOT NULL, medical_record_id VARCHAR(36) NOT NULL, date_start TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_end TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, notes TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_964685A687F4FB17 ON consultation (doctor_id)');
        $this->addSql('CREATE INDEX IDX_964685A66B899279 ON consultation (patient_id)');
        $this->addSql('CREATE INDEX IDX_964685A6B88E2BB6 ON consultation (medical_record_id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A687F4FB17 FOREIGN KEY (doctor_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A66B899279 FOREIGN KEY (patient_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6B88E2BB6 FOREIGN KEY (medical_record_id) REFERENCES medical_record (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE consultation DROP CONSTRAINT FK_964685A687F4FB17');
        $this->addSql('ALTER TABLE consultation DROP CONSTRAINT FK_964685A66B899279');
        $this->addSql('ALTER TABLE consultation DROP CONSTRAINT FK_964685A6B88E2BB6');
        $this->addSql('DROP TABLE consultation');
    }
}
