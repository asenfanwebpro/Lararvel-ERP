<?php 
/*
|--------------------------------------------------------------------------
| Web Routes 
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/      

Route::get('/', function(){
    if(session()->has('rememberme')){
        return redirect()->route('dashboard');
    }
    return redirect()->route('user.login');
})->name('/');


// Route login
Route::name('user.')->group(function () {
    Route::get('login', 'Auth\LoginController@store')->name('login');
    Route::post('login_post', 'Auth\LoginController@login')->name('login_post');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('profile/{id}', 'Auth\LoginController@profile');
    Route::post('profile_post', 'Auth\LoginController@profile_save')->name("profile");

    Route::get('register', 'Auth\RegisterController@store')->name('register');
    Route::post('register_post', 'Auth\RegisterController@register')->name('register_post');

    Route::get('forgotpassword', 'Auth\ForgotPasswordController@store')->name('forgotpassword');
    Route::post('forgotpassword_post', 'Auth\ForgotPasswordController@forgotpassword')->name('forgotpassword_post');

    Route::get('resetpassword', 'Auth\ResetPasswordController@index');
    Route::get('resetpassword/{token}', 'Auth\ResetPasswordController@store')->name('resetpassword');
    Route::post('resetpassword_post', 'Auth\ResetPasswordController@resetpassword_post')->name('resetpassword_post');
});

// Route dashboard
Route::get('/dashboard', 'LayoutController@content')->name('dashboard')->middleware('auth');

// Route Societa
Route::name('societa.')->middleware('auth')->group(function () {
    Route::get('societa_register', 'SocietaController@register')->name('register');
    Route::post('societa_save', 'SocietaController@save')->name('save');
    Route::get('societa_view', 'SocietaController@view')->name('view');
    Route::get('societa_edit/{id}', 'SocietaController@edit')->name('edit');
    Route::post('societa_delete', 'SocietaController@delete')->name('delete');
});

// Route Fornitori (Supplier)
Route::name('fornitori.')->middleware('auth')->group(function () {
    Route::get('fornitori_register', 'SocietaFornitoriController@register')->name('register');
    Route::post('fornitori_save', 'SocietaFornitoriController@save')->name('save');
    Route::get('fornitori_view', 'SocietaFornitoriController@view')->name('view');
    Route::get('fornitori_edit/{id}', 'SocietaFornitoriController@edit')->name('edit');
    Route::post('fornitori_delete', 'SocietaFornitoriController@delete')->name('delete');
});

//Route Mandati
Route::name('mandati.')->middleware('auth')->group(function () {
    Route::get('mandati_register', 'MandatiController@register')->name('register');
    Route::post('mandati_save', 'MandatiController@save')->name('save');
    Route::get('mandati_view', 'MandatiController@view')->name('view');
    Route::get('mandati_edit/{id}', 'MandatiController@edit')->name('edit');
    Route::post('mandati_delete', 'MandatiController@delete')->name('delete');
    Route::post('mandati_maxno', 'MandatiController@maxno')->name('maxno');
    Route::post('mandati_companymandati', 'MandatiController@companymandati')->name('companymandati');
    Route::get('mandati_print/{id}', 'MandatiController@dataprint')->name('print');
});

//Route protocoll
Route::name('protocol.')->middleware('auth')->group(function () {
    Route::post('protocol_register', 'ProtocolController@register')->name('register');
    Route::post('protocol_save', 'ProtocolSaveController@save')->name('save');
    Route::get('protocol_view/{companyid}', 'ProtocolController@view')->name('view');
    Route::get('protocol_views/{companyid}/{section}', 'ProtocolController@views')->name('views');
    Route::get('protocol_edit/{companyid}/{id}', 'ProtocolController@edit')->name('edit');
    Route::post('protocol_delete', 'ProtocolController@delete')->name('delete');
    Route::post('protocol_formhtml', 'ProtocolController@formhtml')->name('formhtml');
    Route::post('protocol_data', 'ProtocolController@data')->name('data');

    Route::post('protocol_note', 'ProtocolController@note')->name('note');
    Route::post('protocol_note_post', 'ProtocolController@note_post')->name('note_post');
    Route::post('protocol_note_delete', 'ProtocolController@note_delete')->name('note_delete');

    Route::post('protocol_file', 'ProtocolController@file_read')->name('file');
    Route::post('protocol_file_post', 'ProtocolController@file_post')->name('file_post');
    Route::post('protocol_file_delete', 'ProtocolController@file_delete')->name('file_delete');
});

//Route setting-protocol
Route::name('protocolsettings.')->middleware('auth')->group(function () {
    Route::get('protocolsettings_register', 'ProtocolSettingsController@register')->name('register');
    Route::post('protocolsettings_save', 'ProtocolSettingsController@save')->name('save');
    Route::get('protocolsettings_view', 'ProtocolSettingsController@view')->name('view');
    Route::get('protocolsettings_edit/{id}', 'ProtocolSettingsController@edit')->name('edit');
    Route::post('protocolsettings_delete', 'ProtocolSettingsController@delete')->name('delete');

});

//Route Protocol FormBuilder
Route::name('protocolform.')->middleware('auth')->group(function () {
    Route::get('protocolform_register', 'ProtocolFormController@register')->name('register');
    Route::post('protocolform_save', 'ProtocolFormController@save')->name('save');   
    Route::post('protocolform_section', 'ProtocolFormController@section')->name('section');  
    Route::post('protocolform_form', 'ProtocolFormController@load_form')->name('form');
});

//Route Mandati Invoice
Route::name('invoice.')->middleware('auth')->group(function () {
    Route::post('invoice_get', 'MandatiController@getinvoice')->name('getinvoice');    
    Route::post('invoice_save', 'MandatiController@saveinvoice')->name('save');      
    Route::post('invoice_delete', 'MandatiController@deleteinvoice')->name('delete');
});

//Route Mandati Payment
Route::name('payment.')->middleware('auth')->group(function () {
    Route::post('payment_get', 'MandatiController@getpayment')->name('getpayment');    
    Route::post('payment_save', 'MandatiController@savepayment')->name('save');      
    Route::post('payment_delete', 'MandatiController@deletepayment')->name('delete');    
});

//Route Mandati Nota
Route::name('mandatinota.')->middleware('auth')->group(function () {
    Route::post('mandatinota_get', 'MandatiController@getnote')->name('getnote');    
    Route::post('mandatinota_save', 'MandatiController@savenote')->name('save');      
    Route::post('mandatinota_delete', 'MandatiController@deletenote')->name('delete');    
});

//Route Departure
Route::name('departure.')->middleware('auth')->group(function () {
    Route::get('departure/ship', 'DepartureController@ship')->name('ship');
    Route::post('departure/shipsave', 'DepartureController@shipsave')->name('shipsave');
    Route::post('departure/shipedit', 'DepartureController@shipedit')->name('shipedit');
    Route::post('departure/shipdelete', 'DepartureController@shipdelete')->name('shipdelete');

    Route::get('departure/port', 'DepartureController@port')->name('port');
    Route::post('departure/portsave', 'DepartureController@portsave')->name('portsave');
    Route::post('departure/portedit', 'DepartureController@portedit')->name('portedit');
    Route::post('departure/portdelete', 'DepartureController@portdelete')->name('portdelete');

    Route::get('departure/time', 'DepartureController@time')->name('time');
    Route::get('departure/info/{id}', 'DepartureController@info')->name('infoid');
    Route::get('departure/nota', function(){
        return redirect('departure/info/-1'); 
    })->name('nota');
    Route::post('departure/save', 'DepartureController@save')->name('save');
    Route::post('departure/delete', 'DepartureController@delete')->name('delete');

    Route::post('departure/notesave', 'DepartureController@notesave')->name('notesave');
    Route::post('departure/noteedit', 'DepartureController@noteedit')->name('noteedit');
    Route::post('departure/notedelete', 'DepartureController@notedelete')->name('notedelete');

    Route::get('departure/background', 'DepartureController@background')->name('background');
    Route::post('departure/backgroundsave', 'DepartureController@backgroundsave')->name('backgroundsave');
    Route::post('departure/backgroundedit', 'DepartureController@backgroundedit')->name('backgroundedit');
    Route::post('departure/backgrounddelete', 'DepartureController@backgrounddelete')->name('backgrounddelete');
});

Route::get('monitor/biglietteria/{port}', 'DepartureController@monitor')->name('monitor.biglietteria');
Route::post('monitor/biglietteria/realdata', 'DepartureController@monitor_port');
Route::get('monitor/biglietteria/{port}/{tag}', 'DepartureController@monitor_tag');
Route::post('monitor/biglietteria/realdata_tag', 'DepartureController@monitor_port_tag');
Route::get('monitor/table/{port1}/{port2}', 'DepartureController@monitor_table')->name('monitor.table');

Route::name('permission.')->middleware('auth')->group(function () {
    Route::get('usergroup', 'PermissionController@group')->name('group');
    Route::post('getgroup', 'PermissionController@getgroup')->name('getgroup');
    Route::post('savegroup', 'PermissionController@savegroup')->name('savegroup');
    Route::post('deletegroup', 'PermissionController@deletegroup')->name('deletegroup');
    Route::post('getpermission', 'PermissionController@getpermission')->name('getpermission');
    Route::post('savepermission', 'PermissionController@savepermission')->name('savepermission');
    Route::get('userlist', 'PermissionController@list')->name('list');
    Route::get('useredit/{id}', 'PermissionController@useredit');
    Route::post('saveuser', 'PermissionController@saveuser')->name('saveuser');
    Route::post('deleteuser', 'PermissionController@deleteuser')->name('deleteuser');
    

});

//Route Ecommerce
Route::name('ecommerce.')->middleware('auth')->group(function () {
    Route::get('category', 'EcommerceController@category')->name('category'); 
    Route::post('categoryedit', 'EcommerceController@categoryedit')->name('categoryedit'); 
    Route::post('categorysave', 'EcommerceController@categorysave')->name('categorysave'); 
    Route::post('categorydelete', 'EcommerceController@categorydelete')->name('categorydelete');

    Route::get('brand', 'EcommerceController@brand')->name('brand'); 
    Route::post('brandedit', 'EcommerceController@brandedit')->name('brandedit'); 
    Route::post('brandsave', 'EcommerceController@brandsave')->name('brandsave'); 
    Route::post('branddelete', 'EcommerceController@branddelete')->name('branddelete');

    Route::get('product', 'EcommerceController@product')->name('product'); 
    Route::post('productedit', 'EcommerceController@productedit')->name('productedit'); 
    Route::post('productsave', 'EcommerceController@productsave')->name('productsave'); 
    Route::post('productdelete', 'EcommerceController@productdelete')->name('productdelete');

    Route::get('order', 'EcommerceController@order')->name('order'); 
    Route::post('orderno', 'EcommerceController@orderno')->name('orderno');
    Route::post('orderedit', 'EcommerceController@orderedit')->name('orderedit'); 
    Route::post('ordersave', 'EcommerceController@ordersave')->name('ordersave'); 
    Route::post('orderdelete', 'EcommerceController@orderdelete')->name('orderdelete');

    Route::get('shop/{id}', 'EcommerceController@shop'); 
    Route::post('productdetail;', 'EcommerceController@productdetail')->name('productdetail'); 
    
    Route::post('checkout', 'EcommerceController@checkout')->name('checkout');
    Route::post('checkoutsave', 'EcommerceController@checkoutsave')->name('checkoutsave');

    Route::get('orderprint/{id}', 'EcommerceController@orderprint');
    
});