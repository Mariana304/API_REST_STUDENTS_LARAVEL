<?php

namespace App\Services;

use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\Validator;

class StudentService
{
    protected $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function getAllStudents()
    {
        return $this->studentRepository->all();
    }

    public function getStudentById($id)
    {
        return $this->studentRepository->find($id);
    }

    public function createStudent(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'lenguage' => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'message' => 'Error de validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
        }

        $student = $this->studentRepository->create($data);

        if (!$student) {
            return [
                'message' => 'Error al crear el estudiante',
                'status' => 500
            ];
        }

        return [
            'student' => $student,
            'status' => 201
        ];
    }

    public function updateStudent($id, array $data)
    {
        $student = $this->studentRepository->find($id);

        if (!$student) {
            return [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
        }

        // Validaciones y actualizaciones
        $student->fill($data);
        $student->save();

        return [
            'message' => 'Estudiante actualizado',
            'student' => $student,
            'status' => 200
        ];
    }


    public function deleteStudent($id)
    {
        $student = $this->studentRepository->find($id);

        if (!$student) {
            return [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
        }

        $this->studentRepository->delete($student);

        return [
            'message' => 'Estudiante eliminado',
            'status' => 200
        ];
    }
}
