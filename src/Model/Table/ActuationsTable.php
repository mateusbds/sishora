<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Actuations Model
 *
 * @property \Cake\ORM\Association\HasMany $GradesActivities
 * @property \Cake\ORM\Association\BelongsToMany $Grades
 *
 * @method \App\Model\Entity\Actuation get($primaryKey, $options = [])
 * @method \App\Model\Entity\Actuation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Actuation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Actuation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Actuation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Actuation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Actuation findOrCreate($search, callable $callback = null, $options = [])
 */
class ActuationsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('actuations');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('GradesActivities', [
            'foreignKey' => 'actuation_id'
        ]);
        $this->belongsToMany('Grades', [
            'foreignKey' => 'actuation_id',
            'targetForeignKey' => 'grade_id',
            'joinTable' => 'grades_actuations'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        return $validator;
    }
}
