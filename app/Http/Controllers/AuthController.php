<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Supplier;
use App\Models\DeliveryMan;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Detect user role based on email pattern
     */
    private function detectRoleFromEmail($email)
    {
        $patterns = [
            'admin' => '/admin@makkah-water\.com/i',
            'supplier' => '/supplier\d*@makkah-water\.com/i',
            'delivery' => '/delivery\d*@makkah-water\.com/i',
            'customer' => '/customer\d*@makkah-water\.com/i',
        ];

        foreach ($patterns as $role => $pattern) {
            if (preg_match($pattern, $email)) {
                return $role;
            }
        }

        return null;
    }

    /**
     * API endpoint for role detection
     */
    public function detectRole(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;
        $detectedRole = $this->detectRoleFromEmail($email);

        if ($detectedRole) {
            $roleInfo = [
                'admin' => [
                    'name' => 'مدير',
                    'icon' => 'fas fa-user-shield',
                    'color' => 'danger',
                    'description' => 'لوحة تحكم المدير'
                ],
                'supplier' => [
                    'name' => 'مورد',
                    'icon' => 'fas fa-store',
                    'color' => 'warning',
                    'description' => 'لوحة تحكم المورد'
                ],
                'delivery' => [
                    'name' => 'مندوب',
                    'icon' => 'fas fa-truck',
                    'color' => 'success',
                    'description' => 'لوحة تحكم المندوب'
                ],
                'customer' => [
                    'name' => 'عميل',
                    'icon' => 'fas fa-user',
                    'color' => 'info',
                    'description' => 'الصفحة الرئيسية'
                ]
            ];

            return response()->json([
                'success' => true,
                'role' => $detectedRole,
                'info' => $roleInfo[$detectedRole]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'لم يتم اكتشاف نوع الحساب'
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Detect role from email
        $detectedRole = $this->detectRoleFromEmail($request->email);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Check if user is active
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'حسابك معطل. يرجى التواصل مع الإدارة.',
                ])->onlyInput('email');
            }
            
            // Validate detected role if provided
            $requestedRole = $request->input('detected_role');
            if ($requestedRole && $requestedRole !== $user->role) {
                // Role mismatch - show warning but still allow login
                $request->session()->flash('role_mismatch', true);
            }
            
            // Redirect based on user role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->with('success', 'مرحباً بك في لوحة تحكم المدير');
                case 'supplier':
                    return redirect()->route('supplier.dashboard')->with('success', 'مرحباً بك في لوحة تحكم المورد');
                case 'delivery':
                    return redirect()->route('delivery.dashboard')->with('success', 'مرحباً بك في لوحة تحكم المندوب');
                case 'customer':
                    return redirect()->route('customer.dashboard')->with('success', 'مرحباً بك في لوحة تحكم العميل');
                default:
                    return redirect()->intended('/')->with('success', 'تم تسجيل الدخول بنجاح');
            }
        }

        // If login fails, provide more specific error messages
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors([
                'email' => 'البريد الإلكتروني غير مسجل في النظام.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'password' => 'كلمة المرور غير صحيحة.',
        ])->onlyInput('email');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'city' => ['required', 'string'],
            'role' => ['required', 'in:customer,supplier,delivery'],
            'address' => ['nullable', 'string'],
            'terms' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'city' => $request->city,
            'address' => $request->address,
            'is_active' => true,
        ]);

        // Create additional records based on role
        if ($request->role === 'supplier') {
            Supplier::create([
                'user_id' => $user->id,
                'company_name' => $request->name,
                'contact_person' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'status' => 'pending',
                'rating' => 0,
                'total_orders' => 0,
            ]);
        } elseif ($request->role === 'delivery') {
            DeliveryMan::create([
                'user_id' => $user->id,
                'national_id' => '',
                'vehicle_type' => '',
                'vehicle_number' => '',
                'license_number' => '',
                'emergency_contact' => '',
                'emergency_phone' => '',
                'address' => $request->address,
                'city' => $request->city,
                'status' => 'pending',
                'rating' => 0,
                'total_deliveries' => 0,
                'total_earnings' => 0,
            ]);
        }

        Auth::login($user);

        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'profile_image.image' => 'يجب أن يكون الملف صورة صحيحة.',
            'profile_image.mimes' => 'يجب أن تكون الصورة من نوع: jpeg, png, jpg, gif.',
            'profile_image.max' => 'حجم الصورة يجب أن يكون أقل من 2 ميجابايت.',
            'current_password.required_with' => 'كلمة المرور الحالية مطلوبة عند تغيير كلمة المرور.',
            'new_password.min' => 'كلمة المرور الجديدة يجب أن تكون 8 أحرف على الأقل.',
            'new_password.confirmed' => 'تأكيد كلمة المرور الجديدة غير متطابق.',
        ]);

        try {
            // Update basic information
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'city' => $request->city,
                'address' => $request->address,
            ];

            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                // Delete old image if exists
                if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                    Storage::disk('public')->delete($user->profile_image);
                }
                
                // Store new image
                $imagePath = $request->file('profile_image')->store('profile-images', 'public');
                $updateData['profile_image'] = $imagePath;
            }

            // Handle password change
            if ($request->filled('current_password') && $request->filled('new_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة.']);
                }
                
                $updateData['password'] = Hash::make($request->new_password);
            }

            // Update user data
            User::where('id', $user->id)->update($updateData);

            return back()->with('success', 'تم تحديث الملف الشخصي بنجاح.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'حدث خطأ أثناء تحديث الملف الشخصي. يرجى المحاولة مرة أخرى.']);
        }
    }
} 