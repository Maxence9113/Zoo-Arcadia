<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240706201702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9C6A89F051');
        $this->addSql('DROP INDEX IDX_9EF68E9C6A89F051 ON meal');
        $this->addSql('ALTER TABLE meal CHANGE annimal_id animal_id INT NOT NULL');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9C8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('CREATE INDEX IDX_9EF68E9C8E962C16 ON meal (animal_id)');
        $this->addSql('ALTER TABLE user RENAME INDEX uniq_identifier_username TO UNIQ_8D93D649F85E0677');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9C8E962C16');
        $this->addSql('DROP INDEX IDX_9EF68E9C8E962C16 ON meal');
        $this->addSql('ALTER TABLE meal CHANGE animal_id annimal_id INT NOT NULL');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9C6A89F051 FOREIGN KEY (annimal_id) REFERENCES animal (id)');
        $this->addSql('CREATE INDEX IDX_9EF68E9C6A89F051 ON meal (annimal_id)');
        $this->addSql('ALTER TABLE user RENAME INDEX uniq_8d93d649f85e0677 TO UNIQ_IDENTIFIER_USERNAME');
    }
}
