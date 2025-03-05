<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250305220359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE day (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, entry_date DATE NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', uuid BINARY(16) DEFAULT \'UUID()\' NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_E5A02990D17F50A6 (uuid), INDEX IDX_E5A02990A76ED395 (user_id), UNIQUE INDEX uq_user__entry_date (user_id, entry_date), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_task (id INT AUTO_INCREMENT NOT NULL, sub_task_type_id INT NOT NULL, day_id INT NOT NULL, task_id INT NOT NULL, user_id INT DEFAULT NULL, minutes DOUBLE PRECISION DEFAULT \'0\' NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL, uuid BINARY(16) DEFAULT \'UUID()\' NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_75E844E4D17F50A6 (uuid), INDEX IDX_75E844E4CDFFE14F (sub_task_type_id), INDEX IDX_75E844E49C24126 (day_id), INDEX IDX_75E844E48DB60186 (task_id), INDEX IDX_75E844E4A76ED395 (user_id), UNIQUE INDEX uq_sub_task_type__day__task (sub_task_type_id, day_id, task_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_task_type (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', uuid BINARY(16) DEFAULT \'UUID()\' NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_ED6085ECD17F50A6 (uuid), UNIQUE INDEX uq_title (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, finished TINYINT(1) DEFAULT 0 NOT NULL, finished_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL, uuid BINARY(16) DEFAULT \'UUID()\' NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_527EDB25D17F50A6 (uuid), INDEX IDX_527EDB25A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE day_tasks (task_id INT NOT NULL, day_id INT NOT NULL, INDEX IDX_E995D9738DB60186 (task_id), INDEX IDX_E995D9739C24126 (day_id), PRIMARY KEY(task_id, day_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE day ADD CONSTRAINT FK_E5A02990A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sub_task ADD CONSTRAINT FK_75E844E4CDFFE14F FOREIGN KEY (sub_task_type_id) REFERENCES sub_task_type (id)');
        $this->addSql('ALTER TABLE sub_task ADD CONSTRAINT FK_75E844E49C24126 FOREIGN KEY (day_id) REFERENCES day (id)');
        $this->addSql('ALTER TABLE sub_task ADD CONSTRAINT FK_75E844E48DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('ALTER TABLE sub_task ADD CONSTRAINT FK_75E844E4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE day_tasks ADD CONSTRAINT FK_E995D9738DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE day_tasks ADD CONSTRAINT FK_E995D9739C24126 FOREIGN KEY (day_id) REFERENCES day (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE day DROP FOREIGN KEY FK_E5A02990A76ED395');
        $this->addSql('ALTER TABLE sub_task DROP FOREIGN KEY FK_75E844E4CDFFE14F');
        $this->addSql('ALTER TABLE sub_task DROP FOREIGN KEY FK_75E844E49C24126');
        $this->addSql('ALTER TABLE sub_task DROP FOREIGN KEY FK_75E844E48DB60186');
        $this->addSql('ALTER TABLE sub_task DROP FOREIGN KEY FK_75E844E4A76ED395');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25A76ED395');
        $this->addSql('ALTER TABLE day_tasks DROP FOREIGN KEY FK_E995D9738DB60186');
        $this->addSql('ALTER TABLE day_tasks DROP FOREIGN KEY FK_E995D9739C24126');
        $this->addSql('DROP TABLE day');
        $this->addSql('DROP TABLE sub_task');
        $this->addSql('DROP TABLE sub_task_type');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE day_tasks');
        $this->addSql('DROP TABLE user');
    }
}
