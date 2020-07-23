<?php
declare(strict_types=1);

 

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class EpisodesController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        //
    }

    /**
     * Searches for episodes
     */
    public function searchAction()
    {
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, 'Episodes', $_GET)->getParams();
        $parameters['order'] = "id";

        $paginator   = new Model(
            [
                'model'      => 'Episodes',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any episodes");

            $this->dispatcher->forward([
                "controller" => "episodes",
                "action" => "index"
            ]);

            return;
        }

        $this->view->page = $paginate;
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        //
    }

    /**
     * Edits a episode
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {
            $episode = Episodes::findFirstByid($id);
            if (!$episode) {
                $this->flash->error("episode was not found");

                $this->dispatcher->forward([
                    'controller' => "episodes",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $episode->id;

            $this->tag->setDefault("id", $episode->id);
            $this->tag->setDefault("air_date", $episode->air_date);
            $this->tag->setDefault("episode", $episode->episode);
            $this->tag->setDefault("name", $episode->name);
            $this->tag->setDefault("characters", $episode->characters);
            $this->tag->setDefault("url", $episode->url);
            
        }
    }

    /**
     * Creates a new episode
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "episodes",
                'action' => 'index'
            ]);

            return;
        }

        $episode = new Episodes();
        $episode->airDate = $this->request->getPost("air_date", "int");
        $episode->episode = $this->request->getPost("episode", "int");
        $episode->name = $this->request->getPost("name", "int");
        $episode->characters = $this->request->getPost("characters", "int");
        $episode->url = $this->request->getPost("url", "int");
        

        if (!$episode->save()) {
            foreach ($episode->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "episodes",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("episode was created successfully");

        $this->dispatcher->forward([
            'controller' => "episodes",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a episode edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "episodes",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $episode = Episodes::findFirstByid($id);

        if (!$episode) {
            $this->flash->error("episode does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "episodes",
                'action' => 'index'
            ]);

            return;
        }

        $episode->airDate = $this->request->getPost("air_date", "int");
        $episode->episode = $this->request->getPost("episode", "int");
        $episode->name = $this->request->getPost("name", "int");
        $episode->characters = $this->request->getPost("characters", "int");
        $episode->url = $this->request->getPost("url", "int");
        

        if (!$episode->save()) {

            foreach ($episode->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "episodes",
                'action' => 'edit',
                'params' => [$episode->id]
            ]);

            return;
        }

        $this->flash->success("episode was updated successfully");

        $this->dispatcher->forward([
            'controller' => "episodes",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a episode
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $episode = Episodes::findFirstByid($id);
        if (!$episode) {
            $this->flash->error("episode was not found");

            $this->dispatcher->forward([
                'controller' => "episodes",
                'action' => 'index'
            ]);

            return;
        }

        if (!$episode->delete()) {

            foreach ($episode->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "episodes",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("episode was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "episodes",
            'action' => "index"
        ]);
    }
}
