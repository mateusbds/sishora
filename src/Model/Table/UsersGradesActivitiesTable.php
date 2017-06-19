<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Utility\Inflector;
/**
 * UsersGradesActivities Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $GradesActivities
 *
 * @method \App\Model\Entity\UsersGradesActivity get($primaryKey, $options = [])
 * @method \App\Model\Entity\UsersGradesActivity newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UsersGradesActivity[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UsersGradesActivity|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UsersGradesActivity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UsersGradesActivity[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UsersGradesActivity findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersGradesActivitiesTable extends Table
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



        $this->table('users_grades_activities');

        $this->displayField('id');

        $this->primaryKey('id');



        $this->belongsTo('Users', [

            'foreignKey' => 'user_id',

            'joinType' => 'INNER'

        ]);

        $this->belongsTo('GradesActivities', [

            'foreignKey' => 'grades_activity_id'

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
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->integer('carga_horaria')
            ->requirePresence('carga_horaria', 'create')
            ->notEmpty('carga_horaria');

        $validator
            ->allowEmpty('instituicao');

        $validator
            ->requirePresence('file_name') 
            ->add('file_name', [
                'validExtension' => [
                    'rule' => ['extension',['png', 'jpeg', 'jpg', 'pdf', 'doc', 'docx']],
                    'message' => __('Apenas arquivos com a extensão seguinte são permitidos: png, jpeg, jpg, pdf, doc, docx')
                ]
            ]);

        $validator
            ->boolean('validated')
            ->allowEmpty('validated');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['grades_activity_id'], 'GradesActivities'));

        return $rules;
    }

    //Upload files
    public function beforeSave($event, $entity, $options)
    {

        if(!empty($entity['Model']['file_name']['name'])) {
            $this->upload($entity['Model']['file_name'], $entity['user_id']);
        } 
        else {
            $temp = $entity['Model'];
            unset($temp['file_name']);
        }
    }
    /**
    * Organiza o upload.
    * @access public
    * @param Array $imagem
    * @param String $data
    */ 
    public function upload($imagem = array(), $dir)
    {
        $dir = WWW_ROOT.'aluno'.DS.$dir.DS;

        if(($imagem['error']!=0) and ($imagem['size']==0)) {
            throw new NotImplementedException('Alguma coisa deu errado, o upload retornou erro '.$imagem['error'].' e tamanho '.$imagem['size']);
        }
        $this->checa_dir($dir);
        $this->move_arquivos($imagem, $dir);
        return $imagem['name'];
    }

    /**
    * Verifica se o diretório existe, se não ele cria.
    * @access public
    * @param Array $imagem
    * @param String $data
    */ 

    public function checa_dir($dir)
    {
        $folder = new Folder();
        if (!is_dir($dir)){
            $folder->create($dir);
        }
    }

    /**
    * Checa extensão
    * @access public
    * @param string Extensão
    */
    public function check_ext($ext)
    {
        $allowed_ext = [
            0 => 'png',
            1 => 'jpg',
            2 => 'jpeg',
            3 => 'doc',
            4 => 'docx',
            5 => 'pdf'
        ];

        for($i = 0; $i < count($allowed_ext); $i++) {
            if($allowed_ext[$i] == $ext) {
                return true;
            }
        }
        return false;
    }

    /**
    * Move o arquivo para a pasta de destino.
    * @access public
    * @param Array $imagem
    * @param String $data
    */ 

    public function move_arquivos($imagem, $dir)
    {
        $arquivo = new File($imagem['tmp_name']);
        $arquivo->copy($dir.$imagem['name']);
        $arquivo->close();
    }



    public function beforeDelete($event, $entity, $options)
    {
        $dir = WWW_ROOT.'aluno'.DS.$entity['user_id'].DS.$entity['file_name'];
        unlink($dir);
    }

    

}

