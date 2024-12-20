<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241216204215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE respuesta ADD respuesta VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE respuesta ADD CONSTRAINT FK_6C6EC5EE31A5801E FOREIGN KEY (pregunta_id) REFERENCES pregunta (id)');
        $this->addSql('CREATE INDEX IDX_6C6EC5EE31A5801E ON respuesta (pregunta_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE respuesta DROP FOREIGN KEY FK_6C6EC5EE31A5801E');
        $this->addSql('DROP INDEX IDX_6C6EC5EE31A5801E ON respuesta');
        $this->addSql('ALTER TABLE respuesta DROP respuesta');
    }
}
