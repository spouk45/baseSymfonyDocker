<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240730154310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE token (id INT AUTO_INCREMENT NOT NULL, epci_id INT NOT NULL, value VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_5F37A13B4E7C18CB (epci_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE token ADD CONSTRAINT FK_5F37A13B4E7C18CB FOREIGN KEY (epci_id) REFERENCES epci (id)');
        $this->addSql('ALTER TABLE epci DROP token');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE token DROP FOREIGN KEY FK_5F37A13B4E7C18CB');
        $this->addSql('DROP TABLE token');
        $this->addSql('ALTER TABLE epci ADD token VARCHAR(50) DEFAULT NULL');
    }
}
