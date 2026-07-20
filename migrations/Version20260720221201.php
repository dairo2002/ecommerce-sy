<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260720221201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carritocompras DROP FOREIGN KEY FK_BED5150A639DDEED');
        $this->addSql('DROP INDEX IDX_BED5150A639DDEED ON carritocompras');
        $this->addSql('ALTER TABLE carritocompras DROP item_carrito_id');
        $this->addSql('ALTER TABLE item_carrito ADD carritocompras_id INT NOT NULL');
        $this->addSql('ALTER TABLE item_carrito ADD CONSTRAINT FK_7CBB9881AADA8017 FOREIGN KEY (carritocompras_id) REFERENCES carritocompras (id)');
        $this->addSql('CREATE INDEX IDX_7CBB9881AADA8017 ON item_carrito (carritocompras_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carritocompras ADD item_carrito_id INT NOT NULL');
        $this->addSql('ALTER TABLE carritocompras ADD CONSTRAINT FK_BED5150A639DDEED FOREIGN KEY (item_carrito_id) REFERENCES item_carrito (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_BED5150A639DDEED ON carritocompras (item_carrito_id)');
        $this->addSql('ALTER TABLE item_carrito DROP FOREIGN KEY FK_7CBB9881AADA8017');
        $this->addSql('DROP INDEX IDX_7CBB9881AADA8017 ON item_carrito');
        $this->addSql('ALTER TABLE item_carrito DROP carritocompras_id');
    }
}
