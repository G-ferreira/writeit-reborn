<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190916183438 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE denuncia ADD id_historia_id INT NOT NULL, ADD id_user INT NOT NULL');
        $this->addSql('ALTER TABLE denuncia ADD CONSTRAINT FK_F4236796E0E84D18 FOREIGN KEY (id_historia_id) REFERENCES historia (id)');
        $this->addSql('CREATE INDEX IDX_F4236796E0E84D18 ON denuncia (id_historia_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE denuncia DROP FOREIGN KEY FK_F4236796E0E84D18');
        $this->addSql('DROP INDEX IDX_F4236796E0E84D18 ON denuncia');
        $this->addSql('ALTER TABLE denuncia DROP id_historia_id, DROP id_user');
    }
}
