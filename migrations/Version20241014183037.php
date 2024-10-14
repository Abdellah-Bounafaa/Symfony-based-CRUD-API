<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241014183037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE devis_voiture (devis_id INT NOT NULL, voiture_id INT NOT NULL, INDEX IDX_7B0C1A5341DEFADA (devis_id), INDEX IDX_7B0C1A53181A8BA (voiture_id), PRIMARY KEY(devis_id, voiture_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE devis_voiture ADD CONSTRAINT FK_7B0C1A5341DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE devis_voiture ADD CONSTRAINT FK_7B0C1A53181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE devis ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_8B27C52B19EB6921 ON devis (client_id)');
        $this->addSql('ALTER TABLE voiture ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_E9E2810F19EB6921 ON voiture (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devis_voiture DROP FOREIGN KEY FK_7B0C1A5341DEFADA');
        $this->addSql('ALTER TABLE devis_voiture DROP FOREIGN KEY FK_7B0C1A53181A8BA');
        $this->addSql('DROP TABLE devis_voiture');
        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B19EB6921');
        $this->addSql('DROP INDEX IDX_8B27C52B19EB6921 ON devis');
        $this->addSql('ALTER TABLE devis DROP client_id');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F19EB6921');
        $this->addSql('DROP INDEX IDX_E9E2810F19EB6921 ON voiture');
        $this->addSql('ALTER TABLE voiture DROP client_id');
    }
}
