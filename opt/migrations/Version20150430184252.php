<?php

namespace TheLgbtWhip\Api\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150430184252 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE constituencies CHANGE constituency_id constituency_id INT NOT NULL');
        $this->addSql('ALTER TABLE candidates CHANGE candidate_id candidate_id INT NOT NULL');
        $this->addSql('ALTER TABLE views DROP historic_stance, DROP historic_support, CHANGE view_id view_id INT AUTO_INCREMENT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE candidates CHANGE candidate_id candidate_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE constituencies CHANGE constituency_id constituency_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE views ADD historic_stance LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ADD historic_support VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE view_id view_id INT NOT NULL');
    }
}
