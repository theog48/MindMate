<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250423080431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, content VARCHAR(255) NOT NULL, note INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, contenu VARCHAR(5000) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE faq (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, reponse VARCHAR(255) NOT NULL, affichage TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE mot_cle (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE quizz (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, question1 VARCHAR(255) NOT NULL, reponse11 VARCHAR(255) NOT NULL, reponse12 VARCHAR(255) NOT NULL, reponse13 VARCHAR(255) NOT NULL, bonnereponse1 VARCHAR(255) NOT NULL, userreponse1 VARCHAR(255) NOT NULL, question2 VARCHAR(255) NOT NULL, reponse21 VARCHAR(255) NOT NULL, reponse22 VARCHAR(255) NOT NULL, reponse23 VARCHAR(255) NOT NULL, bonne_reponse2 VARCHAR(255) NOT NULL, reponse_user2 VARCHAR(255) NOT NULL, question3 VARCHAR(255) NOT NULL, reponse31 VARCHAR(255) NOT NULL, reponse32 VARCHAR(255) NOT NULL, reponse33 VARCHAR(255) NOT NULL, bonne_reponse3 VARCHAR(255) NOT NULL, reponse_user3 VARCHAR(255) NOT NULL, question4 VARCHAR(255) NOT NULL, question41 VARCHAR(255) NOT NULL, question42 VARCHAR(255) NOT NULL, question43 VARCHAR(255) NOT NULL, bonne_reponse4 VARCHAR(255) NOT NULL, reponse_user4 VARCHAR(255) NOT NULL, question5 VARCHAR(255) NOT NULL, question51 VARCHAR(255) NOT NULL, question52 VARCHAR(255) NOT NULL, question53 VARCHAR(255) NOT NULL, bonne_reponse5 VARCHAR(255) NOT NULL, reponse_user5 VARCHAR(255) NOT NULL, score VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE commentaire
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cours
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE faq
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE mot_cle
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE quizz
        SQL);
    }
}
