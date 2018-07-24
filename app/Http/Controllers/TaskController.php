<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Task;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $tasks;

    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository  $tasks
     * @return void
     */
    public function __construct(TaskRepository $tasks)
    {
       // $this->middleware('auth');

        $this->tasks = $tasks;
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
		
		//echo $uri = $request->path();
		//echo $url = $request->fullUrl();
		//echo $url = $request->fullUrlWithQuery(['bar' => 'baz']);
		//echo $method = $request->method();
		//echo $request->user();
		//$input = $request->all();
		//$input = $request->only(['name', 'password']);	//=> error  //print('<pre>');	print_r($input);
		//exit;
		
        return view('tasks.index', [
            'tasks' => $this->tasks->forUser($request->user()),
        ]);

		/*
		$tasks = $request->user()->tasks()->get();

		return view('tasks.index', [
			'tasks' => $tasks,
		]);
		*/
		
    }

    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
     /*   $this->validate($request, [
            'name' => 'required|max:50|min:5',
        ]);
	*/

	/*
		$rules = [
            'name' => 'required|max:50|min:10'
			];
		
		$this->validate($request, $rules);
	*/

		$rules = [
            'name' => 'required|max:50|min:10'
			];

		$customMessages = [
			'name.required' => 'The :attribute field can not be blank.',
			'name.min' => 'Minimum 10 must be require!',
			'name.max' => 'Maximum 50'
		];

		$this->validate($request, $rules, $customMessages);
		 
        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect('/tasks');
    }

    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {
//        $this->authorize('destroy', $task);
        $task->delete();
        return redirect('/tasks');
    }
	
	
}
