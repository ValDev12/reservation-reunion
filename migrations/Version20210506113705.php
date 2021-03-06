<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210506113705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, createur_id INT DEFAULT NULL, salle_id INT DEFAULT NULL, date_d DATETIME NOT NULL, date_f DATETIME NOT NULL, INDEX IDX_42C8495573A201E5 (createur_id), INDEX IDX_42C84955DC304035 (salle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_utilisateur (reservation_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_D170BEEFB83297E7 (reservation_id), INDEX IDX_D170BEEFFB88E14F (utilisateur_id), PRIMARY KEY(reservation_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE old_reservation (id INT AUTO_INCREMENT NOT NULL, createur_id INT DEFAULT NULL, salle_id INT DEFAULT NULL, date_d DATETIME NOT NULL, date_f DATETIME NOT NULL, INDEX IDX_42C8495573A201E5 (createur_id), INDEX IDX_42C84955DC304035 (salle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE old_reservation_utilisateur (reservation_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_D170BEEFB83297E7 (reservation_id), INDEX IDX_D170BEEFFB88E14F (utilisateur_id), PRIMARY KEY(reservation_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, nb_places INT NOT NULL, INDEX IDX_4E977E5CC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle_service (salle_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_CCABF683DC304035 (salle_id), INDEX IDX_CCABF683ED5CA9E6 (service_id), PRIMARY KEY(salle_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, roles_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, identifiant VARCHAR(50) NOT NULL, mdp VARCHAR(50) NOT NULL, INDEX IDX_1D1C63B338C751C4 (roles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495573A201E5 FOREIGN KEY (createur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE reservation_utilisateur ADD CONSTRAINT FK_D170BEEFB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_utilisateur ADD CONSTRAINT FK_D170BEEFFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE old_reservation ADD CONSTRAINT FK_42C8495573A201E6 FOREIGN KEY (createur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE old_reservation ADD CONSTRAINT FK_42C84955DC304036 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE old_reservation_utilisateur ADD CONSTRAINT FK_D170BEEFB83297E8 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE old_reservation_utilisateur ADD CONSTRAINT FK_D170BEEFFB88E14G FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT FK_4E977E5CC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE salle_service ADD CONSTRAINT FK_CCABF683DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salle_service ADD CONSTRAINT FK_CCABF683ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B338C751C4 FOREIGN KEY (roles_id) REFERENCES role (id)');
        $this->addSql('INSERT INTO role (libelle) VALUES ("Administrateur")');
        $this->addSql('INSERT INTO role (libelle) VALUES ("SuperUtilisateur")');
        $this->addSql('INSERT INTO role (libelle) VALUES ("Utilisateur")');
        $this->addSql('INSERT INTO utilisateur (roles_id, nom, prenom, identifiant, mdp) VALUES (1, "Administrateur", "Admin", "admin@gsb.com", "admin123*")');
        $this->addSql('INSERT INTO utilisateur (roles_id, nom, prenom, identifiant, mdp) VALUES (2, "SuperUser", "SuperUser", "super.user@gsb.com", "superUser123*")');
        $this->addSql('INSERT INTO utilisateur (roles_id, nom, prenom, identifiant, mdp) VALUES (3, "User", "User", "user@gsb.com", "user123*")');
        $this->addSql('INSERT INTO users (email, password, is_verified) VALUES ("admin@gsb.com", "$argon2id$v=19$m=65536,t=4,p=1$QXVEcEh3YWk5cGh5ZzdLWg$+7lXY4KVakSlfAQ2P1uV/By89rLDcWv0Rc/9A0t7Ggc", 1)');
        $this->addSql('INSERT INTO users (email, password, is_verified) VALUES ("super.user@gsb.com", "$argon2id$v=19$m=65536,t=4,p=1$SnFUYWRPYy4vcnRnVDBmYQ$A2RA8EZPQ8ckfwYWI+fg5hQYgJV73nn6EwEF7Ku6h5U", 1)');
        $this->addSql('INSERT INTO users (email, password, is_verified) VALUES ("user@gsb.com", "$argon2id$v=19$m=65536,t=4,p=1$LjNqcXR4NXE4dUg0d0w3Qg$W596sWuthv4bJ2IL2qPUXdMyhAJoBYjUwk3sAkBNNY0", 1)');
        $this->addSql('ALTER TABLE utilisateur CHANGE identifiant identifiant VARCHAR(50) NOT NULL, CHANGE mdp mdp VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur CHANGE identifiant identifiant VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mdp mdp VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE reservation_utilisateur DROP FOREIGN KEY FK_D170BEEFB83297E7');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B338C751C4');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955DC304035');
        $this->addSql('ALTER TABLE salle_service DROP FOREIGN KEY FK_CCABF683DC304035');
        $this->addSql('ALTER TABLE salle_service DROP FOREIGN KEY FK_CCABF683ED5CA9E6');
        $this->addSql('ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5CC54C8C93');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495573A201E5');
        $this->addSql('ALTER TABLE reservation_utilisateur DROP FOREIGN KEY FK_D170BEEFFB88E14F');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservation_utilisateur');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE salle_service');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE utilisateur');
    }
}
