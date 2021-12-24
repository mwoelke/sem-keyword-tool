<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211117131314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE keywords_keywordgroups (keyword_id INT NOT NULL, keyword_group_id INT NOT NULL, INDEX IDX_307D60E4115D4552 (keyword_id), INDEX IDX_307D60E46F3F1416 (keyword_group_id), PRIMARY KEY(keyword_id, keyword_group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE keywords_keywordgroups ADD CONSTRAINT FK_307D60E4115D4552 FOREIGN KEY (keyword_id) REFERENCES keyword (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE keywords_keywordgroups ADD CONSTRAINT FK_307D60E46F3F1416 FOREIGN KEY (keyword_group_id) REFERENCES keyword_group (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE keyword_group_keyword');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE keyword_group_keyword (id INT AUTO_INCREMENT NOT NULL, keyword_id INT NOT NULL, keyword_group_id INT NOT NULL, INDEX IDX_711F6A0D115D4552 (keyword_id), INDEX IDX_711F6A0D6F3F1416 (keyword_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE keyword_group_keyword ADD CONSTRAINT FK_711F6A0D115D4552 FOREIGN KEY (keyword_id) REFERENCES keyword (id)');
        $this->addSql('ALTER TABLE keyword_group_keyword ADD CONSTRAINT FK_711F6A0D6F3F1416 FOREIGN KEY (keyword_group_id) REFERENCES keyword_group (id)');
        $this->addSql('DROP TABLE keywords_keywordgroups');
    }
}
