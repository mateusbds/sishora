<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GradesActivities Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Activities
 * @property \Cake\ORM\Association\BelongsTo $Grades
 * @property \Cake\ORM\Association\BelongsTo $Actuations
 * @property \Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \App\Model\Entity\GradesActivity get($primaryKey, $options = [])
 * @method \App\Model\Entity\GradesActivity newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\GradesActivity[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GradesActivity|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GradesActivity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GradesActivity[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\GradesActivity findOrCreate($search, callable $callback = null, $options = [])
 */class GradesActivitiesTable extends Table
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

        $this->table('grades_activities');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Activities', [
            'foreignKey' => 'activity_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Grades', [
            'foreignKey' => 'grade_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Actuations', [
            'foreignKey' => 'actuation_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsToMany('Users', [
            'foreignKey' => 'grades_activity_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'users_grades_activities'
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
            ->numeric('amount')            ->requirePresence('amount', 'create')            ->notEmpty('amount');
        $validator
            ->requirePresence('unit', 'create')            ->notEmpty('unit');
        $validator
            ->integer('compHours')            ->requirePresence('compHours', 'create')            ->notEmpty('compHours');
        $validator
            ->numeric('limite')            ->requirePresence('limite', 'create')            ->notEmpty('limite');
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
        $rules->add($rules->existsIn(['activity_id'], 'Activities'));
        $rules->add($rules->existsIn(['grade_id'], 'Grades'));
        $rules->add($rules->existsIn(['actuation_id'], 'Actuations'));

        return $rules;
    }
}
