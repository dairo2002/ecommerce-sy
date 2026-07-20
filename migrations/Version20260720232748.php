<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260720232748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carritocompras DROP INDEX UNIQ_BED5150ADB38439E, ADD INDEX IDX_BED5150ADB38439E (usuario_id)');
        $this->addSql('ALTER TABLE item_carrito CHANGE carritocompras_id carritocompras_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carritocompras DROP INDEX IDX_BED5150ADB38439E, ADD UNIQUE INDEX UNIQ_BED5150ADB38439E (usuario_id)');
        $this->addSql('ALTER TABLE item_carrito CHANGE carritocompras_id carritocompras_id INT NOT NULL');
    }
}
