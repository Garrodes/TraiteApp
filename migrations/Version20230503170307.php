<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230503170307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_traite ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE info_traite ADD CONSTRAINT FK_DDA94B61A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DDA94B61A76ED395 ON info_traite (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_traite DROP FOREIGN KEY FK_DDA94B61A76ED395');
        $this->addSql('DROP INDEX IDX_DDA94B61A76ED395 ON info_traite');
        $this->addSql('ALTER TABLE info_traite DROP user_id');
    }
}
