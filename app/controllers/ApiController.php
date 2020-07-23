<?php
declare(strict_types=1);

class ApiController extends ControllerBase
{

    public function indexAction()
    {
    	$this->view->episodes = Episodes::find();
    	
    }
    

}

