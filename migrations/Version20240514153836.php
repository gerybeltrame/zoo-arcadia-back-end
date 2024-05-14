<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514153836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE race ADD dispose_id INT NOT NULL');
        $this->addSql('ALTER TABLE race ADD CONSTRAINT FK_DA6FBBAFD7D98158 FOREIGN KEY (dispose_id) REFERENCES dispose (id)');
        $this->addSql('CREATE INDEX IDX_DA6FBBAFD7D98158 ON race (dispose_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE race DROP FOREIGN KEY FK_DA6FBBAFD7D98158');
        $this->addSql('DROP INDEX IDX_DA6FBBAFD7D98158 ON race');
        $this->addSql('ALTER TABLE race DROP dispose_id');
    }
}
