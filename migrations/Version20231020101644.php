<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231020101644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle ADD departement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT FK_4E977E5CCCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('CREATE INDEX IDX_4E977E5CCCF9E01E ON salle (departement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5CCCF9E01E');
        $this->addSql('DROP INDEX IDX_4E977E5CCCF9E01E ON salle');
        $this->addSql('ALTER TABLE salle DROP departement_id');
    }
}
