<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250221220801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sub_task (id INT AUTO_INCREMENT NOT NULL, sub_task_type_id INT DEFAULT NULL, user_id INT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_75E844E4CDFFE14F (sub_task_type_id), INDEX IDX_75E844E4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_task_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sub_task ADD CONSTRAINT FK_75E844E4CDFFE14F FOREIGN KEY (sub_task_type_id) REFERENCES sub_task_type (id)');
        $this->addSql('ALTER TABLE sub_task ADD CONSTRAINT FK_75E844E4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sub_task DROP FOREIGN KEY FK_75E844E4CDFFE14F');
        $this->addSql('ALTER TABLE sub_task DROP FOREIGN KEY FK_75E844E4A76ED395');
        $this->addSql('DROP TABLE sub_task');
        $this->addSql('DROP TABLE sub_task_type');
    }
}
