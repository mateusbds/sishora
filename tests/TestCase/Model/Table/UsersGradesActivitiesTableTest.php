<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersGradesActivitiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersGradesActivitiesTable Test Case
 */
class UsersGradesActivitiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersGradesActivitiesTable
     */
    public $UsersGradesActivities;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users_grades_activities',
        'app.users',
        'app.grades',
        'app.courses',
        'app.activities',
        'app.grades_activities',
        'app.actuations',
        'app.grades_actuations',
        'app.teams',
        'app.profiles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UsersGradesActivities') ? [] : ['className' => 'App\Model\Table\UsersGradesActivitiesTable'];
        $this->UsersGradesActivities = TableRegistry::get('UsersGradesActivities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UsersGradesActivities);

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
