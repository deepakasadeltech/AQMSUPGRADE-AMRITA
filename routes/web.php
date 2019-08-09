<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['middleware' => 'install'], function() {
Route::get('/', ['as' => 'main', 'uses' => 'MainController@redirect']);
Route::get('locale/{locale}', ['as' => 'change_locale', 'uses' => 'MainController@changeLocale']);

// Login
Route::get('login', ['as' => 'get_login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => 'post_login', 'uses' => 'Auth\LoginController@login']);

// Forgot Password
Route::get('password/email', ['as' => 'get_email', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/email', ['as' => 'post_email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);

// Reset Password
Route::get('password/reset/{token}', ['as' => 'get_reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
Route::post('password/reset', ['as' => 'post_reset', 'uses' => 'Auth\ResetPasswordController@reset']);

// Add to Queue
Route::get('queue', ['as' => 'add_to_queue', 'uses' => 'AddToQueueController@index']);
Route::post('queue', ['as' => 'post_add_to_queue', 'uses' => 'AddToQueueController@postDept']);
Route::post('refreshToken', ['as' => 'refresh_token', 'uses' => 'AddToQueueController@refreshToken']);
Route::post('queue/getRegistration', ['as' => 'post_registration', 'uses' => 'AddToQueueController@getRegistration']);
Route::post('queue/getPriority', ['as' => 'post_uhid', 'uses' => 'AddToQueueController@getPriority']);
Route::post('queue/doctortkn', ['as' => 'post_add_to_queue_kiosk', 'uses' => 'AddToQueueController@postDoctor']);
Route::get('queue/getReviewDoctorqueue', ['as' => 'post_reviewdoctorqueue', 'uses' => 'AddToQueueController@getReviewDoctorqueue']);
Route::get('queue/getReviewDepartmentqueue', ['as' => 'post_reviewdepartmentqueue', 'uses' => 'AddToQueueController@getReviewDepartmentqueue']);

// Display
Route::get('display', ['as' => 'display', 'uses' => 'DisplayController@index']);
Route::get('display/test/', ['as' => 'test', 'uses' => 'DisplayController@test']);
Route::post('display/autoCall', ['as' => 'auto_call', 'uses' => 'DisplayController@autoCall']);

// Display2
Route::get('display2', ['as' => 'display2', 'uses' => 'Display2Controller@index']);
Route::get('display2/test/', ['as' => 'test', 'uses' => 'Display2Controller@test']);
Route::post('display2/autoCall', ['as' => 'auto_call', 'uses' => 'Display2Controller@autoCall']);

// Authenticated
Route::group(['middleware' => 'auth:users'], function() {
// Logout
Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

// Dashboard
Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
Route::post('dashboard/settings', ['as' => 'dashboard_store', 'uses' => 'DashboardController@store']);
Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
Route::get('dashboard/startCounter/{call_id}', ['as' => 'startCounter', 'uses' => 'DashboardController@startCounter']);
Route::get('dashboard/endCounter/{call_id}', ['as' => 'endCounter', 'uses' => 'DashboardController@endCounter']);
Route::post('dashboard', ['as' => 'post_doctor_call', 'uses' => 'DashboardController@doctorDirectCall']);
Route::get('dashboard/PatientStatus/{user}', ['as' => 'PatientStatus', 'uses' => 'DashboardController@PatientStatus']);
Route::post('dashboard/DoctorviewStatus', ['as' => 'post_doctor_status', 'uses' => 'DashboardController@DoctorviewStatus']);
Route::post('dashboard/ourtoken', ['as' => 'post_doctor_call_ourtoken', 'uses' => 'DashboardController@doctorDirectCallOurToken']);
Route::post('dashboard/doctor/{doctor}', ['as' => 'refer_to_doctor', 'uses' => 'DashboardController@referToDoctor']);
Route::post('dashboard/department/{department}', ['as' => 'refer_to_department', 'uses' => 'DashboardController@referToDepartment']);
Route::post('dashboard/review/{id}', ['as' => 'patient_review', 'uses' => 'DashboardController@patientReview']);
Route::post('dashboard/endCounterdisp_doctor/{call_id}', ['as' => 'endCounterdisp_doctor', 'uses' => 'DashboardController@endCounterWithDispensaryDoctor']);
Route::get('dashboard/endCounterdisp_departmentdirect/{call_id}', ['as' => 'endCounterdisp_departmentdirect', 'uses' => 'DashboardController@endCounterWithDispensaryDepartment']);

Route::get('dashboard/endCounterdisp_department/{call_id}', ['as' => 'endCounterdisp_department', 'uses' => 'DashboardController@endCounterWithDispensaryDepartment']);



// Calls
Route::get('calls', ['as' => 'calls', 'uses' => 'CallController@index']);
Route::post('calls', ['as' => 'post_call', 'uses' => 'CallController@newCall']);
Route::post('calls/recall', ['as' => 'post_recall', 'uses' => 'CallController@recall']);
Route::post('calls/dept/{department}', ['as' => 'post_dept', 'uses' => 'CallController@postDept']);
Route::post('calls/getPriority', ['as' => 'post_uhid', 'uses' => 'CallController@getPriority']);
Route::post('calls/pdept', ['as' => 'post_pdept', 'uses' => 'CallController@postPdept']);
Route::get('calls/getRegistration', ['as' => 'post_registration', 'uses' => 'CallController@getRegistration']);
Route::get('calls/tokenmodify', ['as' => 'token_modify', 'uses' => 'CallController@tokenmodify']);
Route::post('calls/modify/{id}', ['as' => 'modify_token', 'uses' => 'CallController@modiFicationToken']);
Route::post('calls/modifydepartmet/{id}', ['as' => 'modify_token_departmet', 'uses' => 'CallController@modiFicationTokenDepartment']);
Route::get('calls/rePrintToken/{id}', ['as' => 'reprint_token', 'uses' => 'CallController@rePrintToken']);
Route::get('calls/rePrintTokenDoctor/{id}', ['as' => 'reprint_tokendoctor', 'uses' => 'CallController@rePrintTokenDoctor']);
Route::post('calls/doctor', ['as' => 'post_add_to_queue_doctor', 'uses' => 'CallController@postDoctor']);
Route::post('calls/reprintDepartment/{id}', ['as' => 'reprint_token_departmentwise', 'uses' => 'CallController@rePrintTokenDepartmentWise']);
Route::post('calls/reprintDoctor/{id}', ['as' => 'reprint_token_doctorwise', 'uses' => 'CallController@rePrintTokenDoctorWise']);
Route::get('calls/getRegistrationInDoctor', ['as' => 'post_registrationindoctor', 'uses' => 'CallController@getRegistrationInDoctor']);
Route::get('calls/getReviewDoctor', ['as' => 'post_reviewdoctor', 'uses' => 'CallController@getReviewDoctor']);
Route::get('calls/getReviewDepartment', ['as' => 'post_reviewdepartment', 'uses' => 'CallController@getReviewDepartment']);
//Export
Route::get('exports', ['as' => 'exports', 'uses' => 'ExportController@index']);

// Department
Route::resource('departments', 'DepartmentController', ['except' => ['show']]);

// Display Setting
Route::resource('displaysettings', 'DisplaySettingController', ['except' => ['show']]);
Route::post('displaysettings/displaytext', ['as' => 'update_displaytext', 'uses' => 'DisplaySettingController@displayTextUpdate']);
Route::post('displaysettings/displaybg', ['as' => 'update_displaybg', 'uses' => 'DisplaySettingController@displayBgUpdate']);
Route::post('displaysettings/displayvideo', ['as' => 'update_displayvideo', 'uses' => 'DisplaySettingController@displayVideoUpdate']);

// Limit Setting Superadmin
Route::resource('limits', 'LimitController', ['except' => ['show']]);
Route::post('limits/limitupdate', ['as' => 'update_limitdata', 'uses' => 'LimitController@limitDataUpdate']);

// Kiosk setting
Route::resource('queuesettings', 'QueueSettingController', ['except' => ['show']]);
Route::post('kiosksettings/kiosktext', ['as' => 'update_kiosktext', 'uses' => 'QueueSettingController@kioskTextUpdate']);
Route::post('kiosksettings/kioskbg', ['as' => 'update_kioskbg', 'uses' => 'QueueSettingController@kioskBgUpdate']);

// Parent Department
Route::resource('parent_departments', 'ParentDepartmentController', ['except' => ['show']]);

// Counter
Route::resource('counters', 'CounterController', ['except' => ['show']]);
Route::post('counters/spdept', ['as' => 'post_mpdept', 'uses' => 'CounterController@postMpDept']);

// Ad
Route::resource('ads', 'AdController', ['except' => ['show']]);
Route::post('ads/adsimg', ['as' => 'adv_img', 'uses' => 'AdController@Adimgupdate']);

//Reports
Route::group(['prefix' => 'reports', 'as' => 'reports::'], function() {
// User Report
Route::get('user', ['as' => 'user', 'uses' => 'UserReportController@index']);
Route::get('user/{user}/{sdate}/{edate}', ['as' => 'user_show', 'uses' => 'UserReportController@show']);
Route::get('user/{asdate}/{aedate}', ['as' => 'doctor_show', 'uses' => 'UserReportController@showrecord']);


// Queue list
Route::get('queuelist/{date}', ['as' => 'queue_list', 'uses' => 'QueueListReportController@index']);

// Monthly Report
Route::get('monthly', ['as' => 'monthly', 'uses' => 'MonthlyReportController@index']);
Route::get('monthly/{department}/{sdate}/{edate}', ['as' => 'monthly_show', 'uses' => 'MonthlyReportController@show']);

// Statistical Report
Route::get('statistical', ['as' => 'statistical', 'uses' => 'StatisticalReportController@index']);
Route::get('statistical/{date}/{user}/{department}/{counter}', ['as' => 'statistical_show', 'uses' => 'StatisticalReportController@show']);

// Missed
Route::get('missed-overtime', ['as' => 'missed', 'uses' => 'MissedOvertimeReportController@index']);
Route::get('missed-overtime/{date}/{user}/{counter}/{type}', ['as' => 'missed_show', 'uses' => 'MissedOvertimeReportController@show']);
});

// Users
Route::get('users/{user}/password', ['as' => 'get_user_password', 'uses' => 'UserController@getPassword']);
Route::post('users/{user}/password', ['as' => 'post_user_password', 'uses' => 'UserController@postPassword']);
Route::post('users/updept', ['as' => 'post_updept', 'uses' => 'UserController@postUpDept']);
Route::resource('users', 'UserController', ['except' => ['show', 'edit', 'update']]);
Route::get('users/updateStatus/{user}', ['as' => 'update_status', 'uses' => 'UserController@updateStatus']);



// Settings
Route::get('settings', ['as' => 'settings', 'uses' => 'SettingsController@index']);
Route::post('settings', ['as' => 'post_settings', 'uses' => 'SettingsController@update']);
Route::post('settings/userphoto', ['as' => 'user_photo', 'uses' => 'SettingsController@userPhoto']);
Route::post('settings/company', ['as' => 'post_company', 'uses' => 'SettingsController@companyUpdate']);
Route::post('settings/overmissed', ['as' => 'post_over_missed', 'uses' => 'SettingsController@overmissedUpdate']);
Route::post('settings/locale', ['as' => 'post_locale', 'uses' => 'SettingsController@localeUpdate']);
Route::get('settings/assignroom/{user}', ['as' => 'assignroom', 'uses' => 'SettingsController@assignroom']);

Route::post('settings/mapDept', ['as' => 'post_map_dept', 'uses' => 'SettingsController@mapDept']);
Route::post('settings/spdept', ['as' => 'post_spdept', 'uses' => 'SettingsController@postPdept']);
Route::post('settings/cgdept', ['as' => 'post_cgdept', 'uses' => 'SettingsController@postCgdept']);
Route::post('settings/cuserdept', ['as' => 'post_cuserdept', 'uses' => 'SettingsController@postUserdept']);
//Route::get('settings/{user}/doctormap', ['as' => 'get_doctor_mapdept', 'uses' => 'SettingsController@getMapDoctor']);
Route::post('settings/logo', ['as' => 'update_clogo', 'uses' => 'SettingsController@logoUpdate']);
});
});
