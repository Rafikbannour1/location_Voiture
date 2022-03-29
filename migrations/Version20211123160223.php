<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211123160223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location CHANGE voiture_id voiture_id INT NOT NULL, CHANGE date_debut date_debut DATE NOT NULL, CHANGE date_fin date_fin DATE NOT NULL');
        $this->addSql('ALTER TABLE voiture ADD code_voiture INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location CHANGE voiture_id voiture_id INT DEFAULT NULL, CHANGE date_debut date_debut DATETIME NOT NULL, CHANGE date_fin date_fin DATETIME NOT NULL');
        $this->addSql('ALTER TABLE voiture DROP code_voiture');
    }
}
