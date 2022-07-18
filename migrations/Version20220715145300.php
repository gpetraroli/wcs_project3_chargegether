<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220715145300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking CHANGE start_res start_res DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE end_res end_res DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE start_loc start_loc DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE end_loc end_loc DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE notification ADD need_confirmation TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking CHANGE start_res start_res DATETIME NOT NULL, CHANGE end_res end_res DATETIME NOT NULL, CHANGE start_loc start_loc DATETIME DEFAULT NULL, CHANGE end_loc end_loc DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE notification DROP need_confirmation');
    }
}
