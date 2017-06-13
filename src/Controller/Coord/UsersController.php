<?php
namespace App\Controller\Coord;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    public function initialize()
    {
        parent::initialize();
        $this->Auth->config('loginAction', ['prefix' => false, 'controller' => 'Users', 'action' => 'login']);
        $this->Auth->config('unauthorizedRedirect', ['prefix' => false, 'controller' => 'Users', 'action' => 'login']);
        $this->Auth->allow(['']);

        $user = $this->Auth->user();

        if(isset($user) && $user['profile_id'] == 2) {

            //checa se existe grades cadastradas e redireciona caso nao haja nenhuma
            $this->loadModel('Grades');
            $this->loadModel('Courses');
            $this->loadModel('Activities');

            $activities = $this->Activities->find();
            $activities = $activities->toArray();
            
            $courses = $this->Courses->find()->where(['user_id' => $user['id']]);
            $courses = $courses->toArray();

            $grades = $this->Grades->find()->where(['course_id' => $courses[0]['id']]);
            $grades = $grades->toArray();

            if(!count($activities))
            {
                $this->redirect(['controller' => 'Activities', 'action' => 'index']);
                $this->Flash->error(__('Cadastre as atividades curriculares do curso para continuar usando o sistema.'));
            }
            else if(!count($grades))
            {
                $this->redirect(['controller' => 'Grades', 'action' => 'index']);
                $this->Flash->error(__('Cadastre as grades do curso para continuar usando o sistema.'));
            }
        }
    }

    public function isAuthorized($user)
    {
        if(isset($user) && $user['profile_id'] == 2)
        {
            return true;
        }
        parent::isAuthorized($user);
    }

    public function logout()
    {
        $this->Flash->success('Logoff efetuado com sucesso.');
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {

        $this->loadModel('Courses');
        $this->paginate = [
            'contain' => ['Grades', 'Teams', 'Profiles']
        ];
        $tempID = $this->Auth->user();

        $users = $this->paginate($this->Users->find()->where(['profile_id' => 3, 'Grades.course_id' => $tempID['course']])); 
        
        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function view($id = null)
    // {
    //     $user = $this->Users->get($id, [
    //         'contain' => ['Grades', 'Teams', 'Profiles', 'GradesActivities']
    //     ]);

    //     $this->set('user', $user);
    //     $this->set('_serialize', ['user']);
    // }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();

        $this->loadModel('Activitycomphours');
        $activitycomphour = $this->Activitycomphours->newEntity();

        $this->Users->validator()
            ->requirePresence('grade_id', 'create')
            ->notEmpty('grade_id', 'Grade é necessária');

        if ($this->request->is('post')) {

            if($this->request->data['password'] != $this->request->data['passwordconfirm']) {
                $this->Flash->error(__('As senhas inseridas não condizem, por favor, cadastre novamente.'));
                return $this->redirect(['action' => 'index']);
            }

            $user = $this->Users->patchEntity($user, $this->request->data);
            $user['profile_id'] = 3;

            if($user['profile_id'] == 3)
            {
                $activitycomphour['hours'] = 0;
                $activitycomphour = $this->Activitycomphours->save($activitycomphour);
            }

            if($activitycomphour && $user['profile_id'] == 3)
            {
                $user['activitycomphour_id'] = $activitycomphour['id'];
            }

            if ($this->Users->save($user)) {
                $this->Flash->success(__('O usuário foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível salvar o usuário. Por favor, tente novamente.'));
        }
        $tempID = $this->Auth->user();
        $grades = $this->Users->Grades->find('list', ['limit' => 200, 'keyField' => 'id', 'valueField' => 'description'])->where(['course_id' => $tempID['course']]);
        $teams = $this->Users->Teams->find('list', ['limit' => 200]);
        $profiles = $this->Users->Profiles->find('list', ['limit' => 200])->where(['profiles.id' => 3]);
        $gradesActivities = $this->Users->GradesActivities->find('list', ['limit' => 200]);
        $this->set(compact('user', 'grades', 'teams', 'profiles', 'gradesActivities'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['GradesActivities']
        ]);

        $this->Users->validator()
                    ->requirePresence('grade_id', 'create')
                    ->notEmpty('grade_id', 'Grade é necessária');

        if ($this->request->is(['patch', 'post', 'put'])) {

            if($this->request->data['password'] != $this->request->data['passwordconfirm']) {
                $this->Flash->error(__('As senhas inseridas não condizem, por favor, cadastre novamente.'));
                return $this->redirect(['action' => 'index']);
            }

            $user = $this->Users->patchEntity($user, $this->request->data);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('O usuário foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível salvar o usuário. Por favor, tente novamente.'));
        }
        $tempID = $this->Auth->user();
        $grades = $this->Users->Grades->find('list', ['limit' => 200, 'keyField' => 'id', 'valueField' => 'description'])->where(['course_id' => $tempID['course']]);
        $teams = $this->Users->Teams->find('list', ['limit' => 200]);
        $profiles = $this->Users->Profiles->find('list', ['limit' => 200])->where(['profiles.id' => 3]);
        $gradesActivities = $this->Users->GradesActivities->find('list', ['limit' => 200]);
        $this->set(compact('user', 'grades', 'teams', 'profiles', 'gradesActivities'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);

        if($this->hasUsersGradesActivities($id))
        {
            $this->Flash->error(__('Não foi possível deletar o aluno pois existem atividades vinculadas.'));            
        }
        else
        {
            if ($this->Users->delete($user)) {
                $this->Flash->success(__('O usuário foi deletado.'));
            } else {
                $this->Flash->error(__('Não foi possível deletar o usuário. Por favor, tente novamente.'));
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    function hasUsersGradesActivities($id)
    {
        $this->loadModel('UsersGradesActivities');
        $usersgradesactivities = $this->UsersGradesActivities->find()->where(['user_id' => $id]);
        return count($usersgradesactivities->toArray());
    }

    public function activities()
    {
        $this->loadModel('UsersGradesActivities');
        $this->loadModel('Users');

        $this->paginate = [
            'contain' => ['Users', 'GradesActivities.Activities']
        ];

        $activities = $this->paginate($this->UsersGradesActivities->find()->where(['validated' => '2']));

        $this->set(compact('activities', 'users'));
        $this->set('_serialize', ['activities']);
    }

    public function download($user, $file_name)
    {
        $file_name = base64_decode($file_name);
        $filePath = WWW_ROOT . 'aluno'. DS . $user . DS . $file_name;
        $this->response->file($filePath, ['download'=> true, 'name'=> $file_name]);
        return $this->response;
    }

    public function validate($id)
    {
        $this->loadModel('UsersGradesActivities');
        $this->loadModel('Activitycomphours');

        $UsersGradesActivities = TableRegistry::get('UsersGradesActivities');
        $Activitycomphours = TableRegistry::get('Activitycomphours');

        $usersGradesActivity = $this->UsersGradesActivities->get($id);
        $user = $this->Users->get($usersGradesActivity['user_id']);
        $activitycomphour = $this->Activitycomphours->get($user['activitycomphour_id']);

        if($usersGradesActivity->validated !== 1)
        {
            $usersGradesActivity->validated = 1;
            $activitycomphour->hours += $usersGradesActivity->carga_aproveitada;
            
            if ($UsersGradesActivities->save($usersGradesActivity) && $Activitycomphours->save($activitycomphour)) {
                $this->Flash->success(__('Atividade foi validada.'));

                return $this->redirect(['action' => 'activities']);
            }
            $this->Flash->error(__('Não foi possível salvar a atividade. Por favor, tente novamente.'));
        }
        else
        {
             $this->Flash->error(__('Não é permitido validar uma atividade que já foi validada'));
        }

        return $this->redirect(['action' => 'activities']);
    }

    public function reject($id)
    {
        $this->loadModel('UsersGradesActivities');
        $UsersGradesActivities = TableRegistry::get('UsersGradesActivities');

        $usersGradesActivity = $this->UsersGradesActivities->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            if($usersGradesActivity->validated !== 0)
            {
                $usersGradesActivity->validated = 0;
                $usersGradesActivity = $this->UsersGradesActivities->patchEntity($usersGradesActivity, $this->request->data);
                if ($UsersGradesActivities->save($usersGradesActivity)) {
                    $this->Flash->success(__('Atividade foi rejeitada.'));

                    return $this->redirect(['action' => 'activities']);
                }
                $this->Flash->error(__('Não foi possível rejeitar a atividade. Por favor, tente novamente.'));
            }
            else
            {
                $this->Flash->error(__('Não é permitido rejeitar uma atividade que já foi rejeitada.'));
            }
        }

        $this->set(compact('usersGradesActivity'));
        $this->set('_serialize', ['usersGradesActivity']);
    }
}
