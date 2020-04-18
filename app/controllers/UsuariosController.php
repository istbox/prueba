<?php
 
// use Phalcon\Mvc\Model\Criteria;
// use Phalcon\Paginator\Adapter\Model as Paginator;
use RegistroForm as FormRegister;
use LoginForm as FormLogin;
use EditaForm as FormEdit;


class UsuariosController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle(' | B-MED');
//        $this->view->t = $this->getTranslation(); 
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->tag->prependTitle('Usuarios');
//        $this->persistent->parameters = null;
        $this->flashSession->error("Acceso erróneo");
        $this->response->redirect("index");

//        return $this->dispatcher->forward(array('controller' => 'index', 'action' => 'index'));        
    }

    public function registroAction()
    {
        $this->tag->prependTitle('Registro Usuario');
        $form = new FormRegister();
        if ($this->request->isPost()) {
			
            if ($form->isValid($this->request->getPost())) {
                $usuario = new Usuarios();
                $usuario->assign(array(
                'nombre'    =>  $this->request->getPost('nombre'),
                'apellidos' =>  $this->request->getPost('apellidos'),
                'email'     =>  $this->request->getPost('email', array('striptags', 'trim', 'email')),
                'password'  =>  sha1($this->request->getPost('password')),
                'colegiado' =>  $this->request->getPost('colegiado'),
                'nro_dni'   =>  $this->request->getPost('nro_dni'),                
                'varios'    =>  $this->request->getPost('varios'),
                'lang'      =>  $this->request->getPost('lang'),
                'activo'    =>  $this->request->getPost('activo'),
                'premium'   =>  $this->request->getPost('premium'),
                'medico'    =>  $this->request->getPost('medico'),
                'creado'    =>  $this->request->getPost('creado'),
                ));
                if ($usuario->save()) {                                    
                    return $this->dispatcher->forward(array('controller' => 'index', 'action' => 'index'));
				}                                                      
			}
        }

        $tyc = Texto::findFirst([
            "lang = ?1 AND base = ?2",
            "bind" => [
                1 => $this->session->get("lang"),
                2 => "term_cond_registro",
            ],
        ]);


        $this->view->prof = "0";
        $this->view->tyc = $tyc->mensaje;
        $this->view->form = $form;
//        $this->view->t = $this->getTranslation();
    }


    public function regprofsAction()
    {
        $this->tag->prependTitle('Registro Profesional');
        $form = new FormRegister();
        if ($this->request->isPost()) {
            if ($form->isValid($this->request->getPost()) != false) {   
                $usuario = new Usuarios();
                $usuario->assign(array(
                'nombre'    =>  $this->request->getPost('nombre'),
                'apellidos' =>  $this->request->getPost('apellidos'),
                'email'     =>  $this->request->getPost('email', array('striptags', 'trim', 'email')),
                'password'  =>  sha1($this->request->getPost('password')),
                'colegiado' =>  $this->request->getPost('colegiado'),
                'nro_dni'   =>  $this->request->getPost('nro_dni'),                
                'varios'    =>  $this->request->getPost('varios'),
                'lang'      =>  $this->request->getPost('lang'),
                'activo'    =>  $this->request->getPost('activo'),
                'premium'   =>  $this->request->getPost('premium'),
                'medico'    =>  $this->request->getPost('medico'),
                'creado'    =>  $this->request->getPost('creado'),
                ));
                if ($usuario->save()) {                                    
                    return $this->dispatcher->forward(array('controller' => 'index', 'action' => 'index'));
				}
            }               
        }
        $tyc = Texto::findFirst([
            "lang = ?1 AND base = ?2",
            "bind" => [
                1 => $this->session->get("lang"),
                2 => "term_cond_regprofs",
            ],
        ]);

        $this->view->prof = "1";
        $this->view->tyc = $tyc->mensaje;
        $this->view->form = $form;
//        $this->view->t = $this->getTranslation();
        $this->view->pick("usuarios/registro");        
    }


    public function confirmEmailAction()
    {
        $code = $this->dispatcher->getParam('code');
        $lang = $this->dispatcher->getParam('lang');
        $this->session->set("lang", $lang);
//        $t = $this->getTranslation();
        $confirmation = Altas::findFirstByCodigo($code);
//		echo $code . " , " . $lang;
//		die();

        if (!$confirmation) {
            return $this->dispatcher->forward(array(
                'controller' => 'index',
                'action' => 'index'
            ));
        } else {
			die("Error linea 127 UsuariosController/confirmEmailAction");
		}

        if ($confirmation->confirmada != 'N') {
            $this->flash->notice($t->_("ya_confirmado"));

            return $this->dispatcher->forward(array(
                'controller' => 'index',
                'action' => 'index'
            ));
        }
        $confirmation->confirmada = 'Y';
        $confirmation->usuario->varios = 'si';
        $confirmation->usuario->activo = '1';

        if (!$confirmation->update()) {

            foreach ($confirmation->getMessages() as $message) {
                $this->flash->error($message);
            }
//			die("No hay update - linea 149");
            return $this->dispatcher->forward(array(
                'controller' => 'index',
                'action' => 'index'
            ));
        }

        $this->flash->success($t->_("conf_email_ok"));
        return $this->dispatcher->forward(array(
            'controller' => 'index',
            'action' => 'index'
        ));
            return $this->response->redirect();
    }



    public function editaAction()
    {
        $this->tag->prependTitle('Edita Perfil');
        $form = new FormEdit();
//        $t = $this->getTranslation();
        $user = Usuarios::findFirstById($this->session->userId);
        if (!$user) {
            $this->flash->error($t->_("usuario_no_encontrado"));
            return $this->dispatcher->forward(array('controller' => 'usuarios', 'action' => 'index'));
        }

        if ($this->request->isPost()) {

            if ($form->isValid($this->request->getPost()) != false) {   
                $user->assign(array(
                    'nombre'    =>  $this->request->getPost('nombre'),
                    'apellidos' =>  $this->request->getPost('apellidos'),
                    'email'     =>  $this->request->getPost('email', array('striptags', 'trim', 'email')),
                    'colegiado' =>  $this->request->getPost('colegiado'),
                ));
                if (!$user->save()) {
                    $this->flash->error($t->_("error_datos_perfil"));
                    return $this->dispatcher->forward(array('controller' => 'index', 'action' => 'index'));
                } else {
                    $this->flash->success($t->_("datos_actualizados"));
                    $this->session->set("email", $user->email);
                    $this->session->set("username", $user->nombre . ' ' . $user->apellidos);                    
                    return $this->dispatcher->forward(array('controller' => 'index', 'action' => 'index'));
                }
            } else {
                $this->flash->error($t->_("fallo_validacion"));
            }
        }

        $this->view->user = $user;
        $this->view->form = $form;
//        $this->view->t = $this->getTranslation();

    }

    public function editaccAction()
    {
        $this->tag->prependTitle('Cambia Password');  
//        $t = $this->getTranslation();
        $user = Usuarios::findFirstById($this->session->userId);
        if (!$user) {
            $this->flash->error($t->_("usuario_no_encontrado"));
            return $this->dispatcher->forward(array('controller' => 'usuarios', 'action' => 'edita'));
        }

        if ($this->request->isPost()) {
            if ($user->password !== sha1($this->request->getPost('actpassword'))) {
                $this->flash->error($t->_("passwordact_match"));
                return;
            }

            if ($this->request->getPost('password') != $this->request->getPost('confirmPassword')){
                $this->flash->error($t->_("password_match"));
                return;
            }

            $user->assign(array('password' => sha1($this->request->getPost('password'))));

            if (!$user->update()) {                                                 // Graba nuevo password
                $this->flash->error($t->_("password_match"));
                return;
            }
            $this->flash->success($t->_("datos_actualizados"));
                return $this->dispatcher->forward(array('controller' => 'index', 'action' => 'inicio'));

        }        

        $this->view->user = $user;
//        $this->view->t = $this->getTranslation();

    }




    public function loginAction()
    {
        $this->tag->prependTitle('Login');
        $form = new FormLogin();
//        $t = $this->getTranslation();
        
        if ($this->request->isPost()) {
            if ($form->isValid($this->request->getPost()) != false) {   
            
                $email = $this->request->getPost('email', array('striptags', 'trim', 'email'));
                $password = $this->request->getPost('password', array('striptags', 'trim'));                
                $user = Usuarios::findFirstByEmail($email);
                if($user) {
                    if(sha1($password) === $user->password AND $user->activo === "1") {
                        //creamos la sesión del usuario con su email
                        $this->session->set("userId", $user->id);
                        $this->session->set("email", $user->email);
                        $this->session->set("username", $user->nombre . ' ' . $user->apellidos);
                        $this->session->set("premium", $user->premium);
                        $this->session->set("medico", $user->medico);
                        $this->session->set("loggedIn", true);
                        $this->session->set("app_path", APP_PATH);
                        $this->flashSession->success($t->_("bienvenido") . ' ' . $user->nombre . ' ' . $user->apellidos);
//                        return $this->dispatcher->forward(array('controller' => 'index', 'action' => 'inicio'));
                        return $this->response->redirect("index");
                    } else {
                        $this->flash->error($t->_("error_login"));
//                        return $this->dispatcher->forward(array('controller' => 'index', 'action' => 'index'));
                    }   
                } else {
                        $this->flash->error($t->_("usuario_no_encontrado"));
                }   
            }
        }


        $this->view->form = $form;
//        $this->view->t = $this->getTranslation();

    }


    public function logoutAction()
    {
        $this->session->destroy();
        return $this->response->redirect("index");
    }


    public function forgotAction()
    {
        $this->tag->prependTitle('Forgot Password');
//        $t = $this->getTranslation();
        
        if ($this->request->isPost()) {
            $email = $this->request->getPost('email', array('striptags', 'trim', 'email'));
            $user = Usuarios::findFirstByEmail($email);

            if($user) {
                $psswd = strtoupper(substr( md5(microtime()), 1, 10));                  // crea nueva contraseña
                $user->assign(array('password' => sha1($psswd)));

                if (!$user->update()) {                                                 // La graba como DATOS
                    foreach ($user->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                    return $this->dispatcher->forward(array(
                        'controller' => 'index',
                        'action' => 'index'
                    ));
                }
                                                                                        // envía contraseña al e-mail
                $this->mail->send($user->email,'New Password','changepass' . $this->session->get('lang'), array('newpass' => $psswd));
                $this->flash->success($t->_("email_forgot"));                           // Mensaje de nueva contraseña enviada
                return $this->dispatcher->forward(array('controller' => 'index', 'action' => 'index'));
                
            } else {
                        $this->flash->error($t->_("email_no_encontrado"));
            }   
        }
    }

}
