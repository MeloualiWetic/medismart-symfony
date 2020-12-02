<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201202140356 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresses (id INT AUTO_INCREMENT NOT NULL, code_postal INT NOT NULL, numero INT NOT NULL, pays VARCHAR(255) DEFAULT NULL, rue VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consultations (id INT AUTO_INCREMENT NOT NULL, prestation_id INT NOT NULL, date_debut DATETIME NOT NULL, data_fin DATETIME NOT NULL, description TINYTEXT DEFAULT NULL, refernce VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, INDEX IDX_242D8F539E45C554 (prestation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE details_consultations (id INT AUTO_INCREMENT NOT NULL, consultation_id INT NOT NULL, prestation_id INT NOT NULL, frais DOUBLE PRECISION NOT NULL, INDEX IDX_6CB2D08D62FF6CDF (consultation_id), INDEX IDX_6CB2D08D9E45C554 (prestation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestations (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, frais DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, adresse_id INT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3F85E0677 (username), UNIQUE INDEX UNIQ_1D1C63B34DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE consultations ADD CONSTRAINT FK_242D8F539E45C554 FOREIGN KEY (prestation_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE details_consultations ADD CONSTRAINT FK_6CB2D08D62FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultations (id)');
        $this->addSql('ALTER TABLE details_consultations ADD CONSTRAINT FK_6CB2D08D9E45C554 FOREIGN KEY (prestation_id) REFERENCES prestations (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B34DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresses (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B34DE7DC5C');
        $this->addSql('ALTER TABLE details_consultations DROP FOREIGN KEY FK_6CB2D08D62FF6CDF');
        $this->addSql('ALTER TABLE details_consultations DROP FOREIGN KEY FK_6CB2D08D9E45C554');
        $this->addSql('ALTER TABLE consultations DROP FOREIGN KEY FK_242D8F539E45C554');
        $this->addSql('DROP TABLE adresses');
        $this->addSql('DROP TABLE consultations');
        $this->addSql('DROP TABLE details_consultations');
        $this->addSql('DROP TABLE prestations');
        $this->addSql('DROP TABLE utilisateur');
    }
}
