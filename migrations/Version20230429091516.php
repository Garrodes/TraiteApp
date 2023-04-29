<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230429091516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE food_unit (id INT AUTO_INCREMENT NOT NULL, unit VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE herd (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, water_neededforone DOUBLE PRECISION NOT NULL, food_neededforone DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cow ADD ref_herd_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cow ADD CONSTRAINT FK_99D43F9C174EDF1C FOREIGN KEY (ref_herd_id) REFERENCES herd (id)');
        $this->addSql('CREATE INDEX IDX_99D43F9C174EDF1C ON cow (ref_herd_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cow DROP FOREIGN KEY FK_99D43F9C174EDF1C');
        $this->addSql('DROP TABLE food_unit');
        $this->addSql('DROP TABLE herd');
        $this->addSql('DROP INDEX IDX_99D43F9C174EDF1C ON cow');
        $this->addSql('ALTER TABLE cow DROP ref_herd_id');
    }
}
