<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230505051655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE herd ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE herd ADD CONSTRAINT FK_C61CB70EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C61CB70EA76ED395 ON herd (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE herd DROP FOREIGN KEY FK_C61CB70EA76ED395');
        $this->addSql('DROP INDEX IDX_C61CB70EA76ED395 ON herd');
        $this->addSql('ALTER TABLE herd DROP user_id');
    }
}
