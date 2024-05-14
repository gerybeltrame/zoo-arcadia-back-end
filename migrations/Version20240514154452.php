<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514154452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE role ADD possede_id INT NOT NULL');
        $this->addSql('ALTER TABLE role ADD CONSTRAINT FK_57698A6AC835AB29 FOREIGN KEY (possede_id) REFERENCES possede (id)');
        $this->addSql('CREATE INDEX IDX_57698A6AC835AB29 ON role (possede_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE role DROP FOREIGN KEY FK_57698A6AC835AB29');
        $this->addSql('DROP INDEX IDX_57698A6AC835AB29 ON role');
        $this->addSql('ALTER TABLE role DROP possede_id');
    }
}
