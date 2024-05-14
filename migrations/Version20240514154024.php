<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514154024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE obtient ADD animal_id INT NOT NULL');
        $this->addSql('ALTER TABLE obtient ADD CONSTRAINT FK_DD849628E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('CREATE INDEX IDX_DD849628E962C16 ON obtient (animal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE obtient DROP FOREIGN KEY FK_DD849628E962C16');
        $this->addSql('DROP INDEX IDX_DD849628E962C16 ON obtient');
        $this->addSql('ALTER TABLE obtient DROP animal_id');
    }
}
