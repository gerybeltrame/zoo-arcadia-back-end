<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240515155924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur ADD possede_id INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3C835AB29 FOREIGN KEY (possede_id) REFERENCES possede (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3C835AB29 ON utilisateur (possede_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3C835AB29');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3C835AB29 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP possede_id');
    }
}
