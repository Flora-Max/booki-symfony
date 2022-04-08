<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220406094232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity ADD image_large LONGBLOB DEFAULT NULL, ADD image_medium LONGBLOB DEFAULT NULL, ADD image_small LONGBLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE hebergement ADD image_large LONGBLOB DEFAULT NULL, ADD image_medium LONGBLOB DEFAULT NULL, ADD image_small LONGBLOB DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity DROP image_large, DROP image_medium, DROP image_small');
        $this->addSql('ALTER TABLE hebergement DROP image_large, DROP image_medium, DROP image_small');
    }
}
