<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131133118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE surnames');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE surnames (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(45) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, surname VARCHAR(45) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, INDEX id_idx (user_id), PRIMARY KEY(id, user_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\'\' \' ');
    }
}
