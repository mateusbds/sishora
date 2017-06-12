<?php
namespace App\Controller\Coord;

use App\Controller\AppController;

/**
 * Activitycomphours Controller
 *
 * @property \App\Model\Table\ActivitycomphoursTable $Activitycomphours
 */
class ActivitycomphoursController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $activitycomphours = $this->paginate($this->Activitycomphours);

        $this->set(compact('activitycomphours'));
        $this->set('_serialize', ['activitycomphours']);
    }

    /**
     * View method
     *
     * @param string|null $id Activitycomphour id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $activitycomphour = $this->Activitycomphours->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('activitycomphour', $activitycomphour);
        $this->set('_serialize', ['activitycomphour']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $activitycomphour = $this->Activitycomphours->newEntity();
        if ($this->request->is('post')) {
            $activitycomphour = $this->Activitycomphours->patchEntity($activitycomphour, $this->request->data);
            if ($this->Activitycomphours->save($activitycomphour)) {
                $this->Flash->success(__('The activitycomphour has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The activitycomphour could not be saved. Please, try again.'));
        }
        $this->set(compact('activitycomphour'));
        $this->set('_serialize', ['activitycomphour']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Activitycomphour id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $activitycomphour = $this->Activitycomphours->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activitycomphour = $this->Activitycomphours->patchEntity($activitycomphour, $this->request->data);
            if ($this->Activitycomphours->save($activitycomphour)) {
                $this->Flash->success(__('The activitycomphour has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The activitycomphour could not be saved. Please, try again.'));
        }
        $this->set(compact('activitycomphour'));
        $this->set('_serialize', ['activitycomphour']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Activitycomphour id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $activitycomphour = $this->Activitycomphours->get($id);
        if ($this->Activitycomphours->delete($activitycomphour)) {
            $this->Flash->success(__('The activitycomphour has been deleted.'));
        } else {
            $this->Flash->error(__('The activitycomphour could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
