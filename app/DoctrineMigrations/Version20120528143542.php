<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120528143542 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE Repository ADD updated DATETIME NOT NULL");
        $this->addSql("ALTER TABLE Package ADD repository_id INT DEFAULT NULL, ADD created DATETIME NOT NULL, CHANGE info info LONGTEXT NOT NULL");
        $this->addSql("ALTER TABLE Package ADD CONSTRAINT FK_11D55E0950C9D4F7 FOREIGN KEY (repository_id) REFERENCES Repository (id)");
        $this->addSql("CREATE INDEX IDX_11D55E0950C9D4F7 ON Package (repository_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE Package DROP FOREIGN KEY FK_11D55E0950C9D4F7");
        $this->addSql("DROP INDEX IDX_11D55E0950C9D4F7 ON Package");
        $this->addSql("ALTER TABLE Package DROP repository_id, DROP created, CHANGE info info VARCHAR(255) NOT NULL");
        $this->addSql("ALTER TABLE Repository DROP updated");
    }
}
