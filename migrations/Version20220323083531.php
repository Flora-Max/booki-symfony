<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220323083531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity ADD postcode INT NOT NULL');
        $this->addSql('ALTER TABLE city ADD postcode INT NOT NULL');
        $this->addSql('ALTER TABLE hebergement ADD postcode INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity DROP postcode');
        $this->addSql('ALTER TABLE city DROP postcode');
        $this->addSql('ALTER TABLE hebergement DROP postcode');
    }
}
