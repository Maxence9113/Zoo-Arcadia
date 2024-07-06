<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240706175912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE meal (id INT AUTO_INCREMENT NOT NULL, annimal_id INT NOT NULL, employee_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', quantity INT NOT NULL, date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', time TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', INDEX IDX_9EF68E9C6A89F051 (annimal_id), INDEX IDX_9EF68E9C8C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9C6A89F051 FOREIGN KEY (annimal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9C8C03F15C FOREIGN KEY (employee_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9C6A89F051');
        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9C8C03F15C');
        $this->addSql('DROP TABLE meal');
    }
}
