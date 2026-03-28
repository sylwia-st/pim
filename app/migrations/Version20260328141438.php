<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 */
final class Version20260328141438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE product ADD CONSTRAINT check_price_positive CHECK (price > 0)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP CONSTRAINT check_price_positive');
    }
}
