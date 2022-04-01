<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220325134459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hebergement DROP FOREIGN KEY FK_4852DD9CB83297E7');
        $this->addSql('DROP INDEX IDX_4852DD9CB83297E7 ON hebergement');
        $this->addSql('ALTER TABLE hebergement DROP reservation_id');
        $this->addSql('ALTER TABLE reservation ADD hebergement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495523BB0F66 FOREIGN KEY (hebergement_id) REFERENCES hebergement (id)');
        $this->addSql('CREATE INDEX IDX_42C8495523BB0F66 ON reservation (hebergement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hebergement ADD reservation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hebergement ADD CONSTRAINT FK_4852DD9CB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('CREATE INDEX IDX_4852DD9CB83297E7 ON hebergement (reservation_id)');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495523BB0F66');
        $this->addSql('DROP INDEX IDX_42C8495523BB0F66 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP hebergement_id');
    }
}
