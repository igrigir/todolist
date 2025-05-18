<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250518140402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task ADD COLUMN price DOUBLE PRECISION NOT NULL DEFAULT 0');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__task AS SELECT id, title, description, created_at, is_done, status, finished_at FROM task');
        $this->addSql('DROP TABLE task');
        $this->addSql('CREATE TABLE task (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, created_at DATETIME NOT NULL, is_done BOOLEAN NOT NULL, status SMALLINT DEFAULT 0 NOT NULL, finished_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO task (id, title, description, created_at, is_done, status, finished_at) SELECT id, title, description, created_at, is_done, status, finished_at FROM __temp__task');
        $this->addSql('DROP TABLE __temp__task');
    }
}
