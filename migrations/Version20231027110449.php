<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231027110449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author ADD nbrlivre INT NOT NULL, DROP nb_books, DROP nbr_books, DROP nbrlivres');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author ADD nbr_books INT NOT NULL, ADD nbrlivres INT NOT NULL, CHANGE nbrlivre nb_books INT NOT NULL');
    }
}
