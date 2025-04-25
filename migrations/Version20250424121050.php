<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250424121050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, content VARCHAR(255) NOT NULL, note INT NOT NULL, INDEX IDX_67F068BCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, titre VARCHAR(255) NOT NULL, contenu VARCHAR(5000) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_FDCA8C9CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE faq (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, reponse VARCHAR(255) NOT NULL, affichage TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE mot_cle (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE mot_cle_cours (mot_cle_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_E79D591BFE94535C (mot_cle_id), INDEX IDX_E79D591B7ECF78B0 (cours_id), PRIMARY KEY(mot_cle_id, cours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE quizz (id INT AUTO_INCREMENT NOT NULL, cours_id INT NOT NULL, user_id INT NOT NULL, titre VARCHAR(255) NOT NULL, question1 VARCHAR(255) NOT NULL, reponse11 VARCHAR(255) NOT NULL, reponse12 VARCHAR(255) NOT NULL, reponse13 VARCHAR(255) NOT NULL, bonnereponse1 VARCHAR(255) NOT NULL, userreponse1 VARCHAR(255) NOT NULL, question2 VARCHAR(255) NOT NULL, reponse21 VARCHAR(255) NOT NULL, reponse22 VARCHAR(255) NOT NULL, reponse23 VARCHAR(255) NOT NULL, bonne_reponse2 VARCHAR(255) NOT NULL, reponse_user2 VARCHAR(255) NOT NULL, question3 VARCHAR(255) NOT NULL, reponse31 VARCHAR(255) NOT NULL, reponse32 VARCHAR(255) NOT NULL, reponse33 VARCHAR(255) NOT NULL, bonne_reponse3 VARCHAR(255) NOT NULL, reponse_user3 VARCHAR(255) NOT NULL, question4 VARCHAR(255) NOT NULL, question41 VARCHAR(255) NOT NULL, question42 VARCHAR(255) NOT NULL, question43 VARCHAR(255) NOT NULL, bonne_reponse4 VARCHAR(255) NOT NULL, reponse_user4 VARCHAR(255) NOT NULL, question5 VARCHAR(255) NOT NULL, question51 VARCHAR(255) NOT NULL, question52 VARCHAR(255) NOT NULL, question53 VARCHAR(255) NOT NULL, bonne_reponse5 VARCHAR(255) NOT NULL, reponse_user5 VARCHAR(255) NOT NULL, score VARCHAR(255) NOT NULL, INDEX IDX_7C77973D7ECF78B0 (cours_id), INDEX IDX_7C77973DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, nb_token INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', has_test_premium TINYINT(1) NOT NULL, date_fin_premium DATE DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE mot_cle_cours ADD CONSTRAINT FK_E79D591BFE94535C FOREIGN KEY (mot_cle_id) REFERENCES mot_cle (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE mot_cle_cours ADD CONSTRAINT FK_E79D591B7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quizz ADD CONSTRAINT FK_7C77973D7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quizz ADD CONSTRAINT FK_7C77973DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE mot_cle_cours DROP FOREIGN KEY FK_E79D591BFE94535C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE mot_cle_cours DROP FOREIGN KEY FK_E79D591B7ECF78B0
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quizz DROP FOREIGN KEY FK_7C77973D7ECF78B0
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quizz DROP FOREIGN KEY FK_7C77973DA76ED395
        SQL);
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
            DROP TABLE mot_cle_cours
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE quizz
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `user`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
