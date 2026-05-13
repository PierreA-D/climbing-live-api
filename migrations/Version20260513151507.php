<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260513151507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE camera ADD token VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE camera ADD blocked BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE camera ADD allowed_paths JSON NOT NULL');
        $this->addSql('ALTER TABLE camera ADD last_seen_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE camera ADD last_ip VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE camera ADD last_protocol VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE camera ADD current_path VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE camera ALTER status TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "camera" DROP token');
        $this->addSql('ALTER TABLE "camera" DROP blocked');
        $this->addSql('ALTER TABLE "camera" DROP allowed_paths');
        $this->addSql('ALTER TABLE "camera" DROP last_seen_at');
        $this->addSql('ALTER TABLE "camera" DROP last_ip');
        $this->addSql('ALTER TABLE "camera" DROP last_protocol');
        $this->addSql('ALTER TABLE "camera" DROP current_path');
        $this->addSql('ALTER TABLE "camera" ALTER status TYPE VARCHAR(50)');
    }
}
