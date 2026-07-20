<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260604020311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, productos_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, descuento NUMERIC(10, 0) DEFAULT NULL, fecharegistro DATETIME DEFAULT NULL, fechainicio DATETIME DEFAULT NULL, fechafin DATETIME DEFAULT NULL, INDEX IDX_4E10122DED07566B (productos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE productos (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, descripcion LONGTEXT DEFAULT NULL, stock INT NOT NULL, imagen VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categoria ADD CONSTRAINT FK_4E10122DED07566B FOREIGN KEY (productos_id) REFERENCES productos (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categoria DROP FOREIGN KEY FK_4E10122DED07566B');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE productos');
    }
}
