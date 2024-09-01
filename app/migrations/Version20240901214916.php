<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240901214916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE users_cargo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE users_cargo (id INT NOT NULL, usuario_id INT NOT NULL, cargo_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DC99F338DB38439E ON users_cargo (usuario_id)');
        $this->addSql('CREATE INDEX IDX_DC99F338813AC380 ON users_cargo (cargo_id)');
        $this->addSql('ALTER TABLE users_cargo ADD CONSTRAINT FK_DC99F338DB38439E FOREIGN KEY (usuario_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_cargo ADD CONSTRAINT FK_DC99F338813AC380 FOREIGN KEY (cargo_id) REFERENCES cargo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('COMMENT ON COLUMN cargo.carga_horaria IS NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE users_cargo_id_seq CASCADE');
        $this->addSql('ALTER TABLE users_cargo DROP CONSTRAINT FK_DC99F338DB38439E');
        $this->addSql('ALTER TABLE users_cargo DROP CONSTRAINT FK_DC99F338813AC380');
        $this->addSql('DROP TABLE users_cargo');
        $this->addSql('COMMENT ON COLUMN cargo.carga_horaria IS \'(DC2Type:dateinterval)\'');
    }
}
