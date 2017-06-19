<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GradesActuations Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Actuations
 * @property \Cake\ORM\Association\BelongsTo $Grades
 *
 * @method \App\Model\Entity\GradesActuation get($primaryKey, $options = [])
 * @method \App\Model\Entity\GradesActuation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\GradesActuation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GradesActuation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GradesActuation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GradesActuation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\GradesActuation findOrCreate($search, callable $callback = null, $options = [])
 */class GradesActuationsTable extends Table
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

        $this->table('grades_actuations');
        $this->displayField('actuation_id');
        $this->primaryKey(['actuation_id', 'grade_id']);

        $this->belongsTo('Actuations', [
            'foreignKey' => 'actuation_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Grades', [
            'foreignKey' => 'grade_id',
            'joinType' => 'INNER'
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
            ->integer('id')            ->allowEmpty('id', 'create');
        $validator
            ->numeric('percentPerHour')            ->allowEmpty('percentPerHour');
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['actuation_id'], 'Actuations'));
        $rules->add($rules->existsIn(['grade_id'], 'Grades'));

        return $rules;
    }
}
