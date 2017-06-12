<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GradesActuationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GradesActuationsTable Test Case
 */
class GradesActuationsTableTest extends TestCase
{

    /**
     * Test subject     *
     * @var \App\Model\Table\GradesActuationsTable     */
    public $GradesActuations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.grades_actuations',
        'app.actuations',
        'app.grades_activities',
        'app.activities',
        'app.grades',
        'app.courses',
        'app.users',
        'app.teams',
        'app.profiles',
        'app.users_grades_activities'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('GradesActuations') ? [] : ['className' => 'App\Model\Table\GradesActuationsTable'];        $this->GradesActuations = TableRegistry::get('GradesActuations', $config);    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->GradesActuations);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
