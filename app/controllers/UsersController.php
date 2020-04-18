<?php
declare(strict_types=1);

use Phalcon\Flash\Direct; 
use Phalcon\Flash\Session;

// use Phalcon\Mvc\Model;

class UsersController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction() {
        $users = Users::find();
		$this->view->users = $users;
    }

    /** Searches for users  NO SE USA Y NO VA*/
    public function searchAction() {
        $users = Users::findFirst();
        if (count($users) == 0) {
            $this->flash->notice("The search did not find any users");
            $this->dispatcher->forward([
                "controller" => "users",
                "action" => "index"
            ]);
            return;
        }
        $this->view->usuarios = count($users);
        $this->view->page = $users;
    }

    /** Displays the creation form   */
    public function newAction()
    {
        //
    }

    /** Edits a user */
    public function editAction($id) {
        if (!$this->request->isPost()) {
            $user = Users::findFirstByid($id);
            if (!$user) {
                $this->flash->error("user was not found");
                $this->dispatcher->forward([
                    'controller' => "users",
                    'action' => 'index'
                ]);
                return;
            }

            $this->view->id = $user->id;

            $this->tag->setDefault("id", $user->id);
            $this->tag->setDefault("nombre", $user->nombre);
            $this->tag->setDefault("apellidos", $user->apellidos);
            $this->tag->setDefault("email", $user->email);
            $this->tag->setDefault("pass", $user->pass);
            $this->tag->setDefault("nivel", $user->nivel);
            $this->tag->setDefault("lang", $user->lang);            
        }
		
    }

    /** Creates a new user   */
    public function createAction() {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'index'
            ]);
            return;
        }

        $user = new Users();
        $user->nombre = $this->request->getPost('nombre');
        $user->apellidos = $this->request->getPost('apellidos');
        $user->email = $this->request->getPost('email');
        $user->pass = $this->request->getPost('pass');
        $user->nivel = $this->request->getPost('nivel');
		$user->lang = $this->request->getPost('lang');

        if (!$user->save()) {
			$messages = $user->getMessages();
            foreach ($messages as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'new'
            ]);
            return;
        }

        $this->flash->success("user was created successfully");
        $this->dispatcher->forward([
            'controller' => "users",
            'action' => 'index'
        ]);
    }

    /** Saves a user edited   */
    public function saveAction() {
		
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'index'
            ]);
            return;
        }


        $id = $this->request->getPost("id");
        $user = Users::findFirstByid($id);

        if (!$user) {
            $this->flash->error("user does not exist " . $id);
            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'index'
            ]);
            return;
        }

        $user->nombre = $this->request->getPost('nombre');
        $user->apellidos = $this->request->getPost('apellidos');
        $user->email = $this->request->getPost('email');
        $user->pass = $this->request->getPost('pass');
        $user->nivel = $this->request->getPost('nivel');
		$user->lang = $this->request->getPost('lang');

        if (!$user->save()) {
			$messages = $user->getMessages();
			
            foreach ($messages as $message) {
                $this->flash->error($message->getMessage());
            }
            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'edit',
                'params' => [$user->id]
            ]);
            return;
        }

        $this->flash->success("user was updated successfully");
        $this->dispatcher->forward([
            'controller' => "users",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a user
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $user = Users::findFirstByid($id);
        if (!$user) {
            $this->flash->error("user was not found");

            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'index'
            ]);

            return;
        }

        if (!$user->delete()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "users",
                'action' => 'index'
            ]);

            return;
        }

        $this->flash->success("user was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "users",
            'action' => "index"
        ]);
    }
}
