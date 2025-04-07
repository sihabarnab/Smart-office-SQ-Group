<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

//Deed
use App\Http\Controllers\DeedController;



Route::group(['middleware' => ['auth','auth2']], function () {


//Deed
Route::get('/deed', [App\Http\Controllers\ModuleController::class, 'deed'])->name('deed');
//Deed Backoffice
//Land Owner
Route::get('/deed/land_owner_info', [DeedController::class, 'DeedLandOwnerInfo'])->name('land_owner_info');
Route::post('/deed/land_owner_info', [DeedController::class, 'DeedLandOwnerInfoStore'])->name('DeedLandOwnerInfoStore');
Route::get('/deed/land_owner_info/{id}', [DeedController::class, 'DeedLandOwnerInfoEdit'])->name('DeedLandOwnerInfoEdit');
Route::post('/deed/land_owner_info/{update}', [DeedController::class, 'DeedLandOwnerInfoUpdate'])->name('DeedLandOwnerInfoUpdate');


//Thana / Upazila 
Route::get('/deed/thana_info', [DeedController::class, 'DeedThanaInfo'])->name('thana_info');
Route::post('/deed/thana_info', [DeedController::class, 'DeedThanaInfoStore'])->name('DeedThanaInfoStore');
Route::get('/deed/thana_info/{id}', [DeedController::class, 'DeedUpzilaEdit'])->name('DeedUpzilaEdit');
Route::post('/deed/thana_info/{update}', [DeedController::class, 'DeedUpzilaUpdate'])->name('DeedUpzilaUpdate');

//Mouja 
Route::get('/deed/mouja_info', [DeedController::class, 'DeedMoujaInfo'])->name('mouja_info');
Route::post('/deed/mouja_info', [DeedController::class, 'DeedMoujaInfoStore'])->name('DeedMoujaInfoStore');
Route::get('/deed/mouja_info/{id}', [DeedController::class, 'DeedMoujaEdit'])->name('DeedMoujaEdit');
Route::post('/deed/mouja_info/{update}', [DeedController::class, 'DeedMoujaInfoUpdate'])->name('DeedMoujaInfoUpdate');

//Union 
Route::get('/deed/union_info', [DeedController::class, 'DeedUnionInfo'])->name('union_info');
Route::post('/deed/union_info', [DeedController::class, 'DeedUnionInfoStore'])->name('DeedUnionInfoStore');
// Route::get('/deed/union_info/{id}', [DeedController::class, 'DeedUnionEdit'])->name('DeedUnionEdit');
// Route::post('/deed/union_info/{update}', [DeedController::class, 'DeedUnionInfoUpdate'])->name('DeedUnionInfoUpdate');


//Doc Info
Route::get('deed/doc_info', [DeedController::class, 'DeedDocInfo'])->name('doc_info');
Route::post('deed/doc_info/store', [DeedController::class, 'DeedDocInfoStore'])->name('DeedDocInfoStore');
Route::get('/deed/doc_info/{id}', [DeedController::class, 'DeedDocInfoEdit'])->name('DeedDocInfoEdit');
Route::post('/deed/doc_info/{update}', [DeedController::class, 'DeedDocInfoUpdate'])->name('DeedDocInfoUpdate');



//Deed Entry
Route::get('/deed/deed_master_info', [DeedController::class, 'DeedMasterInfo'])->name('deed_master_info');
Route::post('deed/master_info/store', [DeedController::class, 'DeedMasterInfoStore'])->name('DeedMasterInfoStore');
Route::get('deed/master_info/en/{id}', [DeedController::class, 'DeedMasterInfoEnglish'])->name('DeedMasterInfoEnglish');
Route::get('deed/master_info/en/print/{id}', [DeedController::class, 'DeedMasterInfoEnPrint'])->name('DeedMasterInfoEnPrint');
Route::get('deed/master_info/bn/{id}', [DeedController::class, 'DeedMasterInfoBangla'])->name('DeedMasterInfoBangla');
Route::get('deed/master_info/bn/print/{id}', [DeedController::class, 'DeedMasterInfoBnPrint'])->name('DeedMasterInfoBnPrint');

//Deed Entry Edit
Route::get('/deed/deed_master_info/edit/{id}', [DeedController::class, 'DeedMasterInfoEdit'])->name('DeedMasterInfoEdit');
Route::get('/deed/land_owner/edit/{id}', [DeedController::class, 'DeedLandOwnerEdit'])->name('DeedLandOwnerEdit');
Route::post('/deed/deed_master_info/update', [DeedController::class, 'DeedMasterInfoUpdate'])->name('DeedMasterInfoUpdate');

//End Deed Entry Edit

//Deed owner
Route::get('deed/land_owner/{id}', [DeedController::class, 'DeedLandOwner'])->name('DeedLandOwner');
Route::post('deed/land_owner/store', [DeedController::class, 'DeedLandOwnerStore'])->name('DeedLandOwnerStore');

//Deed land Seller
Route::get('deed/land_seller_info/{id}', [DeedController::class, 'DeedLandSellerInfo'])->name('DeedLandSellerInfo');
Route::post('deed/land_seller_info/store', [DeedController::class, 'DeedLandSellerInfoStore'])->name('DeedLandSellerInfoStore');
//Deed land Seller next
Route::get('deed/land_seller_info/next/{id}', [DeedController::class, 'DeedLandSellerInfoNext'])->name('DeedLandSellerInfoNext');
Route::post('deed/land_seller_info/update', [DeedController::class, 'DeedLandSellerInfoUpdate'])->name('DeedLandSellerInfoStore2');

//tapsil info
Route::get('deed/tapsil_info/{id}', [DeedController::class, 'DeedTapsilInfo'])->name('DeedTapsilInfo');
Route::post('deed/tapsil_info/store', [DeedController::class, 'DeedTapsilInfoStore'])->name('DeedTapsilInfoStore');

//namjari info
Route::get('deed/namjari/{id}', [DeedController::class, 'DeedNamjari'])->name('DeedNamjari');
Route::post('deed/namjari/store', [DeedController::class, 'DeedNamjariStore'])->name('DeedNamjariStore');

//End Deed


//Doc file
Route::get('/deed/doc_upload_list', [DeedController::class, 'DeedDocUploadList'])->name('doc_upload_list');
Route::get('deed/doc_upload_list/{id}', [DeedController::class, 'DeedDocFile'])->name('doc_file');
Route::post('deed/doc_upload_list/store', [DeedController::class, 'DeedDocFileStore'])->name('DeedDocFileStore');

//Deed Report
Route::get('/deed/rpt_deed_list', [DeedController::class, 'DeedRptList'])->name('rpt_deed_list');


// ajax call
Route::get('get/district/{id}', [DeedController::class, 'GetDistrict']);
Route::get('get/upazilas/{id}', [DeedController::class, 'GetUpazila']);
Route::get('get/union/{id}', [DeedController::class, 'GetUnion']);
Route::get('get/mouja/{id}', [DeedController::class, 'GetMouja']);
Route::get('get/doc_info/{id}', [DeedController::class, 'GetDocInfo']);


});