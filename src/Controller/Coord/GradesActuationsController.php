<?php
namespace App\Controller\Coord;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * GradesActuations Controller
 *
 * @property \App\Model\Table\GradesActuationsTable $GradesActuations
 */
class GradesActuationsController extends AppController
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
            'contain' => ['Actuations', 'Grades']
        ];
        $gradesActuations = $this->paginate($this->GradesActuations);

        $this->set(compact('gradesActuations'));
        $this->set('_serialize', ['gradesActuations']);
    }

    /**
     * View method
     *
     * @param string|null $id Grades Actuation id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $gradesActuation = $this->GradesActuations->get($id, [
            'contain' => ['Actuations', 'Grades']
        ]);

        $this->set('gradesActuation', $gradesActuation);
        $this->set('_serialize', ['gradesActuation']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $gradesActuation = $this->GradesActuations->newEntity();
        if ($this->request->is('post')) {
            $gradesActuation = $this->GradesActuations->patchEntity($gradesActuation, $this->request->data);
            if ($this->GradesActuations->save($gradesActuation)) {
                $this->Flash->success(__('The grades actuation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The grades actuation could not be saved. Please, try again.'));
        }
        $actuations = $this->GradesActuations->Actuations->find('list', ['limit' => 200]);
        $grades = $this->GradesActuations->Grades->find('list', ['limit' => 200]);
        $this->set(compact('gradesActuation', 'actuations', 'grades'));
        $this->set('_serialize', ['gradesActuation']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Grades Actuation id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $gradesActuation = $this->GradesActuations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $gradesActuation = $this->GradesActuations->patchEntity($gradesActuation, $this->request->data);
            if ($this->GradesActuations->save($gradesActuation)) {
                $this->Flash->success(__('The grades actuation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The grades actuation could not be saved. Please, try again.'));
        }
        $actuations = $this->GradesActuations->Actuations->find('list', ['limit' => 200]);
        $grades = $this->GradesActuations->Grades->find('list', ['limit' => 200]);
        $this->set(compact('gradesActuation', 'actuations', 'grades'));
        $this->set('_serialize', ['gradesActuation']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Grades Actuation id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $gradesActuation = $this->GradesActuations->get($id);
        if ($this->GradesActuations->delete($gradesActuation)) {
            $this->Flash->success(__('The grades actuation has been deleted.'));
        } else {
            $this->Flash->error(__('The grades actuation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
