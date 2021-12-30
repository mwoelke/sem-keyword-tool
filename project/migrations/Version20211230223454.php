<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211230223454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment_rule DROP FOREIGN KEY FK_1DDE6150115F0EE5');
        $this->addSql('DROP INDEX IDX_1DDE6150115F0EE5 ON assignment_rule');
        $this->addSql('ALTER TABLE assignment_rule DROP domain_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment_rule ADD domain_id INT NOT NULL');
        $this->addSql('ALTER TABLE assignment_rule ADD CONSTRAINT FK_1DDE6150115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id)');
        $this->addSql('CREATE INDEX IDX_1DDE6150115F0EE5 ON assignment_rule (domain_id)');
    }
}
