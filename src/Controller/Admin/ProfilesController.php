<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Profiles Controller
 *
 * @property \App\Model\Table\ProfilesTable $Profiles
 */
class ProfilesController extends AppController
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
        $profiles = $this->paginate($this->Profiles);

        $this->set(compact('profiles'));
        $this->set('_serialize', ['profiles']);
    }

    /**
     * View method
     *
     * @param string|null $id Profile id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function view($id = null)
    // {
    //     $profile = $this->Profiles->get($id, [
    //         'contain' => []
    //     ]);

    //     $this->set('profile', $profile);
    //     $this->set('_serialize', ['profile']);
    // }

    // /**
    //  * Add method
    //  *
    //  * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
    //  */
    // public function add()
    // {
    //     $profile = $this->Profiles->newEntity();
    //     if ($this->request->is('post')) {
    //         $profile = $this->Profiles->patchEntity($profile, $this->request->data);
    //         if ($this->Profiles->save($profile)) {
    //             $this->Flash->success(__('O perfil foi salvo.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('Não foi possível salvar o perfil. Por favor, tente novamente.'));
    //     }
    //     $this->set(compact('profile'));
    //     $this->set('_serialize', ['profile']);
    // }

    // /**
    //  * Edit method
    //  *
    //  * @param string|null $id Profile id.
    //  * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
    //  * @throws \Cake\Network\Exception\NotFoundException When record not found.
    //  */
    // public function edit($id = null)
    // {
    //     $profile = $this->Profiles->get($id, [
    //         'contain' => []
    //     ]);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $profile = $this->Profiles->patchEntity($profile, $this->request->data);
    //         if ($this->Profiles->save($profile)) {
    //             $this->Flash->success(__('O perfil foi salvo.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('Não foi possível salvar o perfil. Por favor, tente novamente.'));
    //     }
    //     $this->set(compact('profile'));
    //     $this->set('_serialize', ['profile']);
    // }

    // /**
    //  * Delete method
    //  *
    //  * @param string|null $id Profile id.
    //  * @return \Cake\Network\Response|null Redirects to index.
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $profile = $this->Profiles->get($id);
    //     if($this->hasProfiles($id))
    //     {
    //         $this->Flash->error(__('Não foi possível deletar o perfil pois existem usuários vinculados.'));            
    //     }
    //     else
    //     {
    //         if ($this->Profiles->delete($profile)) {
    //             $this->Flash->success(__('O perfil foi deletado.'));
    //         } else {
    //             $this->Flash->error(__('Não foi possível deletar o perfil. Por favor, tente novamente.'));
    //         }
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }

    // function hasProfiles($id)
    // {
    //     $this->loadModel('Users');
    //     $usersprofiles = $this->Users->find()->where(['profile_id' => $id]);
    //     return count($usersprofiles->toArray());
    // }
}
