<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801151222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE depot (id INT AUTO_INCREMENT NOT NULL, badge_id INT NOT NULL, epci_id INT NOT NULL, access_control_uid VARCHAR(15) NOT NULL, timestamp INT NOT NULL, INDEX IDX_47948BBCF7A2C2FC (badge_id), INDEX IDX_47948BBC4E7C18CB (epci_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBCF7A2C2FC FOREIGN KEY (badge_id) REFERENCES badge (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBC4E7C18CB FOREIGN KEY (epci_id) REFERENCES epci (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBCF7A2C2FC');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBC4E7C18CB');
        $this->addSql('DROP TABLE depot');
    }
}
