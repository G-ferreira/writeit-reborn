<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191001203944 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comentario (id INT AUTO_INCREMENT NOT NULL, id_historia_id INT DEFAULT NULL, id_leitor_id INT DEFAULT NULL, texto LONGTEXT NOT NULL, data_publicacao DATETIME NOT NULL, INDEX IDX_4B91E702E0E84D18 (id_historia_id), UNIQUE INDEX UNIQ_4B91E70289A9A6AE (id_leitor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E702E0E84D18 FOREIGN KEY (id_historia_id) REFERENCES historia (id)');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E70289A9A6AE FOREIGN KEY (id_leitor_id) REFERENCES leitor_autor (id)');
        $this->addSql('DROP TABLE historia_categoria');
        $this->addSql('DROP TABLE historia_genero');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE historia_categoria (historia_id INT NOT NULL, categoria_id INT NOT NULL, INDEX IDX_3B1AF4D13397707A (categoria_id), INDEX IDX_3B1AF4D1F8FA80EF (historia_id), PRIMARY KEY(historia_id, categoria_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE historia_genero (historia_id INT NOT NULL, genero_id INT NOT NULL, INDEX IDX_41D3406DF8FA80EF (historia_id), INDEX IDX_41D3406DBCE7B795 (genero_id), PRIMARY KEY(historia_id, genero_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE historia_categoria ADD CONSTRAINT FK_3B1AF4D13397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE historia_categoria ADD CONSTRAINT FK_3B1AF4D1F8FA80EF FOREIGN KEY (historia_id) REFERENCES historia (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE historia_genero ADD CONSTRAINT FK_41D3406DBCE7B795 FOREIGN KEY (genero_id) REFERENCES genero (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE historia_genero ADD CONSTRAINT FK_41D3406DF8FA80EF FOREIGN KEY (historia_id) REFERENCES historia (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE comentario');
    }
}
