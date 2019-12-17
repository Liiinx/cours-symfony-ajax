<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191215232422 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B84B89032C');
        $this->addSql('DROP INDEX IDX_653627B84B89032C ON post_like');
        $this->addSql('ALTER TABLE post_like CHANGE post_id post INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B85A8A6C8D FOREIGN KEY (post) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_653627B85A8A6C8D ON post_like (post)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B85A8A6C8D');
        $this->addSql('DROP INDEX IDX_653627B85A8A6C8D ON post_like');
        $this->addSql('ALTER TABLE post_like CHANGE post post_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B84B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_653627B84B89032C ON post_like (post_id)');
    }
}
