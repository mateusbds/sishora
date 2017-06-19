<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users */

class UsersController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    public function initialize()
    {
        parent::initialize();
         $this->loadModel('Courses');
        if (isset($user)) 
        {
            $this->Auth->setUser($user);
            if($user['profile_id'] == 1)
            {
                $this->Auth->config('loginRedirect', ['prefix' => 'admin' ,'controller' => 'Users', 'action' => 'index']);
                return $this->redirect($this->Auth->redirectUrl());
            }
            else if($user['profile_id'] == 2)
            {
                $this->Auth->config('loginRedirect', ['prefix' => 'coord', 'controller' => 'Users', 'action' => 'index']);
                return $this->redirect($this->Auth->redirectUrl());
            }
            else if($user['profile_id'] == 3)
            {
                $this->Auth->config('loginRedirect', ['controller' => 'usersGradesActivities', 'action' => 'index']);
                return $this->redirect($this->Auth->redirectUrl());
            }
        }
    }

    public function isAuthorized($user)
    {
        parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    // public function index()
    // {
    //     $this->paginate = [
    //         'contain' => ['Grades', 'Teams', 'Profiles']
    //     ];
    //     $users = $this->paginate($this->Users);

    //     $this->set(compact('users'));
    //     $this->set('_serialize', ['users']);
    // }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user && isset($user)) {

                $results = $this->Courses->find()->where(['user_id' => $user['id']]);
                $result = $results->toArray();
                if($result)
                {
                    $id_curso = $result[0]['id'];
                    $user["course"] = $id_curso;
                }
               
                $this->Auth->setUser($user);
                if($user['profile_id'] == 1)
                {
                    $this->Auth->config('loginRedirect', ['prefix' => 'admin' ,'controller' => 'Users', 'action' => 'index']);
                    return $this->redirect($this->Auth->redirectUrl());
                }
                else if($user['profile_id'] == 2)
                {
                    $this->Auth->config('loginRedirect', ['prefix' => 'coord', 'controller' => 'Users', 'action' => 'index']);
                    return $this->redirect($this->Auth->redirectUrl());
                }
                else if($user['profile_id'] == 3)
                {
                    $this->Auth->config('loginRedirect', ['controller' => 'usersGradesActivities', 'action' => 'index']);
                    return $this->redirect($this->Auth->redirectUrl());
                }
            }
            $this->Flash->error('Seu login ou senha está incorreto.');
        }
    }

    public function forgotPassword()
    {
        $users = $this->Users->find()->toArray();
        $recoverEmail;
        $password;
        $usuario;
        if($this->request->is('post')) {
            $email = $this->request->data;
            ///TODO: deixar apenas um email cadastrado no sistema
            foreach($users as $user):
                if($user['email'] == $email['email']){
                    $recoverEmail = $user['email'];
                    $password = $this->randomPassword();
                    $usuario = $user;
                }
            endforeach;

            if(!isset($recoverEmail))
            {
                $this->Flash->error(_("Informe um email cadastrado."));
            }
            else
            {
                $message = "Sua nova senha foi definida como: $password";
                $this->sendEmail($recoverEmail, $message);
                $user['password'] = $password;
                if($this->Users->save($usuario))
                {
                    $this->Flash->success(_("Um email foi enviado para sua conta."));
                }
                else
                {
                    $this->Flash->error(_("Erro no sistema, por favor, tente novamente mais tarde."));
                }
                $this->redirect(['action' => 'login']);
            }
        }
    }

    function sendEmail($contact, $content)
    {
        $email = new Email('default');
        $email->from(['me@example.com' => 'Sishora Password Recovery'])
                        ->to("$contact")
                        ->subject('Password Recovery')
                        ->send("$content");
    }

    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
