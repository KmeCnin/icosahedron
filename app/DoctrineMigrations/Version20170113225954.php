<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170113225954 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE kingmaker_map DROP FOREIGN KEY FK_7E594803F639F774');
        $this->addSql('CREATE TABLE base_campaign (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, createdBy_id INT NOT NULL, discr VARCHAR(255) NOT NULL, INDEX IDX_55FEB1253174800F (createdBy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE base_campaign ADD CONSTRAINT FK_55FEB1253174800F FOREIGN KEY (createdBy_id) REFERENCES users (id)');
        $this->addSql('DROP TABLE kingmaker_campaign');
        $this->addSql('ALTER TABLE kingmaker_map DROP FOREIGN KEY FK_7E594803F639F774');
        $this->addSql('ALTER TABLE kingmaker_map ADD CONSTRAINT FK_7E594803F639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id)');
        $this->addSql('ALTER TABLE campaign DROP FOREIGN KEY FK_1F1512DD3174800F');
        $this->addSql('DROP INDEX IDX_1F1512DD3174800F ON campaign');
        $this->addSql('ALTER TABLE campaign DROP name, DROP slug, DROP description, DROP created, DROP updated, DROP createdBy_id, DROP discr, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE campaign ADD CONSTRAINT FK_1F1512DDBF396750 FOREIGN KEY (id) REFERENCES base_campaign (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE old_table RENAME new_table;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE campaign DROP FOREIGN KEY FK_1F1512DDBF396750');
        $this->addSql('CREATE TABLE kingmaker_campaign (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, slug VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, created DATETIME NOT NULL, updated DATETIME NOT NULL, createdBy_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE base_campaign');
        $this->addSql('ALTER TABLE campaign ADD name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD slug VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD description LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL, ADD createdBy_id INT NOT NULL, ADD discr VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE campaign ADD CONSTRAINT FK_1F1512DD3174800F FOREIGN KEY (createdBy_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_1F1512DD3174800F ON campaign (createdBy_id)');
        $this->addSql('ALTER TABLE kingmaker_map DROP FOREIGN KEY FK_7E594803F639F774');
        $this->addSql('ALTER TABLE kingmaker_map ADD CONSTRAINT FK_7E594803F639F774 FOREIGN KEY (campaign_id) REFERENCES kingmaker_campaign (id)');
    }
}
