<?php

namespace App\Http\Controllers;

use App\Enums\StudentStatusEnum;
use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    private string $title = 'Something was wrong :))';

    private $model;
    public function __construct()
    {
        $this->model = (new Student())->query();
        $routeName = Route::currentRouteName();
        $arr = explode('.', $routeName);
        $arr = array_map('ucfirst', $arr);
        $name = implode('/', $arr);
        $arrStudentStatus =  StudentStatusEnum::getArrayView();
        View::share('title', $this->title);
        View::share('name', $name);
        View::share('arrStudentStatus', $arrStudentStatus);
    }

    public function index()
    {
        return view('student.index');
    }

    public function api(Request $request)
    {
        // $query = $this->model->select('students.*')
        //     ->addSelect('courses.name as course_name')
        //     ->join('courses', 'courses.id', 'students.course_id');
        // return DataTables::of($query)
        return DataTables::of($this->model->with('course'))
            ->addColumn('age', function ($object) {
                return $object->age;
            })
            ->editColumn('gender', function ($object) {
                return $object->gender_name;
            })
            ->editColumn('status', function ($object) {
                return StudentStatusEnum::getKeyByValue($object->status);
            })
            ->addColumn('edit', function ($object) {
                // $link = route('courses.edit', $object);

                // return "<a class='btn btn-info' href='$link'>Edit</a>";
                return route('students.edit', $object);
            })
            ->addColumn('course_name', function ($object) {
                return $object->course->name;
            })
            ->addColumn('destroy', function ($object) {
                return route('students.destroy', $object);
            })
            ->filterColumn('course_name', function ($query, $keyword) {
                $query->whereHas('course', function ($q) use ($keyword) {
                    return $q->where('id', $keyword);
                }
                );
            })
            ->filterColumn('status', function ($query, $keyword) {
                if($keyword !=='0')
                $query->where('status', $keyword);
            })
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::get();
        return view('student.create',[
            'courses' => $courses,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentRequest $request)
    {
        $this->model->create($request->validated());
        return redirect()->route('students.index')->with('success', 'Đã thêm thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStudentRequest  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
