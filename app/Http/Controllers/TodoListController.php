<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use App\Http\Requests\StoreTodoListRequest;
use App\Http\Requests\UpdateTodoListRequest;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

class TodoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $limit = $req->input('per_page') ?? 10;

        return TodoList::select(['id', 'name', 'user_id'])->orderBy('id', 'desc')->paginate($limit);
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
     * @param  \App\Http\Requests\StoreTodoListRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $list = new TodoList();
        $list->name = $request->name;
        $list->user_id = 1;
        $res = $list->save();

        return $this->getResult($list, $res, 'list created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TodoList  $list
     * @return \Illuminate\Http\Response
     */
    public function show(TodoList $list)
    {
        return $this->getResult($list, 1, '');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TodoList  $list
     * @return \Illuminate\Http\Response
     */
    public function edit(TodoList $list)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTodoListRequest  $request
     * @param  \App\Models\TodoList  $list
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TodoList $list)
    {
        $list->name = $request->name;
        $res = $list->save();
        return $this->getResult($list, $res, 'list up date');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TodoList  $list
     * @return \Illuminate\Http\Response
     */
    public function destroy(TodoList $list, Request $req)
    {
        if ($req->forceDelete) {
            return $this->forceDestroy($list);
        }
        $res = $list->delete();
        return $this->getResult($list, $res, 'list logicaly deleted');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TodoList  $list
     * @return \Illuminate\Http\Response
     */
    private function forceDestroy(TodoList $list)
    {
        $res = $list->forceDelete();
        return $this->getResult($list, $res, 'list deleted');
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
