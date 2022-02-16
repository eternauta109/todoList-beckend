<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Carbon;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $limit = $req->input('per_page') ?? 10;
        $list_id = $req->list_id ??  1;
        return Todo::select(['id', 'name', 'list_id', 'completed'])
            ->where('list_id', $list_id)
            ->orderBy('id', 'DESC')
            ->paginate($limit);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTodoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $todo = new Todo();
        $todo->name = $request->name;
        $todo->list_id = $request->list_id;
        $todo->duedate = $request->duedate ?? Carbon::now();

        $res = $todo->save();

        return $this->getResult($todo, $res, 'todo created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        return $this->getResult($todo, 1, 'todo read');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTodoRequest  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        $todo->name = $request->name ?? $todo->name;
        $date = $request->duedate ?? $todo->duedate;

        $todo->duedate = $date ?? Carbon::now();
        $list = $request->list_id ?? $todo->list_id;
        $todo->list_id = $list;
        $todo->completed = $request->completed ?? $todo->completed;;
        $res = $todo->save();
        return $this->getResult($todo, $res, "todo update");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo, Request $req)
    {
        if ($req->forceDelete) {
            return $this->forceDestroy($todo);
        };
        $res = $todo->delete();
        return $this->getResult($todo, $res, "todo logicaly delete");
    }

    private function forceDestroy(Todo $todo)
    {
        $res = $todo->forceDelete();
        return $this->getResult($todo, $res, 'todo complete deleted');
    }

    private function getResult(Jsonable $data, $success = true, $message = "")
    {
        return [
            'data' => $data,
            'success' => $success,
            'message' => $message
        ];
    }
}
