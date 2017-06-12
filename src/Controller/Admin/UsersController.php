<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;

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
    }

    public function isAuthorized($user)
    {
        if(isset($user) && $user['profile_id'] == 1)
        {
            return true;
        }
        parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Grades', 'Teams', 'Profiles']
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    //Logout
    public function logout()
    {
        $this->Flash->success('Logoff efetuado com sucesso.');
        return $this->redirect($this->Auth->logout());
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Grades', 'Teams', 'Profiles', 'GradesActivities']
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

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

        if ($this->request->is('post')) {

            if($this->request->data['password'] != $this->request->data['passwordconfirm']) {
                $this->Flash->error(__('As senhas inseridas não condizem, por favor, cadastre novamente.'));
                return $this->redirect(['action' => 'index']);
            }

            $user = $this->Users->patchEntity($user, $this->request->data);

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
                if($user['profile_id'] == 2) {
                    $this->Flash->warning(__('Por favor, cadastre um curso e relacione ao novo coordenador.'));
                    return $this->redirect(['controller' => 'Courses', 'action' => 'index']);
                }
                else if($user['profile_id'] == 3) {
                    $this->Flash->success(__('O usuário foi salvo.'));
                    return $this->redirect(['action' => 'index']);
                }
                
            }
            $this->Flash->error(__('Não foi possível salvar o usuário. Por favor, tente novamente.'));
        }
        $grades = $this->Users->Grades->find('list', ['limit' => 200, 'keyField' => 'id', 'valueField' => 'description']);
        $teams = $this->Users->Teams->find('list', ['limit' => 200]);
        $profiles = $this->Users->Profiles->find('list', ['limit' => 200]);
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
        $grades = $this->Users->Grades->find('list', ['limit' => 200, 'keyField' => 'id', 'valueField' => 'description']);
        $teams = $this->Users->Teams->find('list', ['limit' => 200]);
        $profiles = $this->Users->Profiles->find('list', ['limit' => 200]);
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

        if($user['id'] == 1)
        {
            $this->Flash->error(__('Operação negada.'));
            return $this->redirect(['action' => 'index']);
        }

        if($this->hasUsersGradesActivities($id))
        {
            $this->Flash->error(__('Não foi possível deletar o usuário pois existem atividades vinculadas.'));            
        }
        else
        {
            if ($this->Users->delete($user)) {
                $this->Flash->success(__('O usuário foi deletado.'));
            } else {
                $this->Flash->error(__('Não foi possível deletar o usuário pois existem atividades vinculadas.'));
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
}
