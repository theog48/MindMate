<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250425082142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE quizz ADD reponse41 VARCHAR(255) NOT NULL, ADD reponse42 VARCHAR(255) NOT NULL, ADD reponse43 VARCHAR(255) NOT NULL, ADD reponse51 VARCHAR(255) NOT NULL, ADD reponse52 VARCHAR(255) NOT NULL, ADD reponse53 VARCHAR(255) NOT NULL, DROP question41, DROP question42, DROP question43, DROP question51, DROP question52, DROP question53, CHANGE cours_id cours_id INT NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE quizz ADD question41 VARCHAR(255) NOT NULL, ADD question42 VARCHAR(255) NOT NULL, ADD question43 VARCHAR(255) NOT NULL, ADD question51 VARCHAR(255) NOT NULL, ADD question52 VARCHAR(255) NOT NULL, ADD question53 VARCHAR(255) NOT NULL, DROP reponse41, DROP reponse42, DROP reponse43, DROP reponse51, DROP reponse52, DROP reponse53, CHANGE cours_id cours_id INT DEFAULT NULL
        SQL);
    }
}
