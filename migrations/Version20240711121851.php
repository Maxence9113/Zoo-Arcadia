<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240711121851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, race_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_6AAB231F6E59D40D (race_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_picture (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, name VARCHAR(255) NOT NULL, description_alt VARCHAR(255) DEFAULT NULL, INDEX IDX_990420B38E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(30) NOT NULL, note INT DEFAULT NULL, comment LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_approuved TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meal (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, employee_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', quantity INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9EF68E9C8E962C16 (animal_id), INDEX IDX_9EF68E9C8C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE race (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, habitat VARCHAR(50) NOT NULL, illustration VARCHAR(255) DEFAULT NULL, illustration_alt VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_DA6FBBAF5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(50) DEFAULT NULL, lastname VARCHAR(50) DEFAULT NULL, profil VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE veterinary_report (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, employee_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', meal_id INT DEFAULT NULL, comment LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_53C7E56B8E962C16 (animal_id), INDEX IDX_53C7E56B8C03F15C (employee_id), UNIQUE INDEX UNIQ_53C7E56B639666D6 (meal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F6E59D40D FOREIGN KEY (race_id) REFERENCES race (id)');
        $this->addSql('ALTER TABLE animal_picture ADD CONSTRAINT FK_990420B38E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9C8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9C8C03F15C FOREIGN KEY (employee_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE veterinary_report ADD CONSTRAINT FK_53C7E56B8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE veterinary_report ADD CONSTRAINT FK_53C7E56B8C03F15C FOREIGN KEY (employee_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE veterinary_report ADD CONSTRAINT FK_53C7E56B639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F6E59D40D');
        $this->addSql('ALTER TABLE animal_picture DROP FOREIGN KEY FK_990420B38E962C16');
        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9C8E962C16');
        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9C8C03F15C');
        $this->addSql('ALTER TABLE veterinary_report DROP FOREIGN KEY FK_53C7E56B8E962C16');
        $this->addSql('ALTER TABLE veterinary_report DROP FOREIGN KEY FK_53C7E56B8C03F15C');
        $this->addSql('ALTER TABLE veterinary_report DROP FOREIGN KEY FK_53C7E56B639666D6');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE animal_picture');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE meal');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE veterinary_report');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
