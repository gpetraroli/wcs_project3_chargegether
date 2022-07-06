<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705141036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking ADD vehicle_id INT DEFAULT NULL, ADD station_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE21BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE545317D1 ON booking (vehicle_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE21BDB235 ON booking (station_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE545317D1');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE21BDB235');
        $this->addSql('DROP INDEX IDX_E00CEDDE545317D1 ON booking');
        $this->addSql('DROP INDEX IDX_E00CEDDE21BDB235 ON booking');
        $this->addSql('ALTER TABLE booking DROP vehicle_id, DROP station_id');
    }
}
