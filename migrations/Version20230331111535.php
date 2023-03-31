<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230331111535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE scandoc (id INT AUTO_INCREMENT NOT NULL, scandoc_type_id INT NOT NULL, file_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, created_at DATE NOT NULL, INDEX IDX_C8279287536110AC (scandoc_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scandoc_type (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scanform (id INT AUTO_INCREMENT NOT NULL, scanform_type_id INT NOT NULL, file_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, created_at DATE NOT NULL, INDEX IDX_6BC528E22364F152 (scanform_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scanform_type (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE scandoc ADD CONSTRAINT FK_C8279287536110AC FOREIGN KEY (scandoc_type_id) REFERENCES scandoc_type (id)');
        $this->addSql('ALTER TABLE scanform ADD CONSTRAINT FK_6BC528E22364F152 FOREIGN KEY (scanform_type_id) REFERENCES scanform_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scandoc DROP FOREIGN KEY FK_C8279287536110AC');
        $this->addSql('ALTER TABLE scanform DROP FOREIGN KEY FK_6BC528E22364F152');
        $this->addSql('DROP TABLE scandoc');
        $this->addSql('DROP TABLE scandoc_type');
        $this->addSql('DROP TABLE scanform');
        $this->addSql('DROP TABLE scanform_type');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
