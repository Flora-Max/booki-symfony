<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220322094726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE hebergement_category');
        $this->addSql('ALTER TABLE hebergement ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hebergement ADD CONSTRAINT FK_4852DD9C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_4852DD9C12469DE2 ON hebergement (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hebergement_category (hebergement_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_CE74FED923BB0F66 (hebergement_id), INDEX IDX_CE74FED912469DE2 (category_id), PRIMARY KEY(hebergement_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE hebergement_category ADD CONSTRAINT FK_CE74FED912469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hebergement_category ADD CONSTRAINT FK_CE74FED923BB0F66 FOREIGN KEY (hebergement_id) REFERENCES hebergement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hebergement DROP FOREIGN KEY FK_4852DD9C12469DE2');
        $this->addSql('DROP INDEX IDX_4852DD9C12469DE2 ON hebergement');
        $this->addSql('ALTER TABLE hebergement DROP category_id');
    }
}
