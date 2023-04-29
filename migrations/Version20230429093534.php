<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230429093534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE breed (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE health (id INT AUTO_INCREMENT NOT NULL, state VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info_traite (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(50) DEFAULT NULL, action VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pesee (id INT AUTO_INCREMENT NOT NULL, ref_cow_id INT NOT NULL, volume DOUBLE PRECISION NOT NULL, date DATE NOT NULL, INDEX IDX_40EDCCDF3E31D035 (ref_cow_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pesee ADD CONSTRAINT FK_40EDCCDF3E31D035 FOREIGN KEY (ref_cow_id) REFERENCES cow (id)');
        $this->addSql('ALTER TABLE cow ADD breed_id INT DEFAULT NULL, DROP breed');
        $this->addSql('ALTER TABLE cow ADD CONSTRAINT FK_99D43F9CA8B4A30F FOREIGN KEY (breed_id) REFERENCES breed (id)');
        $this->addSql('CREATE INDEX IDX_99D43F9CA8B4A30F ON cow (breed_id)');
        $this->addSql('ALTER TABLE herd ADD ref_food_unit_id INT NOT NULL');
        $this->addSql('ALTER TABLE herd ADD CONSTRAINT FK_C61CB70E53D66AC6 FOREIGN KEY (ref_food_unit_id) REFERENCES food_unit (id)');
        $this->addSql('CREATE INDEX IDX_C61CB70E53D66AC6 ON herd (ref_food_unit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cow DROP FOREIGN KEY FK_99D43F9CA8B4A30F');
        $this->addSql('ALTER TABLE pesee DROP FOREIGN KEY FK_40EDCCDF3E31D035');
        $this->addSql('DROP TABLE breed');
        $this->addSql('DROP TABLE health');
        $this->addSql('DROP TABLE info_traite');
        $this->addSql('DROP TABLE pesee');
        $this->addSql('DROP INDEX IDX_99D43F9CA8B4A30F ON cow');
        $this->addSql('ALTER TABLE cow ADD breed VARCHAR(50) NOT NULL, DROP breed_id');
        $this->addSql('ALTER TABLE herd DROP FOREIGN KEY FK_C61CB70E53D66AC6');
        $this->addSql('DROP INDEX IDX_C61CB70E53D66AC6 ON herd');
        $this->addSql('ALTER TABLE herd DROP ref_food_unit_id');
    }
}
