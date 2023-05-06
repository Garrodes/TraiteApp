<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230506060558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pesee DROP FOREIGN KEY FK_40EDCCDF3E31D035');
        $this->addSql('DROP INDEX IDX_40EDCCDF3E31D035 ON pesee');
        $this->addSql('ALTER TABLE pesee CHANGE ref_cow_id cow_id INT NOT NULL');
        $this->addSql('ALTER TABLE pesee ADD CONSTRAINT FK_40EDCCDF4B28B8CC FOREIGN KEY (cow_id) REFERENCES cow (id)');
        $this->addSql('CREATE INDEX IDX_40EDCCDF4B28B8CC ON pesee (cow_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pesee DROP FOREIGN KEY FK_40EDCCDF4B28B8CC');
        $this->addSql('DROP INDEX IDX_40EDCCDF4B28B8CC ON pesee');
        $this->addSql('ALTER TABLE pesee CHANGE cow_id ref_cow_id INT NOT NULL');
        $this->addSql('ALTER TABLE pesee ADD CONSTRAINT FK_40EDCCDF3E31D035 FOREIGN KEY (ref_cow_id) REFERENCES cow (id)');
        $this->addSql('CREATE INDEX IDX_40EDCCDF3E31D035 ON pesee (ref_cow_id)');
    }
}
