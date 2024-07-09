<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240709111542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9C4CAB118');
        $this->addSql('DROP INDEX IDX_9EF68E9C4CAB118 ON meal');
        $this->addSql('ALTER TABLE meal DROP veterinary_report_id');
        $this->addSql('ALTER TABLE veterinary_report ADD meal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE veterinary_report ADD CONSTRAINT FK_53C7E56B639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_53C7E56B639666D6 ON veterinary_report (meal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meal ADD veterinary_report_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9C4CAB118 FOREIGN KEY (veterinary_report_id) REFERENCES veterinary_report (id)');
        $this->addSql('CREATE INDEX IDX_9EF68E9C4CAB118 ON meal (veterinary_report_id)');
        $this->addSql('ALTER TABLE veterinary_report DROP FOREIGN KEY FK_53C7E56B639666D6');
        $this->addSql('DROP INDEX UNIQ_53C7E56B639666D6 ON veterinary_report');
        $this->addSql('ALTER TABLE veterinary_report DROP meal_id');
    }
}
