<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240709102859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE veterinary_report (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, employee_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', comment LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_53C7E56B8E962C16 (animal_id), INDEX IDX_53C7E56B8C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE veterinary_report ADD CONSTRAINT FK_53C7E56B8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE veterinary_report ADD CONSTRAINT FK_53C7E56B8C03F15C FOREIGN KEY (employee_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE meal ADD veterinary_report_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9C4CAB118 FOREIGN KEY (veterinary_report_id) REFERENCES veterinary_report (id)');
        $this->addSql('CREATE INDEX IDX_9EF68E9C4CAB118 ON meal (veterinary_report_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9C4CAB118');
        $this->addSql('ALTER TABLE veterinary_report DROP FOREIGN KEY FK_53C7E56B8E962C16');
        $this->addSql('ALTER TABLE veterinary_report DROP FOREIGN KEY FK_53C7E56B8C03F15C');
        $this->addSql('DROP TABLE veterinary_report');
        $this->addSql('DROP INDEX IDX_9EF68E9C4CAB118 ON meal');
        $this->addSql('ALTER TABLE meal DROP veterinary_report_id');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677 ON user');
    }
}
