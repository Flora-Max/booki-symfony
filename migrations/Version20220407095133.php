<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220407095133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A8BAC62AF');
        $this->addSql('ALTER TABLE hebergement DROP FOREIGN KEY FK_4852DD9C8BAC62AF');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP INDEX IDX_AC74095A8BAC62AF ON activity');
        $this->addSql('ALTER TABLE activity DROP city_id, DROP image_large, DROP image_medium, DROP image_small');
        $this->addSql('DROP INDEX IDX_4852DD9C8BAC62AF ON hebergement');
        $this->addSql('ALTER TABLE hebergement DROP city_id, DROP trend, DROP image_large, DROP image_medium, DROP image_small');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, postcode INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE activity ADD city_id INT DEFAULT NULL, ADD image_large VARBINARY(255) DEFAULT NULL, ADD image_medium VARBINARY(255) DEFAULT NULL, ADD image_small VARBINARY(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_AC74095A8BAC62AF ON activity (city_id)');
        $this->addSql('ALTER TABLE hebergement ADD city_id INT DEFAULT NULL, ADD trend TINYINT(1) NOT NULL, ADD image_large VARBINARY(255) DEFAULT NULL, ADD image_medium VARBINARY(255) DEFAULT NULL, ADD image_small VARBINARY(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE hebergement ADD CONSTRAINT FK_4852DD9C8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_4852DD9C8BAC62AF ON hebergement (city_id)');
    }
}
