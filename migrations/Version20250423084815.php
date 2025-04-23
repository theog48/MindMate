<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250423084815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE mot_cle_cours (mot_cle_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_E79D591BFE94535C (mot_cle_id), INDEX IDX_E79D591B7ECF78B0 (cours_id), PRIMARY KEY(mot_cle_id, cours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE mot_cle_cours ADD CONSTRAINT FK_E79D591BFE94535C FOREIGN KEY (mot_cle_id) REFERENCES mot_cle (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE mot_cle_cours ADD CONSTRAINT FK_E79D591B7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaire ADD user_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_67F068BCA76ED395 ON commentaire (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cours ADD user_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_FDCA8C9CA76ED395 ON cours (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quizz ADD cours_id INT NOT NULL, ADD user_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quizz ADD CONSTRAINT FK_7C77973D7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quizz ADD CONSTRAINT FK_7C77973DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7C77973D7ECF78B0 ON quizz (cours_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_7C77973DA76ED395 ON quizz (user_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE mot_cle_cours DROP FOREIGN KEY FK_E79D591BFE94535C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE mot_cle_cours DROP FOREIGN KEY FK_E79D591B7ECF78B0
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE mot_cle_cours
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_67F068BCA76ED395 ON commentaire
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commentaire DROP user_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_FDCA8C9CA76ED395 ON cours
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cours DROP user_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quizz DROP FOREIGN KEY FK_7C77973D7ECF78B0
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quizz DROP FOREIGN KEY FK_7C77973DA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_7C77973D7ECF78B0 ON quizz
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_7C77973DA76ED395 ON quizz
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quizz DROP cours_id, DROP user_id
        SQL);
    }
}
