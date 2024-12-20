<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241213092707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pregunta ADD activo TINYINT(1) NOT NULL, ADD respuesta1 VARCHAR(200) NOT NULL, ADD respuesta2 VARCHAR(200) NOT NULL, ADD respuesta3 VARCHAR(200) DEFAULT NULL, ADD respuesta4 VARCHAR(200) DEFAULT NULL, ADD respuesta_correcta VARCHAR(200) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pregunta DROP activo, DROP respuesta1, DROP respuesta2, DROP respuesta3, DROP respuesta4, DROP respuesta_correcta');
    }
}
