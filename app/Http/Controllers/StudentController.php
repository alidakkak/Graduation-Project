<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompleteRegistration;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function studentRegistration(StoreStudentRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);

            $student = Student::create($data);

            $student->deviceTokens()->create([
                'device_token' => $data['deviceToken'],
            ]);

            DB::commit();

            return response()->json([
                'message' => 'عليك الانتظار حتى يتم تأكيد حسابك',
                'student' => StudentResource::make($student),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'حدث خطأ أثناء التسجيل',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getStudentNotRegistrationComplete()
    {
        $students = Student::where('is_registration_complete', 0)->get();

        return StudentResource::collection($students);
    }

    public function checkStudentData($studentID)
    {
        $student = Student::where('id', $studentID)->first();

        if (! $student) {
            return response()->json([
                'message' => 'لم يتم العثور على الطالب',
            ], 403);
        }

        $student->update([
            'is_registration_complete' => 1,
        ]);

        return response()->json([
            'message' => 'تم تحديث البيانات بنجاح',
            'student' => StudentResource::make($student),
        ], 200);
    }

    public function completeRegistration(StoreCompleteRegistration $request) {}

    public function login(Request $request)
    {
        $request->validate([
            'university_number' => 'required|numeric',
            'password' => 'required|string',
            'device_token' => 'required|string'
        ]);

        $credentials = $request->only('university_number', 'password');

        $token = Auth::guard('api_student')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $student = Student::where('university_number', $request->university_number)
            ->where('is_registration_complete', 0)
            ->first();
        if ($student) {
            return response()->json(['message' => 'يجب عليك الانتظار حتى يتم تفعيل حسابك']);
        }

        $user = Auth::guard('api_student')->user();
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);

    }
}
