<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260512170102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE camera ADD competition_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE camera ADD CONSTRAINT FK_3B1CEE057B39D312 FOREIGN KEY (competition_id) REFERENCES "competition" (id)');
        $this->addSql('CREATE INDEX IDX_3B1CEE057B39D312 ON camera (competition_id)');
        $this->addSql('ALTER TABLE competition ADD category VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE competition ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE competition ALTER status DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "camera" DROP CONSTRAINT FK_3B1CEE057B39D312');
        $this->addSql('DROP INDEX IDX_3B1CEE057B39D312');
        $this->addSql('ALTER TABLE "camera" DROP competition_id');
        $this->addSql('ALTER TABLE "competition" DROP category');
        $this->addSql('ALTER TABLE "competition" ALTER status TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE "competition" ALTER status SET NOT NULL');
    }
}
