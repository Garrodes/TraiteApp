<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230505190002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE herd DROP FOREIGN KEY FK_C61CB70E53D66AC6');
        $this->addSql('DROP INDEX IDX_C61CB70E53D66AC6 ON herd');
        $this->addSql('ALTER TABLE herd ADD water DOUBLE PRECISION NOT NULL, ADD food DOUBLE PRECISION NOT NULL, DROP water_neededforone, DROP food_neededforone, CHANGE ref_food_unit_id food_unit_id INT NOT NULL');
        $this->addSql('ALTER TABLE herd ADD CONSTRAINT FK_C61CB70EB722AC35 FOREIGN KEY (food_unit_id) REFERENCES food_unit (id)');
        $this->addSql('CREATE INDEX IDX_C61CB70EB722AC35 ON herd (food_unit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE herd DROP FOREIGN KEY FK_C61CB70EB722AC35');
        $this->addSql('DROP INDEX IDX_C61CB70EB722AC35 ON herd');
        $this->addSql('ALTER TABLE herd ADD water_neededforone DOUBLE PRECISION NOT NULL, ADD food_neededforone DOUBLE PRECISION NOT NULL, DROP water, DROP food, CHANGE food_unit_id ref_food_unit_id INT NOT NULL');
        $this->addSql('ALTER TABLE herd ADD CONSTRAINT FK_C61CB70E53D66AC6 FOREIGN KEY (ref_food_unit_id) REFERENCES food_unit (id)');
        $this->addSql('CREATE INDEX IDX_C61CB70E53D66AC6 ON herd (ref_food_unit_id)');
    }
}
