<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514154204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE obtient ADD rapportveterinaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE obtient ADD CONSTRAINT FK_DD84962C33A7D9B FOREIGN KEY (rapportveterinaire_id) REFERENCES rapport_veterinaire (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DD84962C33A7D9B ON obtient (rapportveterinaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE obtient DROP FOREIGN KEY FK_DD84962C33A7D9B');
        $this->addSql('DROP INDEX UNIQ_DD84962C33A7D9B ON obtient');
        $this->addSql('ALTER TABLE obtient DROP rapportveterinaire_id');
    }
}
