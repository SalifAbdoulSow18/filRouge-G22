<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200830173919 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apprenant_livrable_partiel ADD livrable_partiel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE apprenant_livrable_partiel ADD CONSTRAINT FK_8572D6AD519178C4 FOREIGN KEY (livrable_partiel_id) REFERENCES livrable_partiel (id)');
        $this->addSql('CREATE INDEX IDX_8572D6AD519178C4 ON apprenant_livrable_partiel (livrable_partiel_id)');
        $this->addSql('ALTER TABLE livrable_partiel DROP FOREIGN KEY FK_37F072C5DE88790F');
        $this->addSql('DROP INDEX IDX_37F072C5DE88790F ON livrable_partiel');
        $this->addSql('ALTER TABLE livrable_partiel DROP apprenant_livrable_partiel_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apprenant_livrable_partiel DROP FOREIGN KEY FK_8572D6AD519178C4');
        $this->addSql('DROP INDEX IDX_8572D6AD519178C4 ON apprenant_livrable_partiel');
        $this->addSql('ALTER TABLE apprenant_livrable_partiel DROP livrable_partiel_id');
        $this->addSql('ALTER TABLE livrable_partiel ADD apprenant_livrable_partiel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livrable_partiel ADD CONSTRAINT FK_37F072C5DE88790F FOREIGN KEY (apprenant_livrable_partiel_id) REFERENCES apprenant_livrable_partiel (id)');
        $this->addSql('CREATE INDEX IDX_37F072C5DE88790F ON livrable_partiel (apprenant_livrable_partiel_id)');
    }
}
