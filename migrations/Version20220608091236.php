<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608091236 extends AbstractMigration
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
        $this->addSql('CREATE TABLE station (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(255) NOT NULL, plug_type VARCHAR(45) NOT NULL, power SMALLINT NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station_review (id INT AUTO_INCREMENT NOT NULL, rate SMALLINT NOT NULL, body LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, brand VARCHAR(80) NOT NULL, model VARCHAR(80) NOT NULL, battery_capacity SMALLINT NOT NULL, plug_type VARCHAR(45) NOT NULL, battery_power SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD user_name VARCHAR(45) NOT NULL, ADD first_name VARCHAR(80) NOT NULL, ADD last_name VARCHAR(80) NOT NULL, DROP lastname, DROP firstname, DROP username, CHANGE password password VARCHAR(500) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE avatar avatar VARCHAR(255) NOT NULL, CHANGE birthdate birth_date DATE NOT NULL, CHANGE phonenumber phone_number VARCHAR(20) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6496B01BC5B ON user (phone_number)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE station');
        $this->addSql('DROP TABLE station_review');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP INDEX UNIQ_8D93D6496B01BC5B ON user');
        $this->addSql('ALTER TABLE user ADD lastname VARCHAR(80) NOT NULL, ADD firstname VARCHAR(80) NOT NULL, ADD username VARCHAR(45) DEFAULT NULL, DROP user_name, DROP first_name, DROP last_name, CHANGE password password VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(180) NOT NULL, CHANGE avatar avatar VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE birth_date birthdate DATE NOT NULL, CHANGE phone_number phonenumber VARCHAR(20) NOT NULL');
    }
}
