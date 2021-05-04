<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210504085706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, roles_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, identifiant VARCHAR(50) NOT NULL, mdp VARCHAR(50) NOT NULL, INDEX IDX_1D1C63B338C751C4 (roles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B338C751C4 FOREIGN KEY (roles_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495573A201E5 FOREIGN KEY (createur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE reservation_utilisateur ADD CONSTRAINT FK_D170BEEFB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_utilisateur ADD CONSTRAINT FK_D170BEEFFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT FK_4E977E5CC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE salle_service ADD CONSTRAINT FK_CCABF683DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salle_service ADD CONSTRAINT FK_CCABF683ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495573A201E5');
        $this->addSql('ALTER TABLE reservation_utilisateur DROP FOREIGN KEY FK_D170BEEFFB88E14F');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955DC304035');
        $this->addSql('ALTER TABLE reservation_utilisateur DROP FOREIGN KEY FK_D170BEEFB83297E7');
        $this->addSql('ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5CC54C8C93');
        $this->addSql('ALTER TABLE salle_service DROP FOREIGN KEY FK_CCABF683DC304035');
        $this->addSql('ALTER TABLE salle_service DROP FOREIGN KEY FK_CCABF683ED5CA9E6');
    }
}
