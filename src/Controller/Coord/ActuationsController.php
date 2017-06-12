<?php
namespace App\Controller\Coord;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Actuations Controller
 *
 * @property \App\Model\Table\ActuationsTable $Actuations
 */
class ActuationsController extends AppController
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

        //checa se existe grades cadastradas e redireciona caso nao haja nenhuma
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
        $actuations = $this->paginate($this->Actuations);

        $this->set(compact('actuations'));
        $this->set('_serialize', ['actuations']);
    }

    /**
     * View method
     *
     * @param string|null $id Actuation id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $actuation = $this->Actuations->get($id, [
            'contain' => ['Grades', 'GradesActivities']
        ]);

        $this->set('actuation', $actuation);
        $this->set('_serialize', ['actuation']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $actuation = $this->Actuations->newEntity();
        if ($this->request->is('post')) {
            $actuation = $this->Actuations->patchEntity($actuation, $this->request->data);
            if ($this->Actuations->save($actuation)) {
                $this->Flash->success(__('O Eixo de Atuação foi salva com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível salvar o Eixo de Atuação. Por favor, tente novamente.'));
        }
        $grades = $this->Actuations->Grades->find('list', ['limit' => 200]);
        $this->set(compact('actuation', 'grades'));
        $this->set('_serialize', ['actuation']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Actuation id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $actuation = $this->Actuations->get($id, [
            'contain' => ['Grades']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $actuation = $this->Actuations->patchEntity($actuation, $this->request->data);
            if ($this->Actuations->save($actuation)) {
                $this->Flash->success(__('O Eixo de Atuação foi salva com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível salvar o Eixo de Atuação. Por favor, tente novamente.'));
        }
        $grades = $this->Actuations->Grades->find('list', ['limit' => 200]);
        $this->set(compact('actuation', 'grades'));
        $this->set('_serialize', ['actuation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Actuation id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $actuation = $this->Actuations->get($id);
        if($this->hasGradesActivities($id))
        {
            $this->Flash->error(__('Não foi possível deletar o Eixo de Atuação pois existem Atividades da Grade vinculadas.'));            
        }
        else
        {
            if ($this->Actuations->delete($actuation)) {
                $this->Flash->success(__('O Eixo de Atuação foi deletado com sucesso.'));
            } 
            else
            {
                $this->Flash->error(__('Não foi possível deletar o Eixo de Atuação. Por favor, tente novamente.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }

    function hasGradesActivities($id)
    {
        $this->loadModel('GradesActivities');

        $gradesactivities = $this->GradesActivities->find()->where(['actuation_id' => $id]);
        return count($gradesactivities->toArray());
    }
}
