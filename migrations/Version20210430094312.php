<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210430094312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3A0905086');
        $this->addSql('DROP TABLE poste');
        $this->addSql('DROP INDEX IDX_1D1C63B3A0905086 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur CHANGE poste_id roles_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B338C751C4 FOREIGN KEY (roles_id) REFERENCES role (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B338C751C4 ON utilisateur (roles_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE poste (id INT AUTO_INCREMENT NOT NULL, habilitation_id INT DEFAULT NULL, service_id INT DEFAULT NULL, nom VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, autorisation INT NOT NULL, INDEX IDX_7C890FABED5CA9E6 (service_id), INDEX IDX_7C890FAB389712CD (habilitation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE poste ADD CONSTRAINT FK_7C890FAB389712CD FOREIGN KEY (habilitation_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE poste ADD CONSTRAINT FK_7C890FABED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B338C751C4');
        $this->addSql('DROP INDEX IDX_1D1C63B338C751C4 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur CHANGE roles_id poste_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3A0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3A0905086 ON utilisateur (poste_id)');
    }
}
