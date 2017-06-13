<?php
namespace App\Controller\Coord;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\View\ViewBuilder;
/**
 * Teams Controller
 *
 * @property \App\Model\Table\TeamsTable $Teams
 */
class TeamsController extends AppController
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
        $this->paginate = [
            'contain' => ['Courses']
        ];
        $teams = $this->paginate($this->Teams);

        $this->set(compact('teams'));
        $this->set('_serialize', ['teams']);
    }

    /**
     * View method
     *
     * @param string|null $id Team id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function viewUsers($id = null)
    {
        $team = $this->Teams->get($id, [
            'contain' => ['Courses', 'Users']
        ]);

        $tempID = $this->Auth->user();

        $users = $this->Teams->Users->find()->contain(['Profiles', 'Courses', 'Grades', 'Teams'])->where(['Profiles.id' => 3, 'Grades.course_id' => $tempID['course'], 'team_id' => $id]);

        $this->set(compact('teams', 'users'));
        $this->set('_serialize', ['team']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $team = $this->Teams->newEntity();

        $usersTable = TableRegistry::get('Users');
        $this->loadModel('Users');

        $tempID = $this->Auth->user();

        if ($this->request->is('post')) {
            $team = $this->Teams->patchEntity($team, $this->request->data);
            $team['course_id'] = $tempID['course'];

            $tos = $team['to'];

            $posSaveTeam = $this->Teams->save($team);

            if ($posSaveTeam) {
                if($tos)
                {
                    foreach($tos as $to):
                    
                        $user = $usersTable->get($to);
                        $user->team_id = $posSaveTeam['id'];

                        $this->Users->save($user);

                    endforeach;
                }

                $this->Flash->success(__('A turma foi salva.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível adicionar a turma. Por favor, tente novamente.'));
        }

        $users = $this->Teams->Users->find()->contain(['Profiles', 'Courses', 'Grades', 'Teams'])->where(['Profiles.id' => 3, 'Grades.course_id' => $tempID['course'], 'team_id IS NULL']);
        $courses = $this->Teams->Courses->find('list', ['limit' => 200]);
        $this->set(compact('team', 'courses', 'users'));
        $this->set('_serialize', ['team']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Team id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $team = $this->Teams->get($id, [
            'contain' => []
        ]);

        $usersTable = TableRegistry::get('Users');
        $this->loadModel('Users');

        $tempID = $this->Auth->user();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $team = $this->Teams->patchEntity($team, $this->request->data);

            $tos = $team['to'];
            $froms = $team['from'];

            $posSaveTeam = $this->Teams->save($team);

            if ($posSaveTeam) {
                if($tos)
                {
                    foreach($tos as $to):
                    
                        $user = $usersTable->get($to);
                        $user->team_id = $posSaveTeam['id'];

                        $this->Users->save($user);

                    endforeach;
                }

                if($froms)
                {
                    foreach($froms as $from):
                    
                        $user = $usersTable->get($from);
                        $user->team_id = null;

                        $this->Users->save($user);

                    endforeach;
                }

                $this->Flash->success(__('A turma foi salva.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível editar a turma. Por favor, tente novamente.'));
        }

        $users = $this->Teams->Users->find()->contain(['Profiles', 'Courses', 'Grades', 'Teams'])->where(['Profiles.id' => 3, 'Grades.course_id' => $tempID['course']]);
        $courses = $this->Teams->Courses->find('list', ['limit' => 200]);
        $this->set(compact('team', 'courses', 'users'));
        $this->set('_serialize', ['team']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Team id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $team = $this->Teams->get($id);

        $this->loadModel('Users');
        $tempID = $this->Auth->user();

        $users = $this->Teams->Users->find()->contain(['Profiles', 'Courses', 'Grades', 'Teams'])->where(['Profiles.id' => 3, 'Grades.course_id' => $tempID['course'], 'team_id' => $id]);

        if ($this->Teams->delete($team)) {

            foreach($users as $user):

                $user->team_id = null;
                $this->Users->save($user);

            endforeach;

            $this->Flash->success(__('A turma foi deletada.'));
        } else {
            $this->Flash->error(__('Não foi possível deletar a turma. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function pdfView($id = null)
    {
        /* TODO: enviar para o pdf todos os alunos e todas as grades. Na view será feito a
        filtragem dos alunos de acordo com suas horas e as horas da grade que ele está cadastrado. */

        $team = $this->Teams->get($id);
        $this->loadModel('Courses');
        $this->loadModel('UsersGradesActivities');

        $fileName = $id.$team['semestre'].$team['ano'];

        $this->viewBuilder()
            ->className('Dompdf.Pdf')
            ->layout('Dompdf.default')
            ->options(['config' => [
                'filename' => $fileName,
                'render' => 'download',
                'size' => 'A4',
            ]]);

        $tempID = $this->Auth->user();

        $usersGradesActivities = $this->UsersGradesActivities->find();
        $users = $this->Teams->Users->find()->contain(['Profiles', 'Courses', 'Grades', 'Teams', 'Activitycomphours'])->where(['Profiles.id' => 3, 'Grades.course_id' => $tempID['course'], 'team_id' => $id, 'Activitycomphours.hours = Grades.qntHours']);
        $course = $this->Courses->find()->where(['id' => $tempID['course']]);
        $course = $course->toArray();

        $this->set(compact('team', 'users', 'course', 'usersGradesActivities'));
        $this->set('_serialize', ['team']);
    }
}
