<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120524121642 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE Repository ADD owner_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE Repository ADD CONSTRAINT FK_13A3541D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id)");
        $this->addSql("CREATE INDEX IDX_13A3541D7E3C61F9 ON Repository (owner_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE Repository DROP FOREIGN KEY FK_13A3541D7E3C61F9");
        $this->addSql("DROP INDEX IDX_13A3541D7E3C61F9 ON Repository");
        $this->addSql("ALTER TABLE Repository DROP owner_id");
    }
}