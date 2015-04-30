<?php

namespace TheLgbtWhip\Api\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150430234116 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("UPDATE issues SET uri_key = 'remove-blood-ban' WHERE issue_id = 7");
        $this->addSql("UPDATE issues SET uri_key = 'asylum-lgbt-refugees' WHERE issue_id = 8");
        $this->addSql("UPDATE issues SET uri_key = 'conversion-therapy' WHERE issue_id = 9");
        $this->addSql("UPDATE issues SET uri_key = 'trans-people-in-healthcare' WHERE issue_id = 10");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("UPDATE issues SET uri_key = NULL WHERE issue_id BETWEEN 7 AND 10");
    }
}
