<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230503161336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE info_traite_cow (info_traite_id INT NOT NULL, cow_id INT NOT NULL, INDEX IDX_AC4D7DE893D3E978 (info_traite_id), INDEX IDX_AC4D7DE84B28B8CC (cow_id), PRIMARY KEY(info_traite_id, cow_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE info_traite_cow ADD CONSTRAINT FK_AC4D7DE893D3E978 FOREIGN KEY (info_traite_id) REFERENCES info_traite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE info_traite_cow ADD CONSTRAINT FK_AC4D7DE84B28B8CC FOREIGN KEY (cow_id) REFERENCES cow (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_traite_cow DROP FOREIGN KEY FK_AC4D7DE893D3E978');
        $this->addSql('ALTER TABLE info_traite_cow DROP FOREIGN KEY FK_AC4D7DE84B28B8CC');
        $this->addSql('DROP TABLE info_traite_cow');
    }
}
