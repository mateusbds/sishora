<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GradesActivitiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GradesActivitiesTable Test Case
 */
class GradesActivitiesTableTest extends TestCase
{

    /**
     * Test subject     *
     * @var \App\Model\Table\GradesActivitiesTable     */
    public $GradesActivities;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.grades_activities',
        'app.activities',
        'app.grades',
        'app.courses',
        'app.users',
        'app.teams',
        'app.profiles',
        'app.users_grades_activities',
        'app.actuations',
        'app.grades_actuations'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('GradesActivities') ? [] : ['className' => 'App\Model\Table\GradesActivitiesTable'];        $this->GradesActivities = TableRegistry::get('GradesActivities', $config);    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->GradesActivities);

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
