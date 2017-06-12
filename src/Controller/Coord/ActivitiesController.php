<?php
namespace App\Controller\Coord;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Activities Controller
 *
 * @property \App\Model\Table\ActivitiesTable $Activities
 */
class ActivitiesController extends AppController
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

            if(count($activities) && !count($grades))
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
        $activities = $this->paginate($this->Activities);

        $this->set(compact('activities'));
        $this->set('_serialize', ['activities']);
    }

    /**
     * View method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $activity = $this->Activities->get($id, [
            'contain' => ['Grades']
        ]);

        $this->set('activity', $activity);
        $this->set('_serialize', ['activity']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $activity = $this->Activities->newEntity();
        if ($this->request->is('post')) {
            $activity = $this->Activities->patchEntity($activity, $this->request->data);
            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('A atividade foi salva.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possivel salvar a atividade. Por favor, tente novamente.'));
        }
        $grades = $this->Activities->Grades->find('list', ['limit' => 200]);
        $this->set(compact('activity', 'grades'));
        $this->set('_serialize', ['activity']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $activity = $this->Activities->get($id, [
            'contain' => ['Grades']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activity = $this->Activities->patchEntity($activity, $this->request->data);
            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('A atividade foi salva.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possivel salvar a atividade. Por favor, tente novamente.'));
        }
        $grades = $this->Activities->Grades->find('list', ['limit' => 200]);
        $this->set(compact('activity', 'grades'));
        $this->set('_serialize', ['activity']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $activity = $this->Activities->get($id);
        if ($this->Activities->delete($activity)) {
            $this->Flash->success(__('A atividade foi deletada.'));
        } else {
            $this->Flash->error(__('Não foi possivel deletar a atividade. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
