<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StudentService;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Repositories\StudentRepository;

class studentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function index()
    {
        $students = $this->studentService->getAllStudents();

        return response()->json([
            'students' => $students,
            'status' => 200
        ], 200);
    }

    public function store(Request $request)
    {
        $response = $this->studentService->createStudent($request->all());

        return response()->json([
            'message' => $response['message'] ?? 'Estudiante creado exitosamente',
            'student' => $response['student'] ?? null,
            'errors' => $response['errors'] ?? null
        ], $response['status']);
    }

    public function show($id)
    {
        $student = $this->studentService->getStudentById($id);

        if (!$student) {
            return response()->json([
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'student' => $student,
            'status' => 200
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $response = $this->studentService->updateStudent($id, $request->all());

        return response()->json([
            'message' => $response['message'] ?? 'Estudiante actualizado',
            'student' => $response['student'] ?? null,
            'errors' => $response['errors'] ?? null
        ], $response['status']);
    }

    public function destroy($id)
    {
        $response = $this->studentService->deleteStudent($id);

        return response()->json([
            'message' => $response['message'],
        ], $response['status']);
    }
}
