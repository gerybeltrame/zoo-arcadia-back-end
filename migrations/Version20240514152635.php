<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514152635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comporte ADD habitat_id INT NOT NULL');
        $this->addSql('ALTER TABLE comporte ADD CONSTRAINT FK_49BBCA38AFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (id)');
        $this->addSql('CREATE INDEX IDX_49BBCA38AFFE2D26 ON comporte (habitat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comporte DROP FOREIGN KEY FK_49BBCA38AFFE2D26');
        $this->addSql('DROP INDEX IDX_49BBCA38AFFE2D26 ON comporte');
        $this->addSql('ALTER TABLE comporte DROP habitat_id');
    }
}
