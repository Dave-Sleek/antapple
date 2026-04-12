<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\JobController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\Admin\AdminJobController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\JobAlertController;
use App\Http\Controllers\Admin\AdminJobAlertController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\JobReportController;
use App\Http\Controllers\JobApplyController;
use App\Http\Controllers\Admin\AdminReportsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminPlanController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\EmployerApplicantController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployerBillingController;
use App\Http\Controllers\PaymentMethodController;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\Admin\UserLogController;
use App\Http\Controllers\Admin\SystemStatusController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\Admin\OpportunityController as AdminOpportunityController;


Route::get('/', [JobController::class, 'index']);

// Route::get('/login', function () {
//     return redirect()->route('admin.login');
// })->name('login');


/*
|--------------------------------------------------------------------------
| Forgot Password
|--------------------------------------------------------------------------
*/

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

// Google CallBack
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])
    ->name('google.redirect');

Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])
    ->name('google.callback');

Route::post('/forgot-password', function (Request $request) {

    $request->validate([
        'email' => 'required|email'
    ]);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with('success', 'Reset link sent to your email.')
        : back()->withErrors(['email' => 'Unable to send reset link']);
})->name('password.email');


Route::get('/reset-password/{token}', function ($token) {

    return view('auth.reset-password', [
        'token' => $token
    ]);
})->name('password.reset');


Route::post('/reset-password', function (Request $request) {

    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);

    $status = Password::reset(

        $request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        ),

        function ($user, $password) {

            $user->password = Hash::make($password);
            $user->two_factor_code = rand(100000, 999999);
            $user->two_factor_expires_at = now()->addMinutes(10);
            $user->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('success', 'Password reset successful')
        : back()->withErrors(['email' => 'Invalid reset token']);
})->name('password.update');

Route::get('/opportunities', [OpportunityController::class, 'index'])
    ->name('opportunities.index');

Route::get('/opportunities/{uuid}/{slug}', [OpportunityController::class, 'show'])
    ->name('opportunities.show');

/*
|--------------------------------------------------------------------------
| Email Verification
|--------------------------------------------------------------------------
*/

