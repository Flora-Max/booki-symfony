<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220407144838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hebergement CHANGE image_large image_large LONGTEXT DEFAULT NULL, CHANGE image_medium image_medium LONGTEXT DEFAULT NULL, CHANGE image_small image_small LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hebergement CHANGE image_large image_large LONGBLOB DEFAULT NULL, CHANGE image_medium image_medium LONGBLOB DEFAULT NULL, CHANGE image_small image_small LONGBLOB DEFAULT NULL');
    }
}
