<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241014223840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client CHANGE date_naissance date_naissance DATETIME NOT NULL');
        $this->addSql('DROP INDEX UNIQ_8B27C52BF55AE19E ON devis');
        $this->addSql('ALTER TABLE devis CHANGE numero numero VARCHAR(255) NOT NULL, CHANGE date_effet date_effet DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client CHANGE date_naissance date_naissance DATE NOT NULL');
        $this->addSql('ALTER TABLE devis CHANGE numero numero VARCHAR(36) NOT NULL, CHANGE date_effet date_effet DATE NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8B27C52BF55AE19E ON devis (numero)');
    }
}
