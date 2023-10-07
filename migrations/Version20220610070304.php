<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220610070304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE doctorant (id INT AUTO_INCREMENT NOT NULL, id_membre_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_FBF7B52EEAAC4B6D (id_membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe (id INT AUTO_INCREMENT NOT NULL, chef_id INT NOT NULL, labo_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, domaine VARCHAR(255) DEFAULT NULL, specialites VARCHAR(255) DEFAULT NULL, INDEX IDX_2449BA15150A48F1 (chef_id), INDEX IDX_2449BA15B65FA4A (labo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe_membres (equipe_id INT NOT NULL, membres_id INT NOT NULL, INDEX IDX_814AFF206D861B89 (equipe_id), INDEX IDX_814AFF2071128C5C (membres_id), PRIMARY KEY(equipe_id, membres_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, labo_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, nombre VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_D338D583B65FA4A (labo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, date DATETIME DEFAULT NULL, lieu VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE labo (id INT AUTO_INCREMENT NOT NULL, chef_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, domainde_recherche LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_9367435C150A48F1 (chef_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE master (id INT AUTO_INCREMENT NOT NULL, id_membre_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2D09A3D6EAAC4B6D (id_membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membres (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, specialite VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, introduction LONGTEXT DEFAULT NULL, etablissement VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_594AE39CE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_doc (id INT AUTO_INCREMENT NOT NULL, id_membre_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_DF067017EAAC4B6D (id_membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur (id INT AUTO_INCREMENT NOT NULL, id_membre_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_17A55299EAAC4B6D (id_membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet_recherche (id INT AUTO_INCREMENT NOT NULL, coordinateur_princ_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, financement VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, datefin DATE NOT NULL, pdf VARCHAR(255) DEFAULT NULL, INDEX IDX_97D9FC92C01C374F (coordinateur_princ_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet_recherche_membres (projet_recherche_id INT NOT NULL, membres_id INT NOT NULL, INDEX IDX_B56E5727DFD06DF8 (projet_recherche_id), INDEX IDX_B56E572771128C5C (membres_id), PRIMARY KEY(projet_recherche_id, membres_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publication (id INT AUTO_INCREMENT NOT NULL, auteur_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, annee DATE NOT NULL, lien VARCHAR(255) NOT NULL, text LONGTEXT DEFAULT NULL, autre VARCHAR(255) DEFAULT NULL, INDEX IDX_AF3C677960BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publication_membres (publication_id INT NOT NULL, membres_id INT NOT NULL, INDEX IDX_51C335A038B217A7 (publication_id), INDEX IDX_51C335A071128C5C (membres_id), PRIMARY KEY(publication_id, membres_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stagiaire (id INT AUTO_INCREMENT NOT NULL, id_membre_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_4F62F731EAAC4B6D (id_membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sujet_recherche (id INT AUTO_INCREMENT NOT NULL, master_id INT DEFAULT NULL, stagiaire_id INT DEFAULT NULL, pr_associe_id INT DEFAULT NULL, encadren_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, pfe TINYINT(1) NOT NULL, datedebut DATE NOT NULL, datefine DATE NOT NULL, pdf VARCHAR(255) DEFAULT NULL, INDEX IDX_7EA93A2613B3DB11 (master_id), INDEX IDX_7EA93A26BBA93DD6 (stagiaire_id), UNIQUE INDEX UNIQ_7EA93A26B1274575 (pr_associe_id), INDEX IDX_7EA93A26D6BD0202 (encadren_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sujet_these (id INT AUTO_INCREMENT NOT NULL, doctorant_id INT NOT NULL, encadrant_id INT NOT NULL, coencadrant_id INT DEFAULT NULL, pr_associe_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, annee DATE NOT NULL, bourse VARCHAR(255) DEFAULT NULL, pdf VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_2D880FF7EEF99363 (doctorant_id), INDEX IDX_2D880FF7FEF1BA4 (encadrant_id), INDEX IDX_2D880FF77CBE0195 (coencadrant_id), UNIQUE INDEX UNIQ_2D880FF7B1274575 (pr_associe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE doctorant ADD CONSTRAINT FK_FBF7B52EEAAC4B6D FOREIGN KEY (id_membre_id) REFERENCES membres (id)');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA15150A48F1 FOREIGN KEY (chef_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA15B65FA4A FOREIGN KEY (labo_id) REFERENCES labo (id)');
        $this->addSql('ALTER TABLE equipe_membres ADD CONSTRAINT FK_814AFF206D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipe_membres ADD CONSTRAINT FK_814AFF2071128C5C FOREIGN KEY (membres_id) REFERENCES membres (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D583B65FA4A FOREIGN KEY (labo_id) REFERENCES labo (id)');
        $this->addSql('ALTER TABLE labo ADD CONSTRAINT FK_9367435C150A48F1 FOREIGN KEY (chef_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE master ADD CONSTRAINT FK_2D09A3D6EAAC4B6D FOREIGN KEY (id_membre_id) REFERENCES membres (id)');
        $this->addSql('ALTER TABLE post_doc ADD CONSTRAINT FK_DF067017EAAC4B6D FOREIGN KEY (id_membre_id) REFERENCES membres (id)');
        $this->addSql('ALTER TABLE professeur ADD CONSTRAINT FK_17A55299EAAC4B6D FOREIGN KEY (id_membre_id) REFERENCES membres (id)');
        $this->addSql('ALTER TABLE projet_recherche ADD CONSTRAINT FK_97D9FC92C01C374F FOREIGN KEY (coordinateur_princ_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE projet_recherche_membres ADD CONSTRAINT FK_B56E5727DFD06DF8 FOREIGN KEY (projet_recherche_id) REFERENCES projet_recherche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_recherche_membres ADD CONSTRAINT FK_B56E572771128C5C FOREIGN KEY (membres_id) REFERENCES membres (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C677960BB6FE6 FOREIGN KEY (auteur_id) REFERENCES membres (id)');
        $this->addSql('ALTER TABLE publication_membres ADD CONSTRAINT FK_51C335A038B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE publication_membres ADD CONSTRAINT FK_51C335A071128C5C FOREIGN KEY (membres_id) REFERENCES membres (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stagiaire ADD CONSTRAINT FK_4F62F731EAAC4B6D FOREIGN KEY (id_membre_id) REFERENCES membres (id)');
        $this->addSql('ALTER TABLE sujet_recherche ADD CONSTRAINT FK_7EA93A2613B3DB11 FOREIGN KEY (master_id) REFERENCES master (id)');
        $this->addSql('ALTER TABLE sujet_recherche ADD CONSTRAINT FK_7EA93A26BBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id)');
        $this->addSql('ALTER TABLE sujet_recherche ADD CONSTRAINT FK_7EA93A26B1274575 FOREIGN KEY (pr_associe_id) REFERENCES projet_recherche (id)');
        $this->addSql('ALTER TABLE sujet_recherche ADD CONSTRAINT FK_7EA93A26D6BD0202 FOREIGN KEY (encadren_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE sujet_these ADD CONSTRAINT FK_2D880FF7EEF99363 FOREIGN KEY (doctorant_id) REFERENCES doctorant (id)');
        $this->addSql('ALTER TABLE sujet_these ADD CONSTRAINT FK_2D880FF7FEF1BA4 FOREIGN KEY (encadrant_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE sujet_these ADD CONSTRAINT FK_2D880FF77CBE0195 FOREIGN KEY (coencadrant_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE sujet_these ADD CONSTRAINT FK_2D880FF7B1274575 FOREIGN KEY (pr_associe_id) REFERENCES projet_recherche (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sujet_these DROP FOREIGN KEY FK_2D880FF7EEF99363');
        $this->addSql('ALTER TABLE equipe_membres DROP FOREIGN KEY FK_814AFF206D861B89');
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA15B65FA4A');
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D583B65FA4A');
        $this->addSql('ALTER TABLE sujet_recherche DROP FOREIGN KEY FK_7EA93A2613B3DB11');
        $this->addSql('ALTER TABLE doctorant DROP FOREIGN KEY FK_FBF7B52EEAAC4B6D');
        $this->addSql('ALTER TABLE equipe_membres DROP FOREIGN KEY FK_814AFF2071128C5C');
        $this->addSql('ALTER TABLE master DROP FOREIGN KEY FK_2D09A3D6EAAC4B6D');
        $this->addSql('ALTER TABLE post_doc DROP FOREIGN KEY FK_DF067017EAAC4B6D');
        $this->addSql('ALTER TABLE professeur DROP FOREIGN KEY FK_17A55299EAAC4B6D');
        $this->addSql('ALTER TABLE projet_recherche_membres DROP FOREIGN KEY FK_B56E572771128C5C');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C677960BB6FE6');
        $this->addSql('ALTER TABLE publication_membres DROP FOREIGN KEY FK_51C335A071128C5C');
        $this->addSql('ALTER TABLE stagiaire DROP FOREIGN KEY FK_4F62F731EAAC4B6D');
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA15150A48F1');
        $this->addSql('ALTER TABLE labo DROP FOREIGN KEY FK_9367435C150A48F1');
        $this->addSql('ALTER TABLE projet_recherche DROP FOREIGN KEY FK_97D9FC92C01C374F');
        $this->addSql('ALTER TABLE sujet_recherche DROP FOREIGN KEY FK_7EA93A26D6BD0202');
        $this->addSql('ALTER TABLE sujet_these DROP FOREIGN KEY FK_2D880FF7FEF1BA4');
        $this->addSql('ALTER TABLE sujet_these DROP FOREIGN KEY FK_2D880FF77CBE0195');
        $this->addSql('ALTER TABLE projet_recherche_membres DROP FOREIGN KEY FK_B56E5727DFD06DF8');
        $this->addSql('ALTER TABLE sujet_recherche DROP FOREIGN KEY FK_7EA93A26B1274575');
        $this->addSql('ALTER TABLE sujet_these DROP FOREIGN KEY FK_2D880FF7B1274575');
        $this->addSql('ALTER TABLE publication_membres DROP FOREIGN KEY FK_51C335A038B217A7');
        $this->addSql('ALTER TABLE sujet_recherche DROP FOREIGN KEY FK_7EA93A26BBA93DD6');
        $this->addSql('DROP TABLE doctorant');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE equipe_membres');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE labo');
        $this->addSql('DROP TABLE master');
        $this->addSql('DROP TABLE membres');
        $this->addSql('DROP TABLE post_doc');
        $this->addSql('DROP TABLE professeur');
        $this->addSql('DROP TABLE projet_recherche');
        $this->addSql('DROP TABLE projet_recherche_membres');
        $this->addSql('DROP TABLE publication');
        $this->addSql('DROP TABLE publication_membres');
        $this->addSql('DROP TABLE stagiaire');
        $this->addSql('DROP TABLE sujet_recherche');
        $this->addSql('DROP TABLE sujet_these');
    }
}
