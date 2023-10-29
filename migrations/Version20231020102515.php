<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231020102515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle ADD department_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT FK_4E977E5CAE80F5DF FOREIGN KEY (department_id) REFERENCES departement (id)');
        $this->addSql('CREATE INDEX IDX_4E977E5CAE80F5DF ON salle (department_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5CAE80F5DF');
        $this->addSql('DROP INDEX IDX_4E977E5CAE80F5DF ON salle');
        $this->addSql('ALTER TABLE salle DROP department_id');
    }
}
