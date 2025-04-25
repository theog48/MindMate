<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250424145252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE quizz CHANGE userreponse1 userreponse1 VARCHAR(255) DEFAULT NULL, CHANGE reponse_user2 reponse_user2 VARCHAR(255) DEFAULT NULL, CHANGE reponse_user3 reponse_user3 VARCHAR(255) DEFAULT NULL, CHANGE reponse_user4 reponse_user4 VARCHAR(255) DEFAULT NULL, CHANGE reponse_user5 reponse_user5 VARCHAR(255) DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE quizz CHANGE userreponse1 userreponse1 VARCHAR(255) NOT NULL, CHANGE reponse_user2 reponse_user2 VARCHAR(255) NOT NULL, CHANGE reponse_user3 reponse_user3 VARCHAR(255) NOT NULL, CHANGE reponse_user4 reponse_user4 VARCHAR(255) NOT NULL, CHANGE reponse_user5 reponse_user5 VARCHAR(255) NOT NULL
        SQL);
    }
}
