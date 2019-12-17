<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191215222353 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment_like DROP FOREIGN KEY FK_8A55E25FF8697D13');
        $this->addSql('DROP INDEX IDX_8A55E25FF8697D13 ON comment_like');
        $this->addSql('ALTER TABLE comment_like CHANGE comment_id comment INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment_like ADD CONSTRAINT FK_8A55E25F9474526C FOREIGN KEY (comment) REFERENCES comment (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_8A55E25F9474526C ON comment_like (comment)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment_like DROP FOREIGN KEY FK_8A55E25F9474526C');
        $this->addSql('DROP INDEX IDX_8A55E25F9474526C ON comment_like');
        $this->addSql('ALTER TABLE comment_like CHANGE comment comment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment_like ADD CONSTRAINT FK_8A55E25FF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('CREATE INDEX IDX_8A55E25FF8697D13 ON comment_like (comment_id)');
    }
}
