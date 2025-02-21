<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250221223900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sub_task DROP FOREIGN KEY FK_75E844E4CDFFE14F');
        $this->addSql('ALTER TABLE sub_task ADD task_id INT NOT NULL');
        $this->addSql('ALTER TABLE sub_task ADD CONSTRAINT FK_75E844E48DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('ALTER TABLE sub_task ADD CONSTRAINT FK_75E844E4CDFFE14F FOREIGN KEY (sub_task_type_id) REFERENCES sub_task_type (id)');
        $this->addSql('CREATE INDEX IDX_75E844E48DB60186 ON sub_task (task_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sub_task DROP FOREIGN KEY FK_75E844E48DB60186');
        $this->addSql('ALTER TABLE sub_task DROP FOREIGN KEY FK_75E844E4CDFFE14F');
        $this->addSql('DROP INDEX IDX_75E844E48DB60186 ON sub_task');
        $this->addSql('ALTER TABLE sub_task DROP task_id');
        $this->addSql('ALTER TABLE sub_task ADD CONSTRAINT FK_75E844E4CDFFE14F FOREIGN KEY (sub_task_type_id) REFERENCES task (id)');
    }
}
