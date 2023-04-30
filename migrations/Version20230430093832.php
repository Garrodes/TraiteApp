<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230430093832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cow_health DROP FOREIGN KEY FK_56901A174B28B8CC');
        $this->addSql('ALTER TABLE cow_health DROP FOREIGN KEY FK_56901A17A08E947C');
        $this->addSql('ALTER TABLE cow_info_traite DROP FOREIGN KEY FK_619F528E4B28B8CC');
        $this->addSql('ALTER TABLE cow_info_traite DROP FOREIGN KEY FK_619F528E93D3E978');
        $this->addSql('DROP TABLE cow_health');
        $this->addSql('DROP TABLE cow_info_traite');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cow_health (cow_id INT NOT NULL, health_id INT NOT NULL, INDEX IDX_56901A174B28B8CC (cow_id), INDEX IDX_56901A17A08E947C (health_id), PRIMARY KEY(cow_id, health_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE cow_info_traite (cow_id INT NOT NULL, info_traite_id INT NOT NULL, INDEX IDX_619F528E93D3E978 (info_traite_id), INDEX IDX_619F528E4B28B8CC (cow_id), PRIMARY KEY(cow_id, info_traite_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cow_health ADD CONSTRAINT FK_56901A174B28B8CC FOREIGN KEY (cow_id) REFERENCES cow (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cow_health ADD CONSTRAINT FK_56901A17A08E947C FOREIGN KEY (health_id) REFERENCES health (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cow_info_traite ADD CONSTRAINT FK_619F528E4B28B8CC FOREIGN KEY (cow_id) REFERENCES cow (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cow_info_traite ADD CONSTRAINT FK_619F528E93D3E978 FOREIGN KEY (info_traite_id) REFERENCES info_traite (id) ON DELETE CASCADE');
    }
}
