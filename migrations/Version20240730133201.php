<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240730133201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE epci (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, token VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE badge ADD epci_id INT NOT NULL');
        $this->addSql('ALTER TABLE badge ADD CONSTRAINT FK_FEF0481D4E7C18CB FOREIGN KEY (epci_id) REFERENCES epci (id)');
        $this->addSql('CREATE INDEX IDX_FEF0481D4E7C18CB ON badge (epci_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE badge DROP FOREIGN KEY FK_FEF0481D4E7C18CB');
        $this->addSql('DROP TABLE epci');
        $this->addSql('DROP INDEX IDX_FEF0481D4E7C18CB ON badge');
        $this->addSql('ALTER TABLE badge DROP epci_id');
    }
}
