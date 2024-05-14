<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514153709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD dispose_id INT NOT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FD7D98158 FOREIGN KEY (dispose_id) REFERENCES dispose (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6AAB231FD7D98158 ON animal (dispose_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FD7D98158');
        $this->addSql('DROP INDEX UNIQ_6AAB231FD7D98158 ON animal');
        $this->addSql('ALTER TABLE animal DROP dispose_id');
    }
}
