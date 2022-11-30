<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\DestroyRequest;
use App\Http\Requests\Course\StoreRequest;
use App\Http\Requests\Course\UpdateRequest;
use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;

class CourseController extends Controller
{

    // public function index(Request $request)
    // {
    //     $search = $request->get('q');
    //     $data = Course::where('name', 'like', '%' . $search . '%')->paginate(2);
    //     $data->appends(['q' => $search]);
    //     return view('course.index', [
    //         'data' => $data,
    //         'search' => $search,
    //     ]);
    // }

    private string $title = 'Something was wrong :))';
    private $model;
    public function __construct()
    {
        $this->model = (new Course())->query();
        $routeName = Route::currentRouteName();
        $arr = explode('.', $routeName);
        $arr = array_map('ucfirst', $arr);
        $name = implode('/', $arr);
        View::share('title', $this->title);
        View::share('name', $name);
    }
    public function index()
    {
        return view('course.index');
    }

    // public function api(Request $request)
    // {
    //     $data = $this->model->paginate(2,['*'], 'page', $request->get('draw'));
    //     $arr = [];
    //     $arr['draw'] = $data->currentPage();
    //     $arr['data'] = [];
    //     foreach ($data->items() as $item) {
    //         $item->setAppends([
    //             'year_created_at'
    //         ]);
    //         $item->edit = route('courses.edit', $item);
    //         $item->destroy = route('courses.destroy', $item);
    //         $arr['data'][] = $item;
    //     }
    //     $arr['recordsTotal'] = $data->total();
    //     $arr['recordsFiltered'] = $data->total();
    //     return $arr;
    // }
    public function api()
    {

        return DataTables::of($this->model)
            ->editColumn('created_at', function ($object) {
                return $object->year_created_at;
            })
            ->addColumn('edit', function ($object) {
                // $link = route('courses.edit', $object);

                // return "<a class='btn btn-info' href='$link'>Edit</a>";
                return route('courses.edit', $object);
            })
            ->addColumn('destroy', function ($object) {
                return route('courses.destroy', $object);
            })
            ->make(true);
    }
    public function apiName(Request $request)
    {
        return $this->model
            ->where('name', 'like', '%'.$request->get('q').'%')
            ->get([
                'id',
                'name',
            ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('course.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCourseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        // $object = new Course();
        // $object->fill($request->except('_token'));
        // $object->save();

        $this->model->create($request->except('_token'));
        // Course::created($request->validated());
        return redirect()->route('courses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    public function edit(Course $course)
    {
        // $object = Course::where('id', $course)->first();
        // $object  = Course::find($course);
        return view('course.edit', [
            'each' => $course,
        ]);
    }


    public function update(UpdateRequest $request, $courseId)
    {
        // $this->model->where('id', $courseId)->update(
        //     $request->validated();
        // );
        // $object = $this->model->find($courseId);
        $this->model->update(
            $request->validated()
        );
        return redirect()->route('courses.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyRequest $request, $courseId)
    {
        // $this->model->destroy($courseId);
        $this->model->where('id', $courseId)->delete();
        // $this->model->find($courseId)->delete();
        // return redirect()->route('course.index');
        $arr = [];
        $arr['status'] = true;
        $arr['message'] = '';
        return response($arr, 200);

    }
}
