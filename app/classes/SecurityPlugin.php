<?php

namespace Aiden\Classes;

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;

class SecurityPlugin extends Plugin {

    /**
     * Returns an existing or new access control list
     *
     * @returns AclList
     */
    public function getAcl() {

        if (!isset($this->persistent->acl)) {

            $acl = new AclList();

            $acl->setDefaultAction(Acl::DENY);

            // Register roles
            $roles = [
                'administrators' => new Role('Administrators'),
                'users' => new Role('Users'),
                'guests' => new Role('Guests')
            ];

            foreach ($roles as $role) {
                $acl->addRole($role);
            }

            // Resources that logged in users can visit
            $adminResources = [
                'Aiden\Controllers:index' => ['index'],
                'Aiden\Controllers:admin' => ['index'],
                'Aiden\Controllers:dashboard' => ['index'],
                'Aiden\Controllers:login' => ['destroy'],
                'Aiden\Controllers:phrases' => ['index', 'create', 'delete', 'toggleCase'],
                'Aiden\Controllers:sources' => ['index', 'create', 'delete', 'scrape'],
                'Aiden\Controllers:urls' => ['index', 'create', 'delete', 'scrape', 'toggleAdjacent'],
                'Aiden\Controllers:pdfs' => ['index', 'delete', 'view'],
                'Aiden\Controllers:scrape' => ['index', 'scrapeUrlById'],
                'Aiden\Controllers:management' => ['index'],
            ];
            foreach ($adminResources as $resource => $actions) {
                $acl->addResource(new Resource($resource), $actions);
            }

            // Resources for registered users that have no privileges.
            $userResources = [
            ];
            foreach ($userResources as $resource => $actions) {
                $acl->addResource(new Resource($resource), $actions);
            }

            // Resources that non-logged in users can visit
            $guestResources = [
                'Aiden\Controllers:index' => ['index'],
                'Aiden\Controllers:login' => ['index', 'do', 'destroy'],
                'Aiden\Controllers:register' => ['index', 'do']
            ];
            foreach ($guestResources as $resource => $actions) {
                $acl->addResource(new Resource($resource), $actions);
            }

            $allAccessResources = [
                'Aiden\Controllers:errors' => ['*'],
                'Aiden\Controllers:cron' => ['*'],
            ];
            foreach ($allAccessResources as $resource => $actions) {
                $acl->addResource(new Resource($resource), $actions);
            }

            // Grant all roles access to All Access Resources
            foreach ($roles as $role) {
                foreach ($allAccessResources as $resource => $actions) {
                    $acl->allow($role->getName(), $resource, $actions);
                }
            }

            // Grant Guests access to Guest resources
            foreach ($guestResources as $resource => $actions) {
                foreach ($actions as $action) {
                    $acl->allow('Guests', $resource, $action);
                }
            }

            // Grant Administrators access to Administrator resources
            foreach ($adminResources as $resource => $actions) {
                foreach ($actions as $action) {
                    $acl->allow('Administrators', $resource, $action);
                }
            }

            // Grant Users access to User resources
            foreach ($userResources as $resource => $actions) {
                foreach ($actions as $action) {
                    $acl->allow('Users', $resource, $action);
                }
            }

            //The acl is stored in session, APC would be useful here too
            $this->persistent->acl = $acl;
        }

        return $this->persistent->acl;

    }

    public function beforeDispatch(Event $event, Dispatcher $dispatcher) {

        // Check if user is authenticated
        $auth = $this->session->get('auth');

        if ($auth !== null) {
            switch ($auth['user']->level) {
                case \Aiden\Models\Users::LEVEL_ADMINISTRATOR:
                    $role = 'Administrators';
                    break;
                case \Aiden\Models\Users::LEVEL_USER:
                    $role = 'Users';
                    break;
                default:
                    $role = 'Guests';
                    break;
            }
        }
        else {
            $role = "Guests";
        }

        $namespace = $dispatcher->getNamespaceName();
        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        $acl = $this->getAcl();

        // If resource doesn't exist
        if (!$acl->isResource($namespace . ':' . $controller)) {

            $dispatcher->forward([
                'namespace' => 'Aiden\Controllers',
                'controller' => 'errors',
                'action' => 'show404'
            ]);
            return false;
        }

        // If resource is protected and user hasn't got enough permissions
        if (!$acl->isAllowed($role, $namespace . ':' . $controller, $action)) {

            // If user isn't logged in, redirect to login page.
            if ($role === 'Guests') {
                return $this->response->redirect('login', false, 302);
            }
            else {

                $dispatcher->forward([
                    'namespace' => 'Aiden\Controllers',
                    'controller' => 'errors',
                    'action' => 'show401'
                ]);
                return false;
            }
        }

    }

}