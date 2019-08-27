<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190826201134 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE dados_pagamento (id INT AUTO_INCREMENT NOT NULL, id_autor_leitor_id INT DEFAULT NULL, valor DOUBLE PRECISION NOT NULL, numero_conta VARCHAR(255) NOT NULL, agencia VARCHAR(255) NOT NULL, banco VARCHAR(255) NOT NULL, cpf VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6D06B8068ACB5EF7 (id_autor_leitor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dados_pagamento ADD CONSTRAINT FK_6D06B8068ACB5EF7 FOREIGN KEY (id_autor_leitor_id) REFERENCES leitor_autor (id)');
        $this->addSql('ALTER TABLE capitulo CHANGE id_historia_id id_historia_id INT NOT NULL');
        $this->addSql('ALTER TABLE leitor_autor ADD apelido VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE dados_pagamento');
        $this->addSql('ALTER TABLE capitulo CHANGE id_historia_id id_historia_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE leitor_autor DROP apelido');
    }
}
