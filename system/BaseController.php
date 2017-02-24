<?php

class BaseController {

    public function __construct(){
        session_start();
        $this->load = new Load;
        $this->model = new BaseModel;
        $this->view = new View;
        $this->library = new Library;
    }


}
