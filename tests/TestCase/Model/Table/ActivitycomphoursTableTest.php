<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ActivitycomphoursTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ActivitycomphoursTable Test Case
 */
class ActivitycomphoursTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ActivitycomphoursTable
     */
    public $Activitycomphours;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.activitycomphours',
        'app.users',
        'app.grades',
        'app.courses',
        'app.teams',
        'app.activities',
        'app.grades_activities',
        'app.actuations',
        'app.grades_actuations',
        'app.users_grades_activities',
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
        $config = TableRegistry::exists('Activitycomphours') ? [] : ['className' => 'App\Model\Table\ActivitycomphoursTable'];
        $this->Activitycomphours = TableRegistry::get('Activitycomphours', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Activitycomphours);

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
}
