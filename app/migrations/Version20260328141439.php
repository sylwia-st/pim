<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 */
final class Version20260328141439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE product ADD CONSTRAINT currency_supported CHECK (currency IN ('PLN', 'EUR', 'USD'));");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP CONSTRAINT currency_supported');
    }
}
