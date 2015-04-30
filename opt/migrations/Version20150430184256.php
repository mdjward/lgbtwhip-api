<?php

namespace TheLgbtWhip\Api\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150430184256 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(
            'INSERT INTO issues(issue_id, title, description, relevant_act, url, stance, public_whip_date, public_whip_id) VALUES '
                . "(7, 'Remove 12 month blood ban', 'Remove the 12 month deferral of men who have sex with men (MSM) from donating blood and replace it with criteria based on individual risk', NULL, NULL, 1, NULL, NULL), "
                . "(8, 'Asylum for UK LGBT+ people', 'Asylum in the UK for LGBT+ people fleeing persecution', NULL, NULL, 1, NULL, NULL), "
                . "(9, 'Conversion Therapy', 'Make it illegal for medical practitioners, NHS or private, to perform or conduct so-called \"conversion therapy\" on either sexuality or gender identity', NULL, NULL, 1, NULL, NULL), "
                . "(10, 'Trans people support in healthcare', 'Address issues faced by trans people in accessing healthcare. Including but not limited to better training for NHS staff and to properly fund the Gender Identity Clinic service', NULL, NULL, 1, NULL, NULL)"
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DELETE FORM issues WHERE issue_id BETWEEN 6 and 10');
    }
}
