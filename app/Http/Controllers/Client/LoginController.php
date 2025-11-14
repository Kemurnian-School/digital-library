<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle student login attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nis' => 'required|string',
            'level' => 'required|in:sd,smp,sma',
            'password' => 'nullable|string'
        ]);

        /*
         * Find student with matching NIS and level
         */
        $student = Students::where('nis', $credentials['nis'])
            ->where('level', $credentials['level'])
            ->first();

        /*
         * Check if student exist
         */
        if (!$student) {
            return back()->withErrors([
                'nis' => 'The provided NIS and level do not match our records.',
            ])->onlyInput('nis', 'level');
        }

        /*
         * Condition if password is null
         */
        if ($student->password === null) {
            // Store student info in session
            $request->session()->regenerate();
            $request->session()->put('student_id', $student->id);
            $request->session()->put('student_nis', $student->nis);
            $request->session()->put('student_level', $student->level);
            $request->session()->put('needs_password_setup', true);

            return redirect()->intended(route('home'));
        } else {
            /*
             * Condition if password is not null
             */
            $inputPassword = $request->input('password');

            if (empty($inputPassword)) {
                return back()->withErrors([
                    'password' => 'Password required for this account',
                ])->onlyInput('nis', 'level');
            }

            if (Hash::check($inputPassword, $student->password)) {
                $request->session()->regenerate();
                $request->session()->put('student_id', $student->id);
                $request->session()->put('student_nis', $student->nis);
                $request->session()->put('student_level', $student->level);
                $request->session()->put('needs_password_setup', false);

                return redirect()->intended(route('home'));
            } else {
                return back()->withErrors([
                    'password' => 'The provided password is incorrect.',
                ])->onlyInput('nis', 'level');
            }
        }
    }

    /**
     * Log the student out.
     */
    public function logout(Request $request)
    {
        $request->session()->forget(['student_id', 'student_nis', 'student_level']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
