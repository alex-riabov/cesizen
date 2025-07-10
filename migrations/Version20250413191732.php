<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250413191732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE emotion (id INT AUTO_INCREMENT NOT NULL, emotion_base_id INT NOT NULL, nom_emotion VARCHAR(50) NOT NULL, INDEX IDX_DEBC77745BFE3E (emotion_base_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE emotion_base (id INT AUTO_INCREMENT NOT NULL, nom_emotion_base VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE entree (id INT AUTO_INCREMENT NOT NULL, journal_id INT NOT NULL, emotion_id INT NOT NULL, date_heure_entree DATETIME NOT NULL, commentaire VARCHAR(500) DEFAULT NULL, INDEX IDX_598377A6478E8802 (journal_id), INDEX IDX_598377A61EE4A582 (emotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, UNIQUE INDEX UNIQ_8933C432FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE information (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, nom_information VARCHAR(50) NOT NULL, date_heure_information DATETIME NOT NULL, contenu_information VARCHAR(500) NOT NULL, INDEX IDX_29791883FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE information_favoris (information_id INT NOT NULL, favoris_id INT NOT NULL, INDEX IDX_940264A32EF03101 (information_id), INDEX IDX_940264A351E8871B (favoris_id), PRIMARY KEY(information_id, favoris_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE journal (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, UNIQUE INDEX UNIQ_C1A7E74DFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE rapport (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, journal_id INT NOT NULL, date_debut_rapport DATE NOT NULL, date_fin_rapport DATE NOT NULL, date_creation_rapport DATE NOT NULL, contenu_rapport VARCHAR(500) NOT NULL, INDEX IDX_BE34A09CFB88E14F (utilisateur_id), INDEX IDX_BE34A09C478E8802 (journal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE utilisateur_info (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, nom_utilisateur VARCHAR(255) NOT NULL, prenom_utilisateur VARCHAR(255) NOT NULL, date_naissance_utilisateur DATE NOT NULL, UNIQUE INDEX UNIQ_2085D6DFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE emotion ADD CONSTRAINT FK_DEBC77745BFE3E FOREIGN KEY (emotion_base_id) REFERENCES emotion_base (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE entree ADD CONSTRAINT FK_598377A6478E8802 FOREIGN KEY (journal_id) REFERENCES journal (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE entree ADD CONSTRAINT FK_598377A61EE4A582 FOREIGN KEY (emotion_id) REFERENCES emotion (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE favoris ADD CONSTRAINT FK_8933C432FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE information ADD CONSTRAINT FK_29791883FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE information_favoris ADD CONSTRAINT FK_940264A32EF03101 FOREIGN KEY (information_id) REFERENCES information (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE information_favoris ADD CONSTRAINT FK_940264A351E8871B FOREIGN KEY (favoris_id) REFERENCES favoris (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE journal ADD CONSTRAINT FK_C1A7E74DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C478E8802 FOREIGN KEY (journal_id) REFERENCES journal (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur_info ADD CONSTRAINT FK_2085D6DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE emotion DROP FOREIGN KEY FK_DEBC77745BFE3E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE entree DROP FOREIGN KEY FK_598377A6478E8802
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE entree DROP FOREIGN KEY FK_598377A61EE4A582
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE favoris DROP FOREIGN KEY FK_8933C432FB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE information DROP FOREIGN KEY FK_29791883FB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE information_favoris DROP FOREIGN KEY FK_940264A32EF03101
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE information_favoris DROP FOREIGN KEY FK_940264A351E8871B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE journal DROP FOREIGN KEY FK_C1A7E74DFB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09CFB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C478E8802
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur_info DROP FOREIGN KEY FK_2085D6DFB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE emotion
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE emotion_base
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE entree
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE favoris
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE information
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE information_favoris
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE journal
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE rapport
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE utilisateur_info
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
