<?php

namespace TheLgbtWhip\Api\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150419132650 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE issues ADD uri_key VARCHAR(100) DEFAULT NULL');
        
        $this->addSql(
            "UPDATE issues SET uri_key = 'equal-age-of-consent' WHERE issue_id = 1"
        );
        
        $this->addSql(
            "UPDATE issues SET uri_key = 'repeal-of-section-28' WHERE issue_id = 2"
        );
        
        $this->addSql(
            "UPDATE issues SET uri_key = 'civil-partnerships' WHERE issue_id = 3"
        );
        
        $this->addSql(
            "UPDATE issues SET uri_key = 'equal-act-sexual-orientation' WHERE issue_id = 4"
        );
        
        $this->addSql(
            "UPDATE issues SET uri_key = 'ivf-treatment-lesbian-couples' WHERE issue_id = 5"
        );
        
        $this->addSql(
            "UPDATE issues SET uri_key = 'same-sex-marriage' WHERE issue_id = 6"
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE issues DROP uri_key');
    }
}
