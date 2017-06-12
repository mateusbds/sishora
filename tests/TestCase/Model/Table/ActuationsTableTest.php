<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ActuationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ActuationsTable Test Case
 */
class ActuationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ActuationsTable
     */
    public $Actuations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.actuations',
        'app.grades_activities',
        'app.grades',
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
        $config = TableRegistry::exists('Actuations') ? [] : ['className' => 'App\Model\Table\ActuationsTable'];
        $this->Actuations = TableRegistry::get('Actuations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Actuations);

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
