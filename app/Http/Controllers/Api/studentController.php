<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class studentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        $data = [
            'students' => $students,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'lenguage' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error de validacion de datos',
                'error' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'lenguage' => $request->lenguage,
        ]);

        if (!$student) {
            $data = [
                'message' => 'error al crear el estudiante',
                'estatus' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'student' => $student,
            'status' => 201
        ];
        return response()->json($data, 201);
    }

    public function show($id)
    {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 400);
        }

        $data = [
            'student' => $student,
            'status' => 200
        ];
        return response()->json($data, 400);
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $student->delete();

        $data = [
            'message' => 'Estudiante eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }


    public function update(Request $request, $id)

    {
        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10',
            'lenguage' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->lenguage = $request->lenguage;

        $student->save();

        $data = [
            'message' => 'Estudiante actualizado',
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);
    }



    public function updatePartial(Request $request, $id)

    {
        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }






        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'email|unique:student',
            'phone' => 'digits:10',
            'lenguage' => ''
        ]);


        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }


        if ($request->has('name')) {
            $student->name = $request->name;
        }
        if ($request->has('email')) {
            $student->email = $request->email;
        }
        if ($request->has('phone')) {
            $student->phone = $request->phone;
        }
        if ($request->has('lenguage')) {
            $student->lenguage = $request->lenguage;
        }

        $student->save();

        $data = [
            'message' => 'Estudiante actualizado',
            'student' => $student,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
