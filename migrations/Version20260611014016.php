<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260611014016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categoria DROP FOREIGN KEY FK_4E10122DED07566B');
        $this->addSql('DROP INDEX IDX_4E10122DED07566B ON categoria');
        $this->addSql('ALTER TABLE categoria DROP productos_id');
        $this->addSql('ALTER TABLE productos ADD categoria_id INT NOT NULL');
        $this->addSql('ALTER TABLE productos ADD CONSTRAINT FK_767490E63397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('CREATE INDEX IDX_767490E63397707A ON productos (categoria_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE productos DROP FOREIGN KEY FK_767490E63397707A');
        $this->addSql('DROP INDEX IDX_767490E63397707A ON productos');
        $this->addSql('ALTER TABLE productos DROP categoria_id');
        $this->addSql('ALTER TABLE categoria ADD productos_id INT NOT NULL');
        $this->addSql('ALTER TABLE categoria ADD CONSTRAINT FK_4E10122DED07566B FOREIGN KEY (productos_id) REFERENCES productos (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_4E10122DED07566B ON categoria (productos_id)');
    }
}
