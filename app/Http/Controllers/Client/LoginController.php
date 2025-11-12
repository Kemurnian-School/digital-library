<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Illuminate\Http\Request;

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
        ]);

        // Find student with matching NIS and level
        $student = Students::where('nis', $credentials['nis'])
            ->where('level', $credentials['level'])
            ->first();

        if ($student) {
            // Store student info in session
            $request->session()->regenerate();
            $request->session()->put('student_id', $student->id);
            $request->session()->put('student_nis', $student->nis);
            $request->session()->put('student_level', $student->level);

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'nis' => 'The provided NIS and level do not match our records.',
        ])->onlyInput('nis', 'level');
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
