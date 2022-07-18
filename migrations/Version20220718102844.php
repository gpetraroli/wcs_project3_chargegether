<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220718102844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE station_review ADD station_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE station_review ADD CONSTRAINT FK_B6A1922021BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
        $this->addSql('CREATE INDEX IDX_B6A1922021BDB235 ON station_review (station_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE station_review DROP FOREIGN KEY FK_B6A1922021BDB235');
        $this->addSql('DROP INDEX IDX_B6A1922021BDB235 ON station_review');
        $this->addSql('ALTER TABLE station_review DROP station_id');
    }
}
