<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Activitycomphours Model
 *
 * @property \Cake\ORM\Association\HasMany $Users
 *
 * @method \App\Model\Entity\Activitycomphour get($primaryKey, $options = [])
 * @method \App\Model\Entity\Activitycomphour newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Activitycomphour[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Activitycomphour|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Activitycomphour patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Activitycomphour[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Activitycomphour findOrCreate($search, callable $callback = null, $options = [])
 */
class ActivitycomphoursTable extends Table
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

        $this->table('activitycomphours');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->hasMany('Users', [
            'foreignKey' => 'activitycomphour_id'
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
            ->integer('hours')
            ->allowEmpty('hours');

        return $validator;
    }
}
