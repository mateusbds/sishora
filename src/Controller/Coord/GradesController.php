<?php
namespace App\Controller\Coord;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Grades Controller
 *
 * @property \App\Model\Table\GradesTable $Grades
 */
class GradesController extends AppController
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
        $this->loadModel('Activities');
        $this->loadModel('Courses');

        if(isset($user)) {

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

        $tempID = $this->Auth->user();
  
        $this->paginate = [
            'contain' => ['Courses']
        ];
       
        $grades = $this->paginate($this->Grades->find()->where(['Courses.id' => $tempID["course"]]));
        $this->set(compact('grades'));
        $this->set('_serialize', ['grades']);
    }

    /**
     * View method
     *
     * @param string|null $id Grade id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $grade = $this->Grades->get($id, [
            'contain' => ['Courses', 'Activities', 'Actuations', 'Users']
        ]);
        

        $this->set('grade', $grade);
        $this->set('_serialize', ['grade']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $grade = $this->Grades->newEntity();

        $user = $this->Auth->user();
        if(isset($user))
            $course = $this->Grades->Courses->find()->where(['user_id' => $user['id']])->toArray();

        if ($this->request->is('post')) {
            $grade = $this->Grades->patchEntity($grade, $this->request->data);

            if(isset($course))
                $grade['course_id'] = $course[0]['id'];
            else {
                $this->Flash->error(__('Ocorreu um erro, tente novamente.'));
                return $this->redirect(['action' => 'index']);
            }

            if ($this->Grades->save($grade)) {
                $this->Flash->success(__('A grade foi salva.'));

                return $this->redirect(['action' => 'edit/'.$grade['id']]);
            }
            $this->Flash->error(__('Não foi possível salvar a grande. Por favor, tente novamente.'));
        }
        $activities = $this->Grades->Activities->find('list', ['limit' => 200]);
        $actuations = $this->Grades->Actuations->find('list', ['limit' => 200]);
        $this->set(compact('grade', 'courses', 'activities', 'actuations'));
        $this->set('_serialize', ['grade']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Grade id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tempID = $this->Auth->user();
        $grade = $this->Grades->get($id, [
            'contain' => ['Activities', 'Actuations']
        ]);

        $result = $this->Grades->find()->where(['id' => $id , 'course_id' => $tempID["course"]]);
        $grade2 = $result->toArray();

        //debug($grade);exit;
     
        if ($this->request->is(['patch', 'post', 'put'])) {
            $grade = $this->Grades->patchEntity($grade, $this->request->data);
            if ($this->Grades->save($grade)) {
                $this->Flash->success(__('A grade foi salva.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível salvar a grande. Por favor, tente novamente.'));
        }

        //#################### Grades Activity ########################################
        $this->loadModel('GradesActivities');

        $mGradesActivities = $this->GradesActivities->find()->contain(['Actuations', 'Grades', 'Activities'])->where(['grade_id' => $grade2[0]['id']]);
        $mgradesActivities = $this->paginate($mGradesActivities);

        //$this->set('_serialize', ['mgradesActivities']);
        //#############################################################################

        $activities = $this->Grades->Activities->find('list', ['limit' => 200]);
        $actuations = $this->Grades->Actuations->find('list', ['limit' => 200]);
        $this->set(compact('grade', 'courses', 'activities', 'actuations', 'mgradesActivities', 'id'));
        $this->set('_serialize', ['grade']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Grade id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $grade = $this->Grades->get($id);
        if($this->hasGradesActivities($id))
        {
            $this->Flash->error(__('Não foi possível deletar a Grade pois existem atividades da grade ou alunos vinculados.'));            
        }
        else
        {
            if ($this->Grades->delete($grade)) {
                $this->Flash->success(__('A grade foi deletada.'));
            } else {
                $this->Flash->error(__('Não foi possível deletar a grande. Por favor, tente novamente.'));
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    function hasGradesActivities($id)
    {
        $this->loadModel('GradesActivities');
        $this->loadModel('Users');
        $gradesactivities = $this->GradesActivities->find()->where(['grade_id' => $id]);
        $users = $this->Users->find()->where(['grade_id' => $id]);
        return (count($gradesactivities->toArray()) || count($users->toArray()));
    }
    
}