<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240525231830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', telephone VARCHAR(14) NOT NULL, montant DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE detail_commande (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, commande_id INT NOT NULL, quantite_commande INT NOT NULL, INDEX IDX_98344FA6F347EFB (produit_id), INDEX IDX_98344FA682EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('ALTER TABLE detail_commande ADD CONSTRAINT FK_98344FA6F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        // $this->addSql('ALTER TABLE detail_commande ADD CONSTRAINT FK_98344FA682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        // $this->addSql('ALTER TABLE produit CHANGE seconde_image seconde_image VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_commande DROP FOREIGN KEY FK_98344FA6F347EFB');
        $this->addSql('ALTER TABLE detail_commande DROP FOREIGN KEY FK_98344FA682EA2E54');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE detail_commande');
        $this->addSql('ALTER TABLE produit CHANGE seconde_image seconde_image VARCHAR(255) DEFAULT NULL');
    }
}
