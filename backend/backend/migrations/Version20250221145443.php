<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250221145443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создание миграции уведомления';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE notifications (
            id SERIAL PRIMARY KEY,
            recipient_email VARCHAR(255) NOT NULL,
            sender_email VARCHAR(255) NOT NULL,
            message TEXT NOT NULL
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE notifications');
    }
}
