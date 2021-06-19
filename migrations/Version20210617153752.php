<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210617153752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidature (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, id_offre_id INT NOT NULL, valider VARCHAR(255) NOT NULL, INDEX IDX_E33BD3B8A76ED395 (user_id), INDEX IDX_E33BD3B81C13BCCF (id_offre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, contenu VARCHAR(255) NOT NULL, date_c DATE DEFAULT NULL, INDEX IDX_AF86866FBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, candidature_id INT NOT NULL, adresse VARCHAR(255) NOT NULL, date DATE DEFAULT NULL, heure TIME DEFAULT NULL, remarque VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_65E8AA0AB6121583 (candidature_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, cin VARCHAR(255) NOT NULL, cv VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B81C13BCCF FOREIGN KEY (id_offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AB6121583 FOREIGN KEY (candidature_id) REFERENCES candidature (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AB6121583');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FBCF5E72D');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B81C13BCCF');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B8A76ED395');
        $this->addSql('DROP TABLE candidature');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE user');
    }
}
