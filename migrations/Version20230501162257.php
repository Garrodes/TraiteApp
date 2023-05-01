<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230501162257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, full_name VARCHAR(50) NOT NULL, pseudo VARCHAR(50) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cow ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE cow ADD CONSTRAINT FK_99D43F9CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_99D43F9CA76ED395 ON cow (user_id)');
        $this->addSql('ALTER TABLE volume_cow_herd ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE volume_cow_herd ADD CONSTRAINT FK_685FAFAEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_685FAFAEA76ED395 ON volume_cow_herd (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cow DROP FOREIGN KEY FK_99D43F9CA76ED395');
        $this->addSql('ALTER TABLE volume_cow_herd DROP FOREIGN KEY FK_685FAFAEA76ED395');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_99D43F9CA76ED395 ON cow');
        $this->addSql('ALTER TABLE cow DROP user_id');
        $this->addSql('DROP INDEX IDX_685FAFAEA76ED395 ON volume_cow_herd');
        $this->addSql('ALTER TABLE volume_cow_herd DROP user_id');
    }
}
