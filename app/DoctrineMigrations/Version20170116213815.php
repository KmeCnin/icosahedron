<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170116213815 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mass_fight_army ADD campaign_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mass_fight_army ADD CONSTRAINT FK_8E463FF4F639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id)');
        $this->addSql('CREATE INDEX IDX_8E463FF4F639F774 ON mass_fight_army (campaign_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mass_fight_army DROP FOREIGN KEY FK_8E463FF4F639F774');
        $this->addSql('DROP INDEX IDX_8E463FF4F639F774 ON mass_fight_army');
        $this->addSql('ALTER TABLE mass_fight_army DROP campaign_id');
    }
}
