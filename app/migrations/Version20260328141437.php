<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 */
final class Version20260328141437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE UNIQUE INDEX unique_deleted_sku ON product(sku) WHERE is_deleted = false;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP UNIQUE INDEX unique_deleted_sku ON product(sku)');
    }
}
