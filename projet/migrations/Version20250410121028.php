<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250410121028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(255) NOT NULL, rue VARCHAR(255) NOT NULL, cp INT NOT NULL, ville VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE destination (id INT AUTO_INCREMENT NOT NULL, id_adresse_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, url_imgs LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_3EC63EAAE86D5C8B (id_adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, id_utilisateur_id INT NOT NULL, bio LONGTEXT DEFAULT NULL, preferences LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_E6D6B297C6EE5C49 (id_utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', is_admin TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE destination ADD CONSTRAINT FK_3EC63EAAE86D5C8B FOREIGN KEY (id_adresse_id) REFERENCES adresse (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE profil ADD CONSTRAINT FK_E6D6B297C6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE destination DROP FOREIGN KEY FK_3EC63EAAE86D5C8B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE profil DROP FOREIGN KEY FK_E6D6B297C6EE5C49
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE adresse
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE destination
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE profil
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE utilisateur
        SQL);
    }
}
