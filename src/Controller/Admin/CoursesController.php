<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Courses Controller
 *
 * @property \App\Model\Table\CoursesTable $Courses
 */
class CoursesController extends AppController
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
            'contain' => ['Users']
        ];
        $courses = $this->paginate($this->Courses);

        $this->set(compact('courses'));
        $this->set('_serialize', ['courses']);
    }

    /**
     * View method
     *
     * @param string|null $id Course id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $course = $this->Courses->get($id, [
            'contain' => ['Users', 'Grades']
        ]);

        $this->set('course', $course);
        $this->set('_serialize', ['course']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $course = $this->Courses->newEntity();
        if ($this->request->is('post')) {
            $course = $this->Courses->patchEntity($course, $this->request->data);
            if ($this->Courses->save($course)) {
                $this->Flash->success(__('O curso foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possivel salvar o curso. Por favor, tente novamente.'));
        }
        $users = $this->Courses->Users->find('list', ['limit' => 200])->where(['Users.profile_id' => 2]);
        $this->set(compact('course', 'users'));
        $this->set('_serialize', ['course']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Course id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $course = $this->Courses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $course = $this->Courses->patchEntity($course, $this->request->data);
            if ($this->Courses->save($course)) {
                $this->Flash->success(__('O curso foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possivel salvar o curso. Por favor, tente novamente.'));
        }

        $users = $this->Courses->Users->find('list', ['limit' => 200]);
        $this->set(compact('course', 'users'));
        $this->set('_serialize', ['course']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Course id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $course = $this->Courses->get($id);
        if($this->hasGradesActivities($id))
        {
            $this->Flash->error(__('Não foi possível deletar o curso pois existem usuários ou grades vinculados.'));            
        }
        else
        {
            if ($this->Courses->delete($course)) {
                $this->Flash->success(__('O curso foi deletado.'));
            } else {
                $this->Flash->error(__('Não foi possivel deletar o curso. Por favor, tente novamente.'));
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    function hasGradesActivities($id)
    {
        $this->loadModel('Grades');
        $this->loadModel('Users');
        $grades = $this->Grades->find()->where(['course_id' => $id]);
        //$users = $this->Users->find()->where(['course_id' => $id]);
        return count($grades->toArray());
    }
}
