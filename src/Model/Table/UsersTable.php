<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Grades
 * @property \Cake\ORM\Association\BelongsTo $Teams
 * @property \Cake\ORM\Association\BelongsTo $Profiles
 * @property \Cake\ORM\Association\HasMany $Courses
 * @property \Cake\ORM\Association\BelongsToMany $GradesActivities
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */class UsersTable extends Table
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

        $this->table('users');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Grades', [
            'foreignKey' => 'grade_id'
        ]);
        $this->belongsTo('Teams', [
            'foreignKey' => 'team_id'
        ]);
        $this->belongsTo('Profiles', [
            'foreignKey' => 'profile_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Activitycomphours', [
            'foreignKey' => 'activitycomphour_id',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('Courses', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsToMany('GradesActivities', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'grades_activity_id',
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
            ->requirePresence('username', 'create')            ->notEmpty('username', 'Login é necessário');
        $validator
            ->requirePresence('password', 'create')            ->notEmpty('password', 'Senha é necessária');
        $validator
            ->requirePresence('name', 'create')            ->notEmpty('name');
        $validator
            ->email('email')            ->allowEmpty('email');
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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['grade_id'], 'Grades'));
        $rules->add($rules->existsIn(['team_id'], 'Teams'));
        $rules->add($rules->existsIn(['profile_id'], 'Profiles'));

        return $rules;
    }
}
