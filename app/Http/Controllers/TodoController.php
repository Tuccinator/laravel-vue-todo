<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;

class TodoController extends Controller
{
    /**
     * Get all todo items
     *
     * @return Todo
     */
    public function all()
    {
        return Todo::all()->toJson();
    }

    /**
     * Add a todo item to database
     *
     * @param Request $request
     * @return json
     */
    public function add(Request $request)
    {
        $text = $request->text;

        // Check length of todo
        if(strlen($text) === 0) {
            return json_encode(['success' => false, 'message' => 'You must provide a valid todo.']);
        }

        // Create a new todo item
        $todo = new Todo;
        $todo->text = $text;
        $todo->status = Todo::ACTIVE;
        
        if(!$todo->save()) {
            return json_encode(['success' => false, 'message' => 'Todo could not be added to database.']);
        }

        return json_encode(['success' => true, 'inserted_todo' => $todo->toJson()]);
    }

    /**
     * Remove todo item
     *
     * @param int $id
     * @return json
     */
    public function remove(int $id)
    {
        $todo = Todo::find($id);

        if(is_null($todo)) {
            return json_encode(['success' => false, 'message' => 'Todo item does not exist.']);
        }

        $todo->status = Todo::REMOVED;
        
        if(!$todo->save()) {
            return json_encode(['success' => false, 'message' => 'Todo could not be removed.']);            
        }

        return json_encode(['success' => true]);
    }
}