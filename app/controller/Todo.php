<?php namespace controller;

use core\base\Controller;
use core\base\View;
use core\utils\Request;

class Todo extends Controller
{
    function __construct()
    {
        parent::__construct('Todo'); // Model
    }

    public function index()
    {
        View::load('todo/index');
    }
    
    public function getAll()
    {
        echo json_encode($this->model()->all());
    }

    public function create()
    {
        $data = Request::all();
        
        if ($this->model()->insert($data)) {
            echo "Todo was created.";
        } else {
            echo "An error occurred while saving.";
        }
    }
    
    public function edit($id)
    {
        $todo = $this->model()->find($id);
        echo json_encode($todo);
    }
    
    public function update()
    {
        $id = Request::get('id');
        $data = Request::all();
        
        if ($this->model()->update($id, $data)) {
            echo "Todo was updated.";
        } else {
            echo "An error occurred while updating.";
        }
    }
    
    public function remove()
    {
        $id = Request::get('id');
        
        if ($this->model()->delete($id)) {
            echo "Todo was deleted.";
        } else {
            echo "An error occurred while deleting.";
        }
    }
}
