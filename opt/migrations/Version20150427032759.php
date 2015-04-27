<?php

namespace TheLgbtWhip\Api\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150427032759 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE views ADD historic_support VARCHAR(255) DEFAULT NULL, ADD current_support VARCHAR(255) DEFAULT NULL, CHANGE historic_stance historic_stance LONGTEXT DEFAULT NULL, CHANGE current_stance current_stance LONGTEXT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX issue_candidate ON views (issue_id, candidate_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE views DROP historic_support, DROP current_support, CHANGE historic_stance historic_stance LONGTEXT NOT NULL COLLATE utf8_unicode_ci, CHANGE current_stance current_stance LONGTEXT NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('DROP INDEX issue_candidate ON views');
    }
}
