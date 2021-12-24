<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211119130529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE keyword_group ADD domain_id INT NOT NULL');
        $this->addSql('ALTER TABLE keyword_group ADD CONSTRAINT FK_83297364115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id)');
        $this->addSql('CREATE INDEX IDX_83297364115F0EE5 ON keyword_group (domain_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE keyword_group DROP FOREIGN KEY FK_83297364115F0EE5');
        $this->addSql('DROP INDEX IDX_83297364115F0EE5 ON keyword_group');
        $this->addSql('ALTER TABLE keyword_group DROP domain_id');
    }
}