Route::get('/email/verify', function () {

    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {

    $request->fulfill();

    return redirect()->route('employer.dashboard')
        ->with('success', 'Email verified successfully.');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {

    $request->user()->sendEmailVerificationNotification();

    return back()->with('success', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');


Route::get('/jobs/{job}/external-apply', [JobController::class, 'redirect'])
    ->name('jobs.external.apply');

Route::get('/jobs/{job}/form-apply', [ApplicantController::class, 'create'])
    ->name('jobs.form.apply');

Route::post('/jobs/{job}/apply', [ApplicantController::class, 'store'])
    ->name('jobs.apply.store');

Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');

Route::get('/jobs/category/{slug}', [JobController::class, 'category'])->name('jobs.index');

// Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');
// Route::get('/jobs/{job:uuid}', [JobController::class, 'show'])->name('jobs.show');

Route::get('/jobs/{job}/{slug}', [JobController::class, 'show'])->name('jobs.show');

// Public route for company profile
// Route::get('/companies/{user}', [CompanyController::class, 'show'])
//     ->name('companies.show');

// Public route to view all companies
Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');

// Public route for a single company profile (we already added this)
Route::get('/companies/{user}', [CompanyController::class, 'show'])->name('companies.show');


Route::view('/offline', 'offline')->name('offline');



Route::middleware(['auth', 'employer', 'subscribed', 'verified'])->group(function () {

    Route::get('/post-job', [EmployerController::class, 'dashboard'])
        ->name('jobs.create');

    Route::get('/employer/jobs/export', [EmployerController::class, 'exportJobs'])->name('employer.jobs.export');

    Route::get('/jobs/{job}/applicants', [EmployerController::class, 'applicants'])->name('applicants');

    Route::get('/applicants', [EmployerApplicantController::class, 'index'])
        ->name('employer.applicants');

    Route::get('/applicants/{id}', [EmployerApplicantController::class, 'show'])
        ->name('employer.applicants.show');


    Route::get('/employer/profile', [EmployerController::class, 'profile'])
        ->name('employer.profile');

    Route::post('/employer/profile', [EmployerController::class, 'updateProfile'])
        ->name('employer.profile.update');

    Route::get('/company/{user}', [EmployerController::class, 'companyPage'])
        ->name('employer.company.page');

    Route::get('/dashboard', [EmployerController::class, 'dashboard'])->name('employer.dashboard');

    Route::get('/jobs/create', [EmployerController::class, 'create'])->name('employer.create');

    Route::post('/jobs', [EmployerController::class, 'store'])->name('employer.store');

    Route::get('/jobs/{job}/edit', [EmployerController::class, 'edit'])->name('employer.edit');

    Route::put('/jobs/{job}', [EmployerController::class, 'update'])->name('update');

    Route::delete('/jobs/{job}', [EmployerController::class, 'destroy'])->name('employer.destroy');

    Route::post('/payment-method/save', [EmployerBillingController::class, 'savePaymentMethod'])
        ->name('payment.save');

    Route::get('/employer/billing', [EmployerBillingController::class, 'index'])
        ->name('billing');

    Route::get('/employer/invoice/{payment}', [EmployerBillingController::class, 'downloadInvoice'])
        ->name('invoice.download');

    Route::post('/employer/subscription/cancel', [EmployerBillingController::class, 'cancelSubscription'])
        ->name('subscription.cancel');


    Route::get('/payment-methods', [PaymentMethodController::class, 'index'])
        ->name('payment.methods');

    Route::post('/payment-method/{method}/default', [PaymentMethodController::class, 'setDefault'])
        ->name('payment.methods.default');

    Route::delete('/payment-method/{method}', [PaymentMethodController::class, 'destroy'])
        ->name('payment.methods.delete');

    Route::get('/jobs/trash', [EmployerController::class, 'trash'])->name('employer.jobs.trash');

    Route::post('/jobs/{id}/restore', [EmployerController::class, 'restore'])->name('employer.jobs.restore');
    Route::delete('/jobs/{id}/force-delete', [EmployerController::class, 'forceDelete'])->name('employer.jobs.forceDelete');


    Route::post('/employer/jobs/{job}/feature', [EmployerController::class, 'feature'])->name('employer.feature');
    Route::post('/employer/jobs/{job}/unfeature', [EmployerController::class, 'unfeature'])->name('employer.unfeature');
});

Route::get('/pricing', [SubscriptionController::class, 'pricing'])->name('pricing');

Route::middleware(['auth'])->group(function () {
    Route::get('/employer/subscription', [SubscriptionController::class, 'index'])
        ->name('employer.subscription');
});

Route::post('/subscribe/{plan}', [SubscriptionController::class, 'subscribe'])->name('subscribe');
Route::get('/subscription/callback', [SubscriptionController::class, 'callback'])
    ->name('subscription.callback');
Route::post('/subscription/renew', [SubscriptionController::class, 'renew'])->name('subscription.renew');

Route::post('/webhook/paystack', [WebhookController::class, 'handlePaystack']);
Route::post('/paystack/webhook', [SubscriptionController::class, 'webhook']);

// If using token
Route::get('alerts/unsubscribe/{token}', [JobAlertController::class, 'unsubscribe'])
    ->name('alerts.unsubscribe');

// If using id
Route::get('alerts/unsubscribe/{id}', [JobAlertController::class, 'unsubscribeById'])
    ->name('alerts.unsubscribe');

Route::post('/alerts/subscribe', [JobAlertController::class, 'subscribe'])
    ->name('alerts.subscribe');


// Route::get('/post-job', [EmployerController::class, 'create'])
//     ->name('jobs.create');

// Route::post('/post-job', [EmployerController::class, 'store'])
//     ->name('jobs.store');

Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/cookies', [PageController::class, 'cookies'])->name('cookies');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/why', [PageController::class, 'why'])->name('why');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');

Route::get('/jobs/{job}/apply', JobApplyController::class)->name('jobs.apply');


// Route::get('/test-telegram', function () {
//     return \App\Services\TelegramService::send('Test message from Laravel');
// });

Route::get('/jobs/{job}/pay', [PaymentController::class, 'initialize'])->name('jobs.pay');

Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');


// Route::post('/jobs/{job}/report', [ReportController::class, 'store']);
Route::post('/jobs/{job}/report', [App\Http\Controllers\ReportController::class, 'store'])->name('jobs.report');

Route::post('/subscribe', [SubscriberController::class, 'store']);

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {


    // Job Alerts
    Route::get('/job-alerts', [AdminJobAlertController::class, 'index'])->name('job-alerts.index');
    Route::delete('/job-alerts/{jobAlert}', [AdminJobAlertController::class, 'destroy'])->name('job-alerts.destroy');

    // Contacts
    Route::get('/contacts', [ContactMessageController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [ContactMessageController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{contact}', [ContactMessageController::class, 'destroy'])->name('contacts.destroy');

    // Reports
    Route::resource('reports', AdminReportsController::class)->only(['index', 'show', 'destroy']);

    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::post('/jobs/{job}/approve', [AdminController::class, 'approve'])->name('approve');

    Route::post('/jobs/{job}/reject', [AdminController::class, 'reject'])->name('reject');

    Route::get('/jobs/pending', [AdminJobController::class, 'pending'])->name('jobs.pending');

    Route::get('/users/employers', [AdminUserController::class, 'employers'])->name('users.employers');

    Route::post('/users/{user}/suspend', [AdminUserController::class, 'suspend'])->name('users.suspend');

    Route::get('/revenue/payments', [AdminPaymentController::class, 'index'])->name('revenue.payments');

    Route::get('/jobs/trash', [AdminJobController::class, 'trash'])->name('jobs.trash');
    Route::patch('/jobs/{user}/restore', [AdminJobController::class, 'restore'])->name('jobs.restore');
    Route::delete('/jobs/{user}/force-delete', [AdminJobController::class, 'forceDelete'])->name('jobs.forceDelete');

    Route::resource('plans', AdminPlanController::class);
    // Protected routes
    Route::resource('jobs', AdminJobController::class);
    Route::resource('users', AdminUserController::class);


    Route::get('/dashboard-stats', [AdminController::class, 'stats'])->name('dashboard.stats');

    Route::get('/payments/export', [AdminPaymentController::class, 'export'])->name('payments.export');

    Route::get('/revenue/chart', [AdminPaymentController::class, 'chart'])->name('revenue.chart');

    Route::get('/employers/export', [AdminUserController::class, 'exportEmployers'])->name('users.employers.export');

    Route::get('jobs/export', [AdminJobController::class, 'export'])->name('jobs.export');
    Route::post('/jobs/{job}/toggle-featured', [AdminJobController::class, 'toggleFeatured'])->name('jobs.toggleFeatured');

    Route::get('/user-logs', [UserLogController::class, 'index'])
        ->name('user_logs.index');

    Route::get('/user-logs/export', [\App\Http\Controllers\Admin\UserLogController::class, 'export'])
        ->name('user_logs.export');

    Route::get('/system-status', [SystemStatusController::class, 'index'])
        ->name('system-status');

    Route::get('/status', function () {

        $db = true;

        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            $db = false;
        }

        return view('admin.system.status', [
            'db' => $db,
            'app' => config('app.name'),
        ]);
    })->name('system.status');

    Route::resource('/opportunities', AdminOpportunityController::class);
});

Route::middleware(['auth', 'editor'])->group(function () {
    Route::resource('categories', CategoryController::class)
        ->only(['index', 'store']);
});

Route::middleware('auth')->group(function () {
    // List notifications
    Route::get('/notifications', function () {
        $notifications = Auth::user()->notifications()->paginate(10);
        return view('notifications.index', compact('notifications'));
    })->name('notifications.index');

    // Mark all as read
    Route::post('/notifications/read', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.read.all');

    // Mark one as read
    Route::post('/notifications/read/{notification}', function ($notificationId) {
        $notification = Auth::user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();

        // Redirect to job if available
        if (isset($notification->data['job_uuid'], $notification->data['job_slug'])) {
            return redirect()->route('jobs.show', [
                $notification->data['job_uuid'],
                $notification->data['job_slug']
            ]);
        }

        return redirect()->route('notifications.index');
    })->name('notifications.read.single');
});

// Route::get('/admin/dashboard-stats', [AdminController::class, 'stats'])
//     ->middleware(['auth', 'admin'])
//     ->name('admin.dashboard.stats');

// Route::get('/admin/payments/export', [AdminPaymentController::class, 'export'])
//     ->name('admin.payments.export');

// Route::get('/admin/revenue/chart', [AdminPaymentController::class, 'chart'])
//     ->name('admin.revenue.chart');

// Route::get('/admin/employers/export', [AdminUserController::class, 'exportEmployers'])
//     ->name('admin.users.employers.export');

// Route::get('jobs/export', [AdminJobController::class, 'export'])
//     ->name('admin.jobs.export');

// Route::post('/admin/jobs/{job}/toggle-featured', [AdminJobController::class, 'toggleFeatured'])->name('admin.jobs.toggleFeatured');


// Route::delete('/employer/jobs/{id}/force-delete', [EmployerController::class, 'forceDelete'])->name('employer.jobs.forceDelete');

// Route::prefix('editor')
//     ->middleware('editor')
//     ->group(function () {
//         Route::resource('categories', CategoryController::class)
//             ->only(['index', 'store']);
//     });




// Route::get('/', function () {
//     return view('welcome');
// });
