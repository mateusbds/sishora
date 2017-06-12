<?php
namespace App\Controller\Coord;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * GradesActivities Controller
 *
 * @property \App\Model\Table\GradesActivitiesTable $GradesActivities
 */
class GradesActivitiesController extends AppController
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
        $this->paginate = [
            'contain' => ['Activities', 'Grades', 'Actuations']
        ];
        $gradesActivities = $this->paginate($this->GradesActivities);

        $this->set(compact('gradesActivities'));
        $this->set('_serialize', ['gradesActivities']);
    }

    /**
     * View method
     *
     * @param string|null $id Grades Activity id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $gradesActivity = $this->GradesActivities->get($id, [
            'contain' => ['Activities', 'Grades', 'Actuations', 'Users']
        ]);

        $this->set('gradesActivity', $gradesActivity);
        $this->set('_serialize', ['gradesActivity']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($gradeID = null)
    {
        $gradesActivity = $this->GradesActivities->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['grade_id'] = $gradeID;
            $gradesActivity = $this->GradesActivities->patchEntity($gradesActivity, $this->request->data);
            //$gradesActivity['grade_id'] = $gradeID;
            //debug($gradesActivity); exit;
            if ($this->GradesActivities->save($gradesActivity)) {
                $this->Flash->success(__('A atividade da grade foi salva.'));
                if($gradeID == null) {
                    return $this->redirect(['action' => 'edit']);
                }
                else {
                    return $this->redirect(['controller' => 'Grades', 'action' => 'edit', $gradeID]);
                }
            }
            $this->Flash->error(__('Não foi possivel salvar a atividade da grade. Por favor, tente novamente.'));
        }
        $activities = $this->GradesActivities->Activities->find('list', ['limit' => 200]);
        $grades = $this->GradesActivities->Grades->find('list', ['limit' => 200, 'keyField' => 'id', 'valueField' => 'description']);
        $actuations = $this->GradesActivities->Actuations->find('list', ['limit' => 200]);
        $users = $this->GradesActivities->Users->find('list', ['limit' => 200]);
        $this->set(compact('gradesActivity', 'activities', 'grades', 'actuations', 'users', 'gradeID'));
        $this->set('_serialize', ['gradesActivity']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Grades Activity id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $gradeID = null)
    {
        $gradesActivity = $this->GradesActivities->get($id, [
            'contain' => ['Users']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $gradesActivity = $this->GradesActivities->patchEntity($gradesActivity, $this->request->data);
            if ($this->GradesActivities->save($gradesActivity)) {
                $this->Flash->success(__('A atividade da grade foi salva.'));

                if($gradeID == null)
                {
                    return $this->redirect(['action' => 'edit']);
                }
                else
                {
                    return $this->redirect(['controller' => 'Grades', 'action' => 'edit', $gradeID]);
                }
            }
            $this->Flash->error(__('Não foi possivel salvar a atividade da grade. Por favor, tente novamente.'));
        }
        $activities = $this->GradesActivities->Activities->find('list', ['limit' => 200]);
        $grades = $this->GradesActivities->Grades->find('list', ['limit' => 200,  'keyField' => 'id', 'valueField' => 'description']);
        $actuations = $this->GradesActivities->Actuations->find('list', ['limit' => 200]);
        $users = $this->GradesActivities->Users->find('list', ['limit' => 200]);
        $this->set(compact('gradesActivity', 'activities', 'grades', 'actuations', 'users', 'gradeID'));
        $this->set('_serialize', ['gradesActivity']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Grades Activity id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $gradeID = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $gradesActivity = $this->GradesActivities->get($id);
        
        if($this->hasUsersGradesActivities($id))
        {
            $this->Flash->error(__('Não foi possível deletar a atividade da grade pois existem atividades vinculadas.'));            
        }
        else
        {
            if ($this->GradesActivities->delete($gradesActivity)) {
                $this->Flash->success(__('A atividade da grade foi deletada.'));
            } else {
                $this->Flash->error(__('Não foi possivel deletar a atividade da grade. Por favor, tente novamente.'));
            }
        }

        return $this->redirect(['controller' => 'Grades', 'action' => 'edit', $gradeID]);
    }

    function hasUsersGradesActivities($id)
    {
        $this->loadModel('UsersGradesActivities');
        $usersgradesactivities = $this->UsersGradesActivities->find()->where(['grades_activity_id' => $id]);
        return count($usersgradesactivities->toArray());
    }
}
