<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211101134344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE domain (id INT AUTO_INCREMENT NOT NULL, domain VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE keyword (id INT AUTO_INCREMENT NOT NULL, domain_id INT NOT NULL, keyword VARCHAR(1000) NOT NULL, INDEX IDX_5A93713B115F0EE5 (domain_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE keyword_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE keyword_group_keyword (id INT AUTO_INCREMENT NOT NULL, keyword_id INT NOT NULL, keyword_group_id INT NOT NULL, INDEX IDX_711F6A0D115D4552 (keyword_id), INDEX IDX_711F6A0D6F3F1416 (keyword_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE keyword ADD CONSTRAINT FK_5A93713B115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id)');
        $this->addSql('ALTER TABLE keyword_group_keyword ADD CONSTRAINT FK_711F6A0D115D4552 FOREIGN KEY (keyword_id) REFERENCES keyword (id)');
        $this->addSql('ALTER TABLE keyword_group_keyword ADD CONSTRAINT FK_711F6A0D6F3F1416 FOREIGN KEY (keyword_group_id) REFERENCES keyword_group (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE keyword DROP FOREIGN KEY FK_5A93713B115F0EE5');
        $this->addSql('ALTER TABLE keyword_group_keyword DROP FOREIGN KEY FK_711F6A0D115D4552');
        $this->addSql('ALTER TABLE keyword_group_keyword DROP FOREIGN KEY FK_711F6A0D6F3F1416');
        $this->addSql('DROP TABLE domain');
        $this->addSql('DROP TABLE keyword');
        $this->addSql('DROP TABLE keyword_group');
        $this->addSql('DROP TABLE keyword_group_keyword');
        $this->addSql('DROP TABLE user');
    }
}
