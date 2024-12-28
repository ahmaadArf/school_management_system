<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        // $type='web';
        // return view('auth.login',compact('type'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        if($request->type == 'student'){
            $guardName= 'student';
        }
        elseif ($request->type == 'parent'){
            $guardName= 'parent';
        }
        elseif ($request->type == 'teacher'){
            $guardName= 'teacher';
        }
        else{
            $guardName= 'web';
        }

        try {
            if(Auth::guard($guardName)->attempt(['email' => $request->email, 'password' => $request->password])){
                $request->session()->regenerate();

                if($request->type == 'student') {
                    return redirect()->route('student.dashboard.index');
                }
                elseif ($request->type == 'parent') {
                    return redirect()->route('parent.dashboard.index');
                }
                elseif ($request->type == 'teacher') {
                    return redirect()->route('teacher.dashboard.index');
                }
                else {
                    return redirect()->route('dashboard');
                }
            } else {
                return redirect()->back()->withErrors(['login' => 'Invalid credentials']);
            }
        } catch (\Exception $e) {
            // يمكنك طباعة أو تسجيل الخطأ لتصحيحه لاحقاً
            return redirect()->back()->withErrors(['error' => 'Something went wrong, please try again later.']);
        }
    }



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard($request->type)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
