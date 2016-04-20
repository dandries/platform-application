<?php

namespace Oro\Bundle\IssuesBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\OrderedMigrationInterface;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class Issue implements Migration, OrderedMigrationInterface
{
    public function up(Schema $schema, QueryBag $queries)
    {
        $this->createOroIssueTable($schema);
        $this->createOroIssueCollaboratorsTable($schema);
        $this->createOroIssueTagsTable($schema);

        $this->addOroIssueForeignKeys($schema);
        $this->addOroIssueCollaboratorsForeignKeys($schema);
        $this->addOroIssueTagsForeignKeys($schema);
    }

    /**
    * Create oro_issue table
    *
    * @param Schema $schema
    */
    protected function createOroIssueTable(Schema $schema)
    {
        $table = $schema->createTable('oro_issue');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('status', 'string', ['notnull' => false, 'length' => 32]);
        $table->addColumn('priority', 'string', ['notnull' => false, 'length' => 32]);
        $table->addColumn('type', 'string', ['notnull' => false, 'length' => 32]);
        $table->addColumn('resolution', 'string', ['notnull' => false, 'length' => 32]);
        $table->addColumn('assignee_id', 'integer', ['notnull' => false]);
        $table->addColumn('parent_id', 'integer', ['notnull' => false]);
        $table->addColumn('reporter_id', 'integer', ['notnull' => false]);
        $table->addColumn('summary', 'string', ['length' => 255]);
        $table->addColumn('code', 'string', ['length' => 255]);
        $table->addColumn('description', 'text', ['notnull' => false]);
        $table->addColumn('createdAt', 'datetime', []);
        $table->addColumn('updatedAt', 'datetime', []);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['priority'], 'IDX_DF0F9E3B62A6DC27', []);
        $table->addIndex(['reporter_id'], 'IDX_DF0F9E3BE1CFE6F5', []);
        $table->addIndex(['assignee_id'], 'IDX_DF0F9E3B59EC7D60', []);
        $table->addIndex(['parent_id'], 'IDX_DF0F9E3B727ACA70', []);
        $table->addIndex(['type'], 'IDX_DF0F9E3B8CDE5729', []);
        $table->addIndex(['resolution'], 'IDX_DF0F9E3BFDD30F8A', []);
        $table->addIndex(['status'], 'IDX_DF0F9E3B7B00651C', []);
    }

    /**
     * Create oro_issue_collaborators table
     *
     * @param Schema $schema
     */
    protected function createOroIssueCollaboratorsTable(Schema $schema)
    {
        $table = $schema->createTable('oro_issue_collaborators');
        $table->addColumn('issue_id', 'integer', []);
        $table->addColumn('user_id', 'integer', []);
        $table->setPrimaryKey(['issue_id', 'user_id']);
        $table->addIndex(['issue_id'], 'IDX_9DBAC525E7AA58C', []);
        $table->addIndex(['user_id'], 'IDX_9DBAC52A76ED395', []);
    }

    /**
     * Create oro_issue_tags table
     *
     * @param Schema $schema
     */
    protected function createOroIssueTagsTable(Schema $schema)
    {
        $table = $schema->createTable('oro_issue_tags');
        $table->addColumn('issue_id', 'integer', []);
        $table->addColumn('tag_id', 'integer', []);
        $table->setPrimaryKey(['issue_id', 'tag_id']);
        $table->addIndex(['issue_id'], 'IDX_B40B65D05E7AA58C', []);
        $table->addIndex(['tag_id'], 'IDX_B40B65D0BAD26311', []);
    }

    /**
     * Add oro_issue foreign keys.
     *
     * @param Schema $schema
     */
    protected function addOroIssueForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('oro_issue');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_issue_status'),
            ['status'],
            ['name'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_issue_priority'),
            ['priority'],
            ['name'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_issue_type'),
            ['type'],
            ['name'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_issue_resolution'),
            ['resolution'],
            ['name'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['assignee_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_issue'),
            ['parent_id'],
            ['id'],
            ['onDelete' => null, 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['reporter_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
    }

    /**
     * Add oro_issue_collaborators foreign keys.
     *
     * @param Schema $schema
     */
    protected function addOroIssueCollaboratorsForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('oro_issue_collaborators');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['user_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_issue'),
            ['issue_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
    }

    /**
     * Add oro_issue_notes foreign keys.
     *
     * @param Schema $schema
     */
    protected function addOroIssueNotesForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('oro_issue_notes');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_note'),
            ['note_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_issue'),
            ['issue_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
    }

    /**
     * Add oro_issue_tags foreign keys.
     *
     * @param Schema $schema
     */
    protected function addOroIssueTagsForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('oro_issue_tags');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_tag_tag'),
            ['tag_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_issue'),
            ['issue_id'],
            ['id'],
            ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
    }

    /**
     * Get the order of this migration
     *
     * @return integer
     */
    public function getOrder()
    {
        return 91;
    }
}