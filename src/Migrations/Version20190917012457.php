<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190917012457 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE capitulo DROP INDEX UNIQ_2BA5E28F440FB72B, ADD INDEX IDX_2BA5E28F440FB72B (id_autor_id)');
        $this->addSql('ALTER TABLE capitulo CHANGE id_autor_id id_autor_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE capitulo DROP INDEX IDX_2BA5E28F440FB72B, ADD UNIQUE INDEX UNIQ_2BA5E28F440FB72B (id_autor_id)');
        $this->addSql('ALTER TABLE capitulo CHANGE id_autor_id id_autor_id INT DEFAULT NULL');
    }
}
