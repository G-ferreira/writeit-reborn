<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190806184351 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE autor_leitor (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, senha VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE capitulo (id INT AUTO_INCREMENT NOT NULL, id_historia_id INT DEFAULT NULL, titulo VARCHAR(255) NOT NULL, texto LONGTEXT NOT NULL, data_publicacao DATETIME NOT NULL, INDEX IDX_2BA5E28FE0E84D18 (id_historia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(255) NOT NULL, descricao VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genero (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(255) NOT NULL, descricao VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historia (id INT AUTO_INCREMENT NOT NULL, id_autor_id INT DEFAULT NULL, titulo VARCHAR(255) NOT NULL, sinopse LONGTEXT NOT NULL, status TINYINT(1) NOT NULL, classificacao VARCHAR(255) NOT NULL, INDEX IDX_435C8E7A440FB72B (id_autor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historia_categoria (historia_id INT NOT NULL, categoria_id INT NOT NULL, INDEX IDX_3B1AF4D1F8FA80EF (historia_id), INDEX IDX_3B1AF4D13397707A (categoria_id), PRIMARY KEY(historia_id, categoria_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historia_genero (historia_id INT NOT NULL, genero_id INT NOT NULL, INDEX IDX_41D3406DF8FA80EF (historia_id), INDEX IDX_41D3406DBCE7B795 (genero_id), PRIMARY KEY(historia_id, genero_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE capitulo ADD CONSTRAINT FK_2BA5E28FE0E84D18 FOREIGN KEY (id_historia_id) REFERENCES historia (id)');
        $this->addSql('ALTER TABLE historia ADD CONSTRAINT FK_435C8E7A440FB72B FOREIGN KEY (id_autor_id) REFERENCES autor_leitor (id)');
        $this->addSql('ALTER TABLE historia_categoria ADD CONSTRAINT FK_3B1AF4D1F8FA80EF FOREIGN KEY (historia_id) REFERENCES historia (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE historia_categoria ADD CONSTRAINT FK_3B1AF4D13397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE historia_genero ADD CONSTRAINT FK_41D3406DF8FA80EF FOREIGN KEY (historia_id) REFERENCES historia (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE historia_genero ADD CONSTRAINT FK_41D3406DBCE7B795 FOREIGN KEY (genero_id) REFERENCES genero (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE historia DROP FOREIGN KEY FK_435C8E7A440FB72B');
        $this->addSql('ALTER TABLE historia_categoria DROP FOREIGN KEY FK_3B1AF4D13397707A');
        $this->addSql('ALTER TABLE historia_genero DROP FOREIGN KEY FK_41D3406DBCE7B795');
        $this->addSql('ALTER TABLE capitulo DROP FOREIGN KEY FK_2BA5E28FE0E84D18');
        $this->addSql('ALTER TABLE historia_categoria DROP FOREIGN KEY FK_3B1AF4D1F8FA80EF');
        $this->addSql('ALTER TABLE historia_genero DROP FOREIGN KEY FK_41D3406DF8FA80EF');
        $this->addSql('DROP TABLE autor_leitor');
        $this->addSql('DROP TABLE capitulo');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE genero');
        $this->addSql('DROP TABLE historia');
        $this->addSql('DROP TABLE historia_categoria');
        $this->addSql('DROP TABLE historia_genero');
    }
}
