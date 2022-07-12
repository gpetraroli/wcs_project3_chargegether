<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220704091224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, start_res DATETIME NOT NULL, end_res DATETIME NOT NULL, start_loc DATETIME NOT NULL, end_loc DATETIME NOT NULL, battery_level_start SMALLINT NOT NULL, battery_level_end SMALLINT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, is_read TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, address VARCHAR(255) NOT NULL, coordinates JSON NOT NULL, plug_type VARCHAR(45) NOT NULL, power SMALLINT NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_9F39F8B17E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station_review (id INT AUTO_INCREMENT NOT NULL, rate SMALLINT NOT NULL, body LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, user_name VARCHAR(45) NOT NULL, password VARCHAR(500) NOT NULL, roles JSON NOT NULL, first_name VARCHAR(80) NOT NULL, last_name VARCHAR(80) NOT NULL, birth_date DATE NOT NULL, address VARCHAR(255) NOT NULL, zipcode VARCHAR(10) NOT NULL, city VARCHAR(80) NOT NULL, country VARCHAR(80) NOT NULL, gender VARCHAR(45) NOT NULL, phone_number VARCHAR(20) NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D6496B01BC5B (phone_number), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_vehicle (user_id INT NOT NULL, vehicle_id INT NOT NULL, INDEX IDX_438DFA8CA76ED395 (user_id), INDEX IDX_438DFA8C545317D1 (vehicle_id), PRIMARY KEY(user_id, vehicle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, brand VARCHAR(80) NOT NULL, model VARCHAR(80) NOT NULL, battery_capacity VARCHAR(255) NOT NULL, plug_type VARCHAR(45) NOT NULL, battery_power VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE station ADD CONSTRAINT FK_9F39F8B17E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_vehicle ADD CONSTRAINT FK_438DFA8CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_vehicle ADD CONSTRAINT FK_438DFA8C545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE station DROP FOREIGN KEY FK_9F39F8B17E3C61F9');
        $this->addSql('ALTER TABLE user_vehicle DROP FOREIGN KEY FK_438DFA8CA76ED395');
        $this->addSql('ALTER TABLE user_vehicle DROP FOREIGN KEY FK_438DFA8C545317D1');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE station');
        $this->addSql('DROP TABLE station_review');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_vehicle');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
