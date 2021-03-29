<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20210328200338 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE spell (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_D03FCD8D5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE warscroll_battalion (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, additionalPointCost INT NOT NULL, UNIQUE INDEX UNIQ_D48404605E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE UsersTable (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', UNIQUE INDEX UNIQ_EA199D87F85E0677 (username), UNIQUE INDEX UNIQ_EA199D87E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weapon (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, min_range SMALLINT NOT NULL, max_range SMALLINT NOT NULL, attacks SMALLINT NOT NULL, to_hit SMALLINT NOT NULL, to_wound SMALLINT NOT NULL, weapon_type enum(\'melee\', \'ranged\'), dmg_determiner enum(\'dice\', \'static\'), number_of_dmg_dice SMALLINT DEFAULT NULL, max_die_dmg_value SMALLINT DEFAULT NULL, static_dmg SMALLINT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE keyword (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5A93713B5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE battlefield_role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_8BE5C7A35E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pitched_battle_rule (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faction (id INT AUTO_INCREMENT NOT NULL, alliance_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_83048B9010A0EA3F (alliance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mount (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, movement INT NOT NULL, canFly TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_3AE9FA035E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unit_ability (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, commandAbility TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_6186E0FE5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unit (id INT AUTO_INCREMENT NOT NULL, alliance_id INT DEFAULT NULL, faction_id INT NOT NULL, name VARCHAR(255) NOT NULL, min_num_of_models SMALLINT NOT NULL, max_num_of_models SMALLINT NOT NULL, points SMALLINT NOT NULL, save_value SMALLINT NOT NULL, bravery_value SMALLINT NOT NULL, num_of_wounds SMALLINT NOT NULL, spells_per_round SMALLINT NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_DCBB0C5310A0EA3F (alliance_id), INDEX IDX_DCBB0C534448F8DA (faction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE alliance (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6CBA583F5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE faction ADD CONSTRAINT FK_83048B9010A0EA3F FOREIGN KEY (alliance_id) REFERENCES alliance (id)');
        $this->addSql('ALTER TABLE unit ADD CONSTRAINT FK_DCBB0C5310A0EA3F FOREIGN KEY (alliance_id) REFERENCES alliance (id)');
        $this->addSql('ALTER TABLE unit ADD CONSTRAINT FK_DCBB0C534448F8DA FOREIGN KEY (faction_id) REFERENCES faction (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE unit DROP FOREIGN KEY FK_DCBB0C534448F8DA');
        $this->addSql('ALTER TABLE faction DROP FOREIGN KEY FK_83048B9010A0EA3F');
        $this->addSql('ALTER TABLE unit DROP FOREIGN KEY FK_DCBB0C5310A0EA3F');
        $this->addSql('DROP TABLE spell');
        $this->addSql('DROP TABLE warscroll_battalion');
        $this->addSql('DROP TABLE UsersTable');
        $this->addSql('DROP TABLE weapon');
        $this->addSql('DROP TABLE keyword');
        $this->addSql('DROP TABLE battlefield_role');
        $this->addSql('DROP TABLE pitched_battle_rule');
        $this->addSql('DROP TABLE faction');
        $this->addSql('DROP TABLE mount');
        $this->addSql('DROP TABLE unit_ability');
        $this->addSql('DROP TABLE unit');
        $this->addSql('DROP TABLE alliance');
    }
}
