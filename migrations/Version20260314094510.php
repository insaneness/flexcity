<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260314094510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activation_asset ADD asset_id INT NOT NULL');
        $this->addSql('ALTER TABLE activation_asset ADD CONSTRAINT FK_EC2C790C5DA1941 FOREIGN KEY (asset_id) REFERENCES asset (id)');
        $this->addSql('CREATE INDEX IDX_EC2C790C5DA1941 ON activation_asset (asset_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activation_asset DROP FOREIGN KEY FK_EC2C790C5DA1941');
        $this->addSql('DROP INDEX IDX_EC2C790C5DA1941 ON activation_asset');
        $this->addSql('ALTER TABLE activation_asset DROP asset_id');
    }
}
