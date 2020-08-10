<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200807110729 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'all migration diagramme';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, groupe_formateur_id INT DEFAULT NULL, promotion_id INT DEFAULT NULL, INDEX IDX_4B98C21690EBD95 (groupe_formateur_id), INDEX IDX_4B98C21139DF194 (promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_tag (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau_niveau (niveau_source INT NOT NULL, niveau_target INT NOT NULL, INDEX IDX_EFEB50F4FBBEDCEC (niveau_source), INDEX IDX_EFEB50F4E25B8C63 (niveau_target), PRIMARY KEY(niveau_source, niveau_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion_formateur (promotion_id INT NOT NULL, formateur_id INT NOT NULL, INDEX IDX_9C01AF62139DF194 (promotion_id), INDEX IDX_9C01AF62155D8F51 (formateur_id), PRIMARY KEY(promotion_id, formateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE referentiel (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE referentiel_promotion (referentiel_id INT NOT NULL, promotion_id INT NOT NULL, INDEX IDX_DFAEB2AF805DB139 (referentiel_id), INDEX IDX_DFAEB2AF139DF194 (promotion_id), PRIMARY KEY(referentiel_id, promotion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE referentiel_gpe_competence (referentiel_id INT NOT NULL, gpe_competence_id INT NOT NULL, INDEX IDX_D523CD31805DB139 (referentiel_id), INDEX IDX_D523CD315FDAB6CB (gpe_competence_id), PRIMARY KEY(referentiel_id, gpe_competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_groupe_tag (tag_id INT NOT NULL, groupe_tag_id INT NOT NULL, INDEX IDX_2932D77FBAD26311 (tag_id), INDEX IDX_2932D77FD1EC9F2B (groupe_tag_id), PRIMARY KEY(tag_id, groupe_tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21690EBD95 FOREIGN KEY (groupe_formateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id)');
        $this->addSql('ALTER TABLE niveau_niveau ADD CONSTRAINT FK_EFEB50F4FBBEDCEC FOREIGN KEY (niveau_source) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau_niveau ADD CONSTRAINT FK_EFEB50F4E25B8C63 FOREIGN KEY (niveau_target) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotion_formateur ADD CONSTRAINT FK_9C01AF62139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotion_formateur ADD CONSTRAINT FK_9C01AF62155D8F51 FOREIGN KEY (formateur_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE referentiel_promotion ADD CONSTRAINT FK_DFAEB2AF805DB139 FOREIGN KEY (referentiel_id) REFERENCES referentiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE referentiel_promotion ADD CONSTRAINT FK_DFAEB2AF139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE referentiel_gpe_competence ADD CONSTRAINT FK_D523CD31805DB139 FOREIGN KEY (referentiel_id) REFERENCES referentiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE referentiel_gpe_competence ADD CONSTRAINT FK_D523CD315FDAB6CB FOREIGN KEY (gpe_competence_id) REFERENCES gpe_competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_groupe_tag ADD CONSTRAINT FK_2932D77FBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_groupe_tag ADD CONSTRAINT FK_2932D77FD1EC9F2B FOREIGN KEY (groupe_tag_id) REFERENCES groupe_tag (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE apprenant');
        $this->addSql('DROP TABLE cm');
        $this->addSql('DROP TABLE formateur');
        $this->addSql('ALTER TABLE user ADD groupe_id INT DEFAULT NULL, ADD type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6497A45358C ON user (groupe_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497A45358C');
        $this->addSql('ALTER TABLE tag_groupe_tag DROP FOREIGN KEY FK_2932D77FD1EC9F2B');
        $this->addSql('ALTER TABLE niveau_niveau DROP FOREIGN KEY FK_EFEB50F4FBBEDCEC');
        $this->addSql('ALTER TABLE niveau_niveau DROP FOREIGN KEY FK_EFEB50F4E25B8C63');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21139DF194');
        $this->addSql('ALTER TABLE promotion_formateur DROP FOREIGN KEY FK_9C01AF62139DF194');
        $this->addSql('ALTER TABLE referentiel_promotion DROP FOREIGN KEY FK_DFAEB2AF139DF194');
        $this->addSql('ALTER TABLE referentiel_promotion DROP FOREIGN KEY FK_DFAEB2AF805DB139');
        $this->addSql('ALTER TABLE referentiel_gpe_competence DROP FOREIGN KEY FK_D523CD31805DB139');
        $this->addSql('ALTER TABLE tag_groupe_tag DROP FOREIGN KEY FK_2932D77FBAD26311');
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE apprenant (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE cm (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE formateur (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE groupe_tag');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE niveau_niveau');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE promotion_formateur');
        $this->addSql('DROP TABLE referentiel');
        $this->addSql('DROP TABLE referentiel_promotion');
        $this->addSql('DROP TABLE referentiel_gpe_competence');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_groupe_tag');
        $this->addSql('DROP INDEX IDX_8D93D6497A45358C ON user');
        $this->addSql('ALTER TABLE user DROP groupe_id, DROP type');
    }
}
