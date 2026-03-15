<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260310145930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activation_asset (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(255) NOT NULL, activation_id INT NOT NULL, UNIQUE INDEX UNIQ_EC2C790CD17F50A6 (uuid), INDEX IDX_EC2C790C116B3934 (activation_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE activation_asset ADD CONSTRAINT FK_EC2C790C116B3934 FOREIGN KEY (activation_id) REFERENCES activation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activation_asset DROP FOREIGN KEY FK_EC2C790C116B3934');
        $this->addSql('DROP TABLE activation_asset');
    }
}
