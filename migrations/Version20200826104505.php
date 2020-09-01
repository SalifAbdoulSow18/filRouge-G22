<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200826104505 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competences_valides ADD referentiel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE competences_valides ADD CONSTRAINT FK_9EEA096E805DB139 FOREIGN KEY (referentiel_id) REFERENCES referentiel (id)');
        $this->addSql('CREATE INDEX IDX_9EEA096E805DB139 ON competences_valides (referentiel_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competences_valides DROP FOREIGN KEY FK_9EEA096E805DB139');
        $this->addSql('DROP INDEX IDX_9EEA096E805DB139 ON competences_valides');
        $this->addSql('ALTER TABLE competences_valides DROP referentiel_id');
    }
}
