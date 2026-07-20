<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260718040959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animales (id INT AUTO_INCREMENT NOT NULL, tipo VARCHAR(255) NOT NULL, color VARCHAR(255) DEFAULT NULL, raza VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carritocompras (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, subtotal NUMERIC(10, 0) NOT NULL, UNIQUE INDEX UNIQ_BED5150ADB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, descuento NUMERIC(10, 0) DEFAULT NULL, fecharegistro DATETIME DEFAULT NULL, fechainicio DATETIME DEFAULT NULL, fechafin DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_carrito (id INT AUTO_INCREMENT NOT NULL, carritocompras_id INT NOT NULL, idproducto_id INT NOT NULL, cantidad INT NOT NULL, subtotal NUMERIC(10, 0) NOT NULL, INDEX IDX_7CBB9881AADA8017 (carritocompras_id), INDEX IDX_7CBB9881B0841921 (idproducto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE productos (id INT AUTO_INCREMENT NOT NULL, categoria_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, descripcion LONGTEXT DEFAULT NULL, stock INT NOT NULL, imagen VARCHAR(255) DEFAULT NULL, INDEX IDX_767490E63397707A (categoria_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) DEFAULT NULL, apellido VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuarios (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, apellido VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, correoelectronico VARCHAR(50) NOT NULL, telefono VARCHAR(15) DEFAULT NULL, fecharegistro DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE carritocompras ADD CONSTRAINT FK_BED5150ADB38439E FOREIGN KEY (usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE item_carrito ADD CONSTRAINT FK_7CBB9881AADA8017 FOREIGN KEY (carritocompras_id) REFERENCES carritocompras (id)');
        $this->addSql('ALTER TABLE item_carrito ADD CONSTRAINT FK_7CBB9881B0841921 FOREIGN KEY (idproducto_id) REFERENCES productos (id)');
        $this->addSql('ALTER TABLE productos ADD CONSTRAINT FK_767490E63397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carritocompras DROP FOREIGN KEY FK_BED5150ADB38439E');
        $this->addSql('ALTER TABLE item_carrito DROP FOREIGN KEY FK_7CBB9881AADA8017');
        $this->addSql('ALTER TABLE item_carrito DROP FOREIGN KEY FK_7CBB9881B0841921');
        $this->addSql('ALTER TABLE productos DROP FOREIGN KEY FK_767490E63397707A');
        $this->addSql('DROP TABLE animales');
        $this->addSql('DROP TABLE carritocompras');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE item_carrito');
        $this->addSql('DROP TABLE productos');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE usuarios');
    }
}
