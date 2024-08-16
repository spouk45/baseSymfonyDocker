<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240816132023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE access_control (id INT AUTO_INCREMENT NOT NULL, epci_id INT NOT NULL, uid VARCHAR(50) NOT NULL, INDEX IDX_25FEF65E4E7C18CB (epci_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE badge (id INT AUTO_INCREMENT NOT NULL, epci_id INT NOT NULL, name VARCHAR(50) NOT NULL, authorized TINYINT(1) NOT NULL, INDEX IDX_FEF0481D4E7C18CB (epci_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE depot (id INT AUTO_INCREMENT NOT NULL, badge_id INT NOT NULL, epci_id INT NOT NULL, access_control_uid VARCHAR(15) NOT NULL, timestamp INT NOT NULL, INDEX IDX_47948BBCF7A2C2FC (badge_id), INDEX IDX_47948BBC4E7C18CB (epci_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE epci (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, token VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3F351E55F37A13B (token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE access_control ADD CONSTRAINT FK_25FEF65E4E7C18CB FOREIGN KEY (epci_id) REFERENCES epci (id)');
        $this->addSql('ALTER TABLE badge ADD CONSTRAINT FK_FEF0481D4E7C18CB FOREIGN KEY (epci_id) REFERENCES epci (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBCF7A2C2FC FOREIGN KEY (badge_id) REFERENCES badge (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBC4E7C18CB FOREIGN KEY (epci_id) REFERENCES epci (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE access_control DROP FOREIGN KEY FK_25FEF65E4E7C18CB');
        $this->addSql('ALTER TABLE badge DROP FOREIGN KEY FK_FEF0481D4E7C18CB');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBCF7A2C2FC');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBC4E7C18CB');
        $this->addSql('DROP TABLE access_control');
        $this->addSql('DROP TABLE badge');
        $this->addSql('DROP TABLE depot');
        $this->addSql('DROP TABLE epci');
    }
}
