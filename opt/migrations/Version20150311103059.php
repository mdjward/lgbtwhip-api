<?php

namespace TheLgbtWhip\Api\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150311103059 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE constituencies (constituency_id INT AUTO_INCREMENT NOT NULL, name VARCHAR(200) NOT NULL, PRIMARY KEY(constituency_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE votes (vote_id INT AUTO_INCREMENT NOT NULL, issue_id INT NOT NULL, candidate_id INT NOT NULL, vote_cast VARCHAR(25) NOT NULL, INDEX IDX_518B7ACF5E7AA58C (issue_id), INDEX IDX_518B7ACF91BD8781 (candidate_id), INDEX issue_candidate (issue_id, candidate_id), PRIMARY KEY(vote_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidates (candidate_id INT AUTO_INCREMENT NOT NULL, party_id INT DEFAULT NULL, constituency_id INT NOT NULL, name VARCHAR(255) NOT NULL, twitter VARCHAR(100) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, wikipedia VARCHAR(512) DEFAULT NULL, email VARCHAR(256) NOT NULL, photo LONGBLOB DEFAULT NULL, INDEX IDX_6A77F80C213C1059 (party_id), INDEX IDX_6A77F80C693B626F (constituency_id), INDEX name (name), INDEX email (email), PRIMARY KEY(candidate_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE issues (issue_id INT AUTO_INCREMENT NOT NULL, title VARCHAR(512) NOT NULL, description LONGTEXT DEFAULT NULL, relevant_act VARCHAR(512) DEFAULT NULL, url VARCHAR(512) DEFAULT NULL, stance TINYINT(1) NOT NULL, public_whip_id INT DEFAULT NULL, public_whip_date DATE DEFAULT NULL, PRIMARY KEY(issue_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE views (view_id INT AUTO_INCREMENT NOT NULL, candidate_id INT DEFAULT NULL, issue_id INT DEFAULT NULL, historic_stance LONGTEXT NOT NULL, current_stance LONGTEXT NOT NULL, INDEX IDX_11F09C8791BD8781 (candidate_id), INDEX IDX_11F09C875E7AA58C (issue_id), PRIMARY KEY(view_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parties (party_id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, logo LONGBLOB DEFAULT NULL, website_url VARCHAR(255) NOT NULL, colour VARCHAR(10) NOT NULL, INDEX name (name), PRIMARY KEY(party_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE terms (term_id INT AUTO_INCREMENT NOT NULL, candidate_id INT NOT NULL, party_id INT DEFAULT NULL, start_date DATE NOT NULL, end_date DATE DEFAULT NULL, INDEX IDX_88A23F7191BD8781 (candidate_id), INDEX IDX_88A23F71213C1059 (party_id), PRIMARY KEY(term_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE votes ADD CONSTRAINT FK_518B7ACF5E7AA58C FOREIGN KEY (issue_id) REFERENCES issues (issue_id)');
        $this->addSql('ALTER TABLE votes ADD CONSTRAINT FK_518B7ACF91BD8781 FOREIGN KEY (candidate_id) REFERENCES candidates (candidate_id)');
        $this->addSql('ALTER TABLE candidates ADD CONSTRAINT FK_6A77F80C213C1059 FOREIGN KEY (party_id) REFERENCES parties (party_id)');
        $this->addSql('ALTER TABLE candidates ADD CONSTRAINT FK_6A77F80C693B626F FOREIGN KEY (constituency_id) REFERENCES constituencies (constituency_id)');
        $this->addSql('ALTER TABLE views ADD CONSTRAINT FK_11F09C8791BD8781 FOREIGN KEY (candidate_id) REFERENCES candidates (candidate_id)');
        $this->addSql('ALTER TABLE views ADD CONSTRAINT FK_11F09C875E7AA58C FOREIGN KEY (issue_id) REFERENCES issues (issue_id)');
        $this->addSql('ALTER TABLE terms ADD CONSTRAINT FK_88A23F7191BD8781 FOREIGN KEY (candidate_id) REFERENCES candidates (candidate_id)');
        $this->addSql('ALTER TABLE terms ADD CONSTRAINT FK_88A23F71213C1059 FOREIGN KEY (party_id) REFERENCES parties (party_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE candidates DROP FOREIGN KEY FK_6A77F80C693B626F');
        $this->addSql('ALTER TABLE votes DROP FOREIGN KEY FK_518B7ACF91BD8781');
        $this->addSql('ALTER TABLE views DROP FOREIGN KEY FK_11F09C8791BD8781');
        $this->addSql('ALTER TABLE terms DROP FOREIGN KEY FK_88A23F7191BD8781');
        $this->addSql('ALTER TABLE votes DROP FOREIGN KEY FK_518B7ACF5E7AA58C');
        $this->addSql('ALTER TABLE views DROP FOREIGN KEY FK_11F09C875E7AA58C');
        $this->addSql('ALTER TABLE candidates DROP FOREIGN KEY FK_6A77F80C213C1059');
        $this->addSql('ALTER TABLE terms DROP FOREIGN KEY FK_88A23F71213C1059');
        $this->addSql('DROP TABLE constituencies');
        $this->addSql('DROP TABLE votes');
        $this->addSql('DROP TABLE candidates');
        $this->addSql('DROP TABLE issues');
        $this->addSql('DROP TABLE views');
        $this->addSql('DROP TABLE parties');
        $this->addSql('DROP TABLE terms');
    }
}
