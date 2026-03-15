<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260310105453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activation (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(255) NOT NULL, volume INT NOT NULL, date DATETIME NOT NULL, UNIQUE INDEX UNIQ_1C686077D17F50A6 (uuid), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE asset (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, activation_cost DOUBLE PRECISION NOT NULL, volume INT NOT NULL, UNIQUE INDEX UNIQ_2AF5A5CD17F50A6 (uuid), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE availability (date DATETIME NOT NULL, id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3FB7A2BFD17F50A6 (uuid), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE activation');
        $this->addSql('DROP TABLE asset');
        $this->addSql('DROP TABLE availability');
    }
}
