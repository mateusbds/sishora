<?php

namespace App\Controller;



use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Http\ServerRequest;
use Cake\Utility\Inflector;

/**
 * UsersGradesActivities Controller
 *
 * @property \App\Model\Table\UsersGradesActivitiesTable $UsersGradesActivities
 */

class UsersGradesActivitiesController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    public function initialize()
    {
        parent::initialize();
        $this->Auth->config('loginAction', ['controller' => 'Users', 'action' => 'login']);
        $this->Auth->allow(['']);
    }


    public function isAuthorized($user)
    {
        if(isset($user) && $user['profile_id'] == 3)
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
        $this->loadModel('Grades');
        $this->loadModel('Courses');

        $this->paginate = [
            'contain' => ['Users', 'GradesActivities.Activities']
        ];

        $activitiesID = $this->Auth->user()['id'];

        $usersGradesActivities = $this->paginate($this->UsersGradesActivities->find()->where(['user_id' => $activitiesID]));



        $users = $this->Auth->user();

        $query = $this->Grades->find()->where(['id' => $users['grade_id']]);

        $users['grade_name'] = $query->isEmpty() ? null : $query->first()->description;

        $users['qntHours'] =  $query->isEmpty() ? null : $query->first()->qntHours;



        $query = $this->Grades->find()->where(['id' => $users['grade_id']]);

        $data = $query->toArray();

        if(empty($data))

        {

            $this->Flash->error(__('Você não está vinculado a nenhuma grade.'));

        }

        else

        {

            $course = $this->Courses->find()->where(['id' => $data[0]['course_id']]);

            $users['course_name'] = $course->isEmpty() ? null : $course->first()->name;

        }



        $this->set(compact('usersGradesActivities', 'users'));

        $this->set('_serialize', ['usersGradesActivities']);

    }



    /**

     * Add method

     *

     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.

     */

    public function add() {
        $usersGradesActivity = $this->UsersGradesActivities->newEntity();
        $this->loadModel('Grades'); 

        $users = $this->Auth->user();
        $query = $this->Grades->find()->where(['id' => $users['grade_id']]);
        $users['grade_name'] = $query->isEmpty() ? null : $query->first()->description;
        $users['qntHours'] =  $query->isEmpty() ? null : $query->first()->qntHours;

        if ($this->request->is('post')) {
            $usersGradesActivity = $this->UsersGradesActivities->patchEntity($usersGradesActivity, $this->request->data);
            $usersGradesActivity['user_id'] = $this->Auth->user('id');

            $totalDeHoras = $this->UsersGradesActivities->find()->where(['user_id' => $users['id'], 'grades_activity_id' => $usersGradesActivity['grades_activity_id']]);
            $totalDeHoras = $totalDeHoras->toArray();


            $horas = 0;

            foreach($totalDeHoras as $totalDeHora):
                if($totalDeHora->validated == 1) {
                    $horas += $totalDeHora->carga_aproveitada;
                }

            endforeach;

            $compHours = $this->UsersGradesActivities->GradesActivities->get($usersGradesActivity['grades_activity_id']);

            if($horas >= $users['qntHours']*($compHours['limite']/100)) {
                $this->Flash->error(__('Você já atingiu o limite de horas nessa atividade.'));
                return $this->redirect(['action' => 'index']);
            }

            $limiteDeHoras = $this->UsersGradesActivities->find()->where(['user_id' => $users['id']]);

            $horas_2 = 0;

            foreach($limiteDeHoras as $limiteDeHora):
                if($limiteDeHora->validated == 1) {
                    $horas_2 += $limiteDeHora->carga_aproveitada;
                }

            endforeach;

            if($horas_2 >= $users['qntHours']) {
                $this->Flash->error(__('Você já preencheu suas horas complementares.'));
                return $this->redirect(['action' => 'index']);
            }

            //checa erros no arquivo
            if($usersGradesActivity['Model']['file_name']['error'] == 1 && $usersGradesActivity['Model']['file_name']['error'] == 2) {
                $this->Flash->error(__('O arquivo enviado excede o limite definido.'));
                return $this->redirect(['action' => 'index']);
            }
            else if($usersGradesActivity['Model']['file_name']['error'] == 4) {
                $this->Flash->error(__('Nenhum arquivo foi enviado.'));
                return $this->redirect(['action' => 'index']);
            }
            else if($usersGradesActivity['Model']['file_name']['error'] == 6) {
                $this->Flash->error(__('Pasta temporária ausênte. Contacte o administrador do sistema.'));
                return $this->redirect(['action' => 'index']);
            }
            else if($usersGradesActivity['Model']['file_name']['error'] == 7) {
                $this->Flash->error(__('Falha em escrever o arquivo em disco.'));
                return $this->redirect(['action' => 'index']);
            }
            else if($usersGradesActivity['Model']['file_name']['error'] == 8) { //erro nas extensões do php
                $this->Flash->error(__('Uma extensão do PHP interrompeu o upload do arquivo. Contacte o administrador do sistema.'));
                return $this->redirect(['action' => 'index']);
            }
            else {
                $this->Flash->error(__('Algo deu errado. Tente novamente mais tarde.'));
                return $this->redirect(['action' => 'index']);
            }

            //#############################################################
            $dir = WWW_ROOT.'aluno'.DS.$usersGradesActivity['user_id'].DS;
            $imagem_info = pathinfo($dir.$usersGradesActivity['Model']['file_name']['name']);
            $imagem_nome = strtolower(Inflector::slug($imagem_info['filename'],'-')).'.'.$imagem_info['extension'];
            $conta = 2;

            while (file_exists($dir.$imagem_nome)) {
                $imagem_nome  = strtolower(Inflector::slug($imagem_info['filename'],'-')).'-'.$conta;
                $imagem_nome .= '.'.$imagem_info['extension'];
                $conta++;
            }

            //checa se a extensão é certa
            $ext = pathinfo($dir.$imagem_nome, PATHINFO_EXTENSION);
            if(!$this->UsersGradesActivities->check_ext($ext)) {
                $this->Flash->error(__('Extensão inválida! Apenas png, jpg, jpeg, doc, docx e pdf permitidos.'));
                return $this->redirect(['action' => 'index']);
            }

            $usersGradesActivity['Model']['file_name']['name'] = $imagem_nome;

            //#############################################################



            //################################Calculo de horas equivalentes######################



            // unidade 0 = horas

            // unidade 1 = dias

            // unidade 2 = quantidade

                

            if($compHours['unit'] == 0)

            {

                $x = $usersGradesActivity['carga_horaria'] / $compHours['compHours'];

                if($x >= $users['qntHours']*($compHours['limite']/100))

                {

                    $x = $users['qntHours']*($compHours['limite']/100);

                }

            }

            else if($compHours['unit'] == 1)

            {

                $x = $usersGradesActivity['carga_horaria'] * $compHours['compHours'];

                if($x >= $users['qntHours']*($compHours['limite']/100))

                {

                    $x = $users['qntHours']*($compHours['limite']/100);

                }

            }

            else if($compHours['unit'] == 2)

            {

                $x = $usersGradesActivity['carga_horaria'] * $compHours['compHours'];

                if($x >= $users['qntHours']*($compHours['limite']/100))

                {

                    $x = $users['qntHours']*($compHours['limite']/100);

                }

            }

            $usersGradesActivity['carga_aproveitada'] = $x;



            //###################################################################################



            $usersGradesActivity['file_name'] = $imagem_nome;

            if ($this->UsersGradesActivities->save($usersGradesActivity)) {

                $this->Flash->success(__('Atividade foi salva.'));



                return $this->redirect(['action' => 'index']);

            }

            $this->Flash->error(__('Não foi possivel salvar a atividade. Por favor, tente novamente.'));

        }



        $grade_id = $this->Auth->user()['grade_id'];



        //$users = $this->UsersGradesActivities->Users->find('list', ['limit' => 200]);

        $horasComplementares = $this->UsersGradesActivities->GradesActivities->find();

        $gradesActivities = $this->UsersGradesActivities->GradesActivities->find('list', ['limit' => 200, 'keyField' => 'id' ,'valueField' => 'activity.name'])->where(['grade_id' => $grade_id])->contain(['Activities']);

        $gradesActivities = array_unique($gradesActivities->toArray());



        $this->set(compact('usersGradesActivity', 'users', 'gradesActivities', 'horasComplementares'));

        $this->set('_serialize', ['usersGradesActivity']);

    }



    /**

     * Edit method

     *

     * @param string|null $id Users Grades Activity id.

     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.

     * @throws \Cake\Network\Exception\NotFoundException When record not found.

     */

    public function edit($id = null)

    {



        $usersGradesActivity = $this->UsersGradesActivities->get($id, [

            'contain' => []

        ]);



        $file = $usersGradesActivity['file_name'];



        $this->loadModel('Grades'); 



        $users = $this->Auth->user();

        $query = $this->Grades->find()->where(['id' => $users['grade_id']]);

        $users['grade_name'] = $query->isEmpty() ? null : $query->first()->description;

        $users['qntHours'] =  $query->isEmpty() ? null : $query->first()->qntHours;



        $this->loadModel('Users');

        $inSystemUser = $this->Auth->user();


        if($usersGradesActivity->user_id == $inSystemUser['id']) {
            if($usersGradesActivity->validated != 1) {
                if ($this->request->is(['patch', 'post', 'put'])) {

                    $usersGradesActivity['validated'] = 2;
                    $usersGradesActivity = $this->UsersGradesActivities->patchEntity($usersGradesActivity, $this->request->data);

                    //checa erros no arquivo
                    if($usersGradesActivity['Model']['file_name']['error'] == 1 && $usersGradesActivity['Model']['file_name']['error'] == 2) {
                        $this->Flash->error(__('O arquivo enviado excede o limite definido.'));
                        return $this->redirect(['action' => 'index']);
                    }
                    else if($usersGradesActivity['Model']['file_name']['error'] == 4) {
                        $this->Flash->error(__('Nenhum arquivo foi enviado.'));
                        return $this->redirect(['action' => 'index']);
                    }
                    else if($usersGradesActivity['Model']['file_name']['error'] == 6) {
                        $this->Flash->error(__('Pasta temporária ausênte. Contacte o administrador do sistema.'));
                        return $this->redirect(['action' => 'index']);
                    }
                    else if($usersGradesActivity['Model']['file_name']['error'] == 7) {
                        $this->Flash->error(__('Falha em escrever o arquivo em disco.'));
                        return $this->redirect(['action' => 'index']);
                    }
                    else if($usersGradesActivity['Model']['file_name']['error'] == 8) { //erro nas extensões do php
                        $this->Flash->error(__('Uma extensão do PHP interrompeu o upload do arquivo. Contacte o administrador do sistema.'));
                        return $this->redirect(['action' => 'index']);
                    }
                    else {
                        $this->Flash->error(__('Algo deu errado. Tente novamente mais tarde.'));
                        return $this->redirect(['action' => 'index']);
                    }

                    //#########################################################################################
                    if($usersGradesActivity['Model']['file_name']['error'] == 0) {
                        $dir = WWW_ROOT.'aluno'.DS.$usersGradesActivity['user_id'].DS;
                        $imagem_info = pathinfo($dir.$usersGradesActivity['Model']['file_name']['name']);
                        $imagem_nome = strtolower(Inflector::slug($imagem_info['filename'],'-')).'.'.$imagem_info['extension'];
                        $conta = 2;
                        while (file_exists($dir.$imagem_nome)) {
                            $imagem_nome  = strtolower(Inflector::slug($imagem_info['filename'],'-')).'-'.$conta;
                            $imagem_nome .= '.'.$imagem_info['extension'];
                            $conta++;
                        }
                        $usersGradesActivity['Model']['file_name']['name'] = $imagem_nome;
                        $usersGradesActivity['file_name'] = $imagem_nome;
                    }
                    else {
                        $usersGradesActivity['file_name'] = $file;
                    }
                    //################################Calculo de horas equivalentes######################

                    // unidade 0 = horas
                    // unidade 1 = dias
                    // unidade 2 = quantidade

                    $compHours = $this->UsersGradesActivities->GradesActivities->get($usersGradesActivity['grades_activity_id']);

                    if($compHours['unit'] == 0)
                    {
                        $x = $usersGradesActivity['carga_horaria'] / $compHours['compHours'];
                        if($x >= $users['qntHours']*($compHours['limite']/100))
                        {
                            $x = $users['qntHours']*($compHours['limite']/100);
                        }
                    }

                    else if($compHours['unit'] == 1)
                    {
                        $x = $usersGradesActivity['carga_horaria'] * $compHours['compHours'];
                        if($x >= $users['qntHours']*($compHours['limite']/100))
                        {
                            $x = $users['qntHours']*($compHours['limite']/100);
                        }
                    }

                    else if($compHours['unit'] == 2)
                    {
                        $x = $usersGradesActivity['carga_horaria'] * $compHours['compHours'];
                        if($x >= $users['qntHours']*($compHours['limite']/100))
                        {
                            $x = $users['qntHours']*($compHours['limite']/100);
                        }
                    }

                    $usersGradesActivity['carga_aproveitada'] = $x;

                    //###################################################################################

                    if ($this->UsersGradesActivities->save($usersGradesActivity)) {
                        $this->Flash->success(__('Atividade foi salva.'));
                        return $this->redirect(['action' => 'index']);
                    }
                    $this->Flash->error(__('Não foi possível salvar a atividade. Por favor, tente novamente.'));
                }

                $grade_id = $this->Auth->user()['grade_id'];
                //$users = $this->UsersGradesActivities->Users->find('list', ['limit' => 200]);
                $horasComplementares = $this->UsersGradesActivities->GradesActivities->find();
                $gradesActivities = $this->UsersGradesActivities->GradesActivities->find('list', ['limit' => 200, 'keyField' => 'id' ,'valueField' => 'activity.name'])->where(['grade_id' => $grade_id])->contain(['Activities']);
                $gradesActivities = array_unique($gradesActivities->toArray());
                $this->set(compact('usersGradesActivity', 'users', 'gradesActivities', 'horasComplementares'));
                $this->set('_serialize', ['usersGradesActivity']);
            }
            else
            {
                $this->Flash->error(__('Não é permitido editar uma atividade que já foi validada.'));
                return $this->redirect(['action' => 'index']);
            }
        }
        else
        {
            $this->Flash->error(__('Não é permitido editar uma atividade que não lhe pertence.'));
            return $this->redirect(['action' => 'index']);
        }

    }



    /**

     * Delete method

     *

     * @param string|null $id Users Grades Activity id.

     * @return \Cake\Network\Response|null Redirects to index.

     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.

     */

    public function delete($id = null)

    {

        $this->request->allowMethod(['post', 'delete']);

        $usersGradesActivity = $this->UsersGradesActivities->get($id);



        if($usersGradesActivity['validated'] == 1)

        {

            $this->Flash->error(__('Não é possível deletar uma atividade que já foi validada.'));            

        }

        else

        {

            if ($this->UsersGradesActivities->delete($usersGradesActivity)) {

                $this->Flash->success(__('A atividade complementar foi deletada.'));

            } else {

                $this->Flash->error(__('Não foi possível deletar a atividade complementar. Por favor, tente novamente.'));

            }

        }



        return $this->redirect(['action' => 'index']);

    }



    public function download($user, $file_name)

    {

        $file_name = base64_decode($file_name);

        $filePath = WWW_ROOT . 'aluno'. DS . $user . DS . $file_name;

        $this->response->file($filePath, ['download'=> true, 'name'=> $file_name]);

        return $this->response;

    }



    public function obs($id = null)

    {

        $usersGradesActivity = $this->UsersGradesActivities->get($id, [

            'contain' => ['Users', 'GradesActivities']

        ]);



        $this->set('usersGradesActivity', $usersGradesActivity);

        $this->set('_serialize', ['usersGradesActivity']);

    }

}

