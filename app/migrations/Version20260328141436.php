<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 */
final class Version20260328141436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE price_history ADD old_price NUMERIC(12, 3) NOT NULL');
        $this->addSql('ALTER TABLE price_history ADD new_price NUMERIC(12, 3) NOT NULL');
        $this->addSql('ALTER TABLE price_history ADD timestamp INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE price_history DROP old_price');
        $this->addSql('ALTER TABLE price_history DROP new_price');
        $this->addSql('ALTER TABLE price_history DROP timestamp');
    }
}
