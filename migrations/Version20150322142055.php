<?php

namespace TheLgbtWhip\Api\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150322142055 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(
            'INSERT INTO issues(issue_id, title, description, relevant_act, url, stance, public_whip_date, public_whip_id) VALUES '
                . "(1, 'Reduce age of consent for homosexual acts to 16', 'To equalize the age of consent between homosexual and heterosexual acts', 'Crime and Disorder Bill — Reduce age of consent for homosexual acts to 16 — 22 Jun 1998', 'http://www.publicwhip.org.uk/division.php?date=1998-06-22&number=311', 1, '1998-06-22', '311'), "
                . "(2, 'Repeal of section 28', 'To equalize the age of consent between homosexual and heterosexual acts', 'Repeal of Section 28 of Local Government Act 1986', 'http://www.publicwhip.org.uk/division.php?date=2003-03-10&number=111', 1, '2003-03-10', '111'), "
                . "(3, 'Introduction of Civil Partnerships', 'Civil Partnerships Bill [Lords] — Third Reading', 'Civil Partnerships Bill', 'http://www.publicwhip.org.uk/division.php?date=2004-11-09&number=315', 1, '2004-11-09', '315'), "
                . "(4, 'Equality Act (Sexual Orientation) Regulations', 'This Act allows the Secretary of State to make regulations defining discrimination and harassment on grounds of sexual orientation, create criminal offences, and provide for exceptions.', 'Equality Act (Sexual Orientation) Regulations', 'http://www.publicwhip.org.uk/division.php?date=2007-03-19&number=79', 1, '2007-03-19', '79'), "
                . "(5, 'IVF treatment for lesbian couples', 'Requiring the need for both a father and a mother to be considered when taking account of the welfare of a child who may be born as a result of fertility treatment. Instead, the law will stipulate the need for \"supportive parenting\".', 'Human Fertilisation and Embryology Bill — Fertility treatment requires father and mother', 'http://www.publicwhip.org.uk/division.php?date=2008-05-20&number=197', 0, '2008-05-20', '197'), "
                . "(6, 'Same-sex Marriage', 'Under the law as it was at the time of this vote marriage could only be between a man and a woman. Same sex couples (and only same sex couples) could register a civil partnership under the Civil Partnership Act 2004.  Key elements of the Bill provide that same sex couples can get married in England and Wales.', 'Marriage (Same-sex Couples) Bill', 'http://www.publicwhip.org.uk/division.php?date=2013-05-21&number=11', 1, '2013-05-21', '11')"
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DELETE FROM issues WHERE issue_id BETWEEN 1 AND 6');
        
        $this->addSql('ALTER TABLE issues AUTO_INCREMENT = 0;');
    }
}
