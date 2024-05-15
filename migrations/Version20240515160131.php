<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240515160131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE redige ADD utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE redige ADD CONSTRAINT FK_42DC0D18FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_42DC0D18FB88E14F ON redige (utilisateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE redige DROP FOREIGN KEY FK_42DC0D18FB88E14F');
        $this->addSql('DROP INDEX IDX_42DC0D18FB88E14F ON redige');
        $this->addSql('ALTER TABLE redige DROP utilisateur_id');
    }
}
