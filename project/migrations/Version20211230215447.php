<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211230215447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment_rule ADD keyword_group_id INT NOT NULL');
        $this->addSql('ALTER TABLE assignment_rule ADD CONSTRAINT FK_1DDE61506F3F1416 FOREIGN KEY (keyword_group_id) REFERENCES keyword_group (id)');
        $this->addSql('CREATE INDEX IDX_1DDE61506F3F1416 ON assignment_rule (keyword_group_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment_rule DROP FOREIGN KEY FK_1DDE61506F3F1416');
        $this->addSql('DROP INDEX IDX_1DDE61506F3F1416 ON assignment_rule');
        $this->addSql('ALTER TABLE assignment_rule DROP keyword_group_id');
    }
}
