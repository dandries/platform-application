<?php
/**
 * Created by PhpStorm.
 * User: dandries
 * Date: 06.04.2016
 * Time: 17:21
 */

namespace Oro\Bundle\IssuesBundle\Migrations\Schema\v1_0;


use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class Issue implements Migration
{
    public function up(Schema $schema, QueryBag $queries)
    {
        $this->createOroIssueTable($schema);
        $this->createOroIssueCollaboratorsTable($schema);
        $this->createOroIssueNotesTable($schema);
        $this->createOroIssueTagsTable($schema);

        $this->addOroIssueForeignKeys($schema);
        $this->addOroIssueCollaboratorsForeignKeys($schema);
        $this->addOroIssueNotesForeignKeys($schema);
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
        $table->addColumn('parent_id', 'integer', ['notnull' => false]);
        $table->addColumn('assignee_id', 'integer', ['notnull' => false]);
        $table->addColumn('reporter_id', 'integer', ['notnull' => false]);
        $table->addColumn('summary', 'string', ['length' => 255]);
        $table->addColumn('code', 'string', ['length' => 255]);
        $table->addColumn('description', 'text', ['notnull' => false]);
        $table->addColumn('createdAt', 'datetime', []);
        $table->addColumn('updatedAt', 'datetime', []);
        $table->addColumn('priority', 'string', ['notnull' => false, 'length' => 32]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['priority'], 'IDX_DF0F9E3B62A6DC27', []);
        $table->addIndex(['reporter_id'], 'IDX_DF0F9E3BE1CFE6F5', []);
        $table->addIndex(['assignee_id'], 'IDX_DF0F9E3B59EC7D60', []);
        $table->addIndex(['parent_id'], 'IDX_DF0F9E3B727ACA70', []);
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
     * Create oro_issue_notes table
     *
     * @param Schema $schema
     */
    protected function createOroIssueNotesTable(Schema $schema)
    {
        $table = $schema->createTable('oro_issue_notes');
        $table->addColumn('issue_id', 'integer', []);
        $table->addColumn('note_id', 'integer', []);
        $table->setPrimaryKey(['issue_id', 'note_id']);
        $table->addIndex(['issue_id'], 'IDX_551E46545E7AA58C', []);
        $table->addIndex(['note_id'], 'IDX_551E465426ED0855', []);
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
            $schema->getTable('oro_issue'),
            ['parent_id'],
            ['id'],
            ['onDelete' => null, 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['assignee_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
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
    
}