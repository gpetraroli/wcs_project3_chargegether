<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220627142712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_vehicle (user_id INT NOT NULL, vehicle_id INT NOT NULL, INDEX IDX_438DFA8CA76ED395 (user_id), INDEX IDX_438DFA8C545317D1 (vehicle_id), PRIMARY KEY(user_id, vehicle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_vehicle ADD CONSTRAINT FK_438DFA8CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_vehicle ADD CONSTRAINT FK_438DFA8C545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE station ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE station ADD CONSTRAINT FK_9F39F8B17E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9F39F8B17E3C61F9 ON station (owner_id)');
        $this->addSql('ALTER TABLE vehicle ADD image VARCHAR(255) NOT NULL, CHANGE battery_capacity battery_capacity VARCHAR(255) NOT NULL, CHANGE battery_power battery_power VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_vehicle');
        $this->addSql('ALTER TABLE station DROP FOREIGN KEY FK_9F39F8B17E3C61F9');
        $this->addSql('DROP INDEX IDX_9F39F8B17E3C61F9 ON station');
        $this->addSql('ALTER TABLE station DROP owner_id');
        $this->addSql('ALTER TABLE vehicle DROP image, CHANGE battery_capacity battery_capacity SMALLINT NOT NULL, CHANGE battery_power battery_power SMALLINT NOT NULL');
    }
}
