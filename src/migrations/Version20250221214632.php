<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250221214632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE day_tasks (task_id INT NOT NULL, day_id INT NOT NULL, INDEX IDX_E995D9738DB60186 (task_id), INDEX IDX_E995D9739C24126 (day_id), PRIMARY KEY(task_id, day_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE day_tasks ADD CONSTRAINT FK_E995D9738DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE day_tasks ADD CONSTRAINT FK_E995D9739C24126 FOREIGN KEY (day_id) REFERENCES day (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE day_tasks DROP FOREIGN KEY FK_E995D9738DB60186');
        $this->addSql('ALTER TABLE day_tasks DROP FOREIGN KEY FK_E995D9739C24126');
        $this->addSql('DROP TABLE day_tasks');
    }
}
