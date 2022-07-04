<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220704093754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE station ADD coordinates JSON NOT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649545317D1');
        $this->addSql('DROP INDEX IDX_8D93D649545317D1 ON user');
        $this->addSql('ALTER TABLE user DROP vehicle_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE station DROP coordinates');
        $this->addSql('ALTER TABLE user ADD vehicle_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649545317D1 ON user (vehicle_id)');
    }
}
