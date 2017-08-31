<?php

namespace App\Http\Controllers\cms\modules\multicms;

use Illuminate\Http\Request;
use App\Page;
use App\Services\PhotoGalleryService;
use App\Services\PhotoGalleryLgService;
use App\Services\PicturesService;
use App\Services\PicturesLgService;
use App\Services\LanguageService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\PhotoGallery;
use Input;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use File;
use Image;
use DB;
use App\customHelper\InputHelpers;
use App\Services\DefaultLanguageService;
use URL;

class galleryController extends Controller
{
  public $thisPageId = 'gallery';

  public $thisModuleId = "multicms";

  public function __construct(
    PhotoGalleryService $pgService,
    PhotoGalleryLgService $pgLgService,
    PicturesService $pService,
    PicturesLgService $pLgService,
    LanguageService $language,
    DefaultLanguageService $defLang
  ) {

    $this->photoGalleryLg  = $pgLgService;
    $this->photoGallery    = $pgService;
    $this->photoLg         = $pLgService;
    $this->photo           = $pService;
    $this->language        = $language;
    $this->defaultLanguage = $defLang;
  }


  


  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $rootParent  = $this->photoGallery->rootParentList();
    $dash        = "";
    $recurArray  = [ ];
    $galleryList = collect([ ]);
    $recurList   = $this->recur($rootParent, $dash, $recurArray);

    //generate full list of rows from recursive list of array of rootParentList
    foreach ($recurList as $key => $value) {
      $gallery          = $this->photoGallery->getDataById($key);
      $gallery["title"] = $value;
      $galleryList->push($gallery);
    }

    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $data['galleryData']  = $galleryList;
    $data['toggleUrl'] = URL::to(PREFIX.'/multicms/pages/gallery/toggleStatus');

    return view('cms.modules.multicms.photoGallery_listall', $data);
  }

  /**
   *for toggling status.
   *
   * @return Response
   */
  public function toggleStatus()
  {
    $id = Input::get('id');
    $status = $this->photoGallery->getDataById($id)->status;
    if($status == 'active')
    {
      $data['status'] = 'inactive';
      if($this->photoGallery->updateData($data,$id)){
        echo ucfirst($this->photoGallery->getDataById($id)->status);
      }
      else
        header('HTTP/1.1 500 Internal Server Error');
      
    }
    elseif($status == "inactive")
    {
      $data['status'] = 'active';
      if($this->photoGallery->updateData($data,$id)){
        echo ucfirst($this->photoGallery->getDataById($id)->status);
      }
      else
        header('HTTP/1.1 500 Internal Server Error');
    }
    else
    {
      header('HTTP/1.1 400 Bad Request');
    }
    exit();

  }

  /**
   * Generate Array that is used to render dropdown item recursively in parent-child structure for form
   * Author:Sumit KC
   * @return Array
   */
  public function recur($rootParent, $dash, $dropdown)
  {
    foreach ($rootParent as $key => $value) {
      $dropdown += [ $key => $dash . $value ];
      $pages = $this->photoGallery->getDataById($key);

      if (count($pages->child) > 0) {
        $dash .= DASH;
        $roots = PhotoGallery::where('parent_id', '=', $pages->id)->lists('title', 'id')->toArray();
        foreach ($roots as $key => $value) {

          $dropdown += $this->recur([ $key => $value ], $dash, $dropdown);

        }

      }
      $dash = "";
    }

    return $dropdown;
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $rootParent           = $this->photoGallery->rootParentList();

    $dash        = "";
    $dropdown    = [ ];
    $galleryList = [ "" => 'Select Gallery' ] + $this->recur($rootParent, $dash, $dropdown);

    $flags     = $this->language->getAllDataNoPagination();
    $galleryLg = $this->photoGalleryLg->getAllDataNoPagination();

    return view('cms.modules.multicms.photoGallery_addnew', compact('galleryList', 'galleryLg', 'flags'), $data);
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  Request $request
   *
   * @return Response
   */
  public function store()
  {
    $inputs = Input::all();

    $validator = $this->photoGallery->validate($inputs);
    if ($validator->fails()) {
      return redirect(PREFIX.'/multicms/pages/gallery/photoCreate')->withErrors($validator)->withInput();
    }

    if (Input::hasFile('cover_pic')) {
      $directory    = base_path() . '/uploads/gallery';
      $originalName = InputHelpers::cleanURL(Input::file('cover_pic')->getClientOriginalName());
      $fileName     = uniqid() .'.'.Input::file('cover_pic')->getClientOriginalExtension();
      $fileNameDir  = $directory . '/' . $fileName;
      $image        = Image::make(Input::file('cover_pic'));
      $image->resize(200, null, function ($constraint) {
        $constraint->aspectRatio();
      });
      $image->save($fileNameDir, 100);
      $inputs['cover_pic'] = $fileName;
    }

    // Store the gallery details

   if($this->photoGallery->add($inputs))
   {
    $data['msgSuccess'] ="Gallery added.";
    return redirect(PREFIX.'/multicms/pages/gallery')->withErrors($data);
   }
   else
   {
    $data['msgError'] ="Could not add gallery.";
    return redirect(PREFIX.'/multicms/pages/gallery')->withErrors($data);
   } 
    


  }


  /**
   * Display the specified resource.
   *
   * @param  int $id
   *
   * @return Response
   */
  public function show($id)
  {
    //
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   *
   * @return Response
   */
  public function edit()
  {

    $data['id'] = Input::get('id');
    $page       = $this->photoGallery->getDataById($data['id']);

    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $rootParent           = $this->photoGallery->rootParentList();
    $dash                 = "";
    $dropdown             = [ ];
    $pageList             = [ "" => 'Select Gallery' ] + $this->recur($rootParent, $dash, $dropdown);

    return view('cms.modules.multicms.photoGallery_edit', compact('page', 'pageList'), $data);
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  Request $request
   * @param  int     $id
   *
   * @return Response
   */
  public function update()
  {

    $inputs    = Input::all();
    $id        = Input::get('id');
    $validator = $this->photoGallery->validateUpdate($inputs, $id);
    if ($validator->fails()) {
      return redirect(PREFIX . '/multicms/pages/photoGallery/edit?id=' . $id)->withErrors($validator)->withInput();
    }

    if (Input::hasFile('cover_pic')) {
      $imageName = $this->photoGallery->getDataById($id)->cover_pic;

      $directory = base_path() . '/uploads/gallery';

      //if image exists,delete previous image
      if ($this->photoGallery->getDataById($id)->cover_pic !== "") {

        File::delete($directory . '/' . $imageName);

      }

      $originalName = InputHelpers::cleanURL(Input::file('cover_pic')->getClientOriginalName());
      $fileName     = uniqid() .'.'.Input::file('cover_pic')->getClientOriginalExtension();
      $fileNameDir  = $directory . '/' . $fileName;
      $image        = Image::make(Input::file('cover_pic'));
      $image->resize(200, null, function ($constraint) {
        $constraint->aspectRatio();
      });

      $image->save($fileNameDir, 100);
      $inputs['cover_pic'] = $fileName;

    }

    if ($this->photoGallery->updateData($inputs, $id)) {
      $data['msgSuccess'] = "Gallery updated.";
      return redirect(PREFIX.'/multicms/pages/gallery')->withErrors($data);
    } else {
      $data['msgError'] = "Gallery could not be updated.";
      return redirect(PREFIX.'/multicms/pages/gallery')->withErrors($data);
    }

  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   *
   * @return Response
   */
  public function destroy()
  {

    $id = Input::get('id');

    if ( ! empty( $this->photoGallery->getDataById($id)->cover_pic )) {
      $cover_pic = $this->photoGallery->getDataById($id)->cover_pic;

      $coverpicDirectory = base_path() . '/uploads/gallery';

      File::delete($coverpicDirectory . '/' . $cover_pic);

    }

    $success = "Successfully deleted Page";
    $error   = "Error! Adding Page";

    if ($this->photoGallery->deleteData($id)) {
      return redirect(PREFIX.'/multicms/pages/gallery')->withErrors($success);
    } else {
      return redirect(PREFIX.'/multicms/pages/gallery')->withErrors($error);
    }


  }

  //methods for tbl_photo_gallery_lg

  /**
   * Display create form for managing Page and inserting tbl_pages_lg.
   *
   * @return Response
   */
  public function manage()
  {

    $rootParent  = $this->photoGallery->rootParentList();
    $dash        = "";
    $dropdown    = [ ];
    $galleryList = [ "" => 'Select Gallery' ] + $this->recur($rootParent, $dash, $dropdown);

    //for PagesLg Manage
    $flags                = $this->language->getAllDataNoPagination();
    $data['id']           = Input::get('id');
    $galleryLg            = $this->photoGalleryLg->getAllDataNoPagination();
    $gallery              = $this->photoGallery->getDataById($data['id']);
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;

    return view('cms.modules.multicms.photoGallery_manage', compact('gallery', 'flags', 'galleryLg', 'galleryList'), $data);

  }


  /**
   * Display create form for managing Page and inserting tbl_gallery_lg.
   *
   * @return Response
   */
  public function allUpdate()
  {

    $langId                = $this->language->getAllDataNoPagination()->pluck('id');
    $defLang               = $this->defaultLanguage->getDefaultLang();
    $galleryInput          = Input::get('form.gallery');
    $galleryInput['title'] = Input::get('form.' . $defLang . '.title');
    $validator             = $this->photoGallery->validate($galleryInput);
    $galleryId = Input::get('form.gallery.id');

    if ($validator->fails()) {
      Session::put('flag', Input::get('form.' . $defLang . '.language_id'));

      return redirect(PREFIX . '/multicms/pages/gallery/manage?id=' . Input::get('form.gallery.id'))->withErrors($validator)->withInput();
    }

    if (Input::hasFile('form.gallery.cover_pic')) {
      if (( ( Input::file('form.gallery.cover_pic')->getClientMimeType() ) != "image/jpeg" ) && ( ( Input::file('form.gallery.cover_pic')->getClientMimeType() ) != "image/bmp" ) && ( ( Input::file('form.gallery.cover_pic')->getClientMimeType() ) != "image/png" )) {
        $data['msgError'] = 'The Icon Image is not valid !only jpeg,jpg,bmp & png image type are supported';
        Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

        return redirect(PREFIX . '/multicms/pages/gallery/manage?id=' . Input::get('form.gallery.id'))->withErrors($data)->withInput();
      }

      //if image exists,delete previous image
      $directory = base_path() . '/uploads/gallery';
      if ($this->photoGallery->getDataById($galleryId)->cover_pic !== "") {
        $imageName = $this->photoGallery->getDataById($galleryId)->cover_pic;
        File::delete($directory . '/' . $imageName);

      }


              $originalName = InputHelpers::cleanURL(Input::file('form.gallery.cover_pic')->getClientOriginalName());
              $fileName = uniqid() .'.'.Input::file('form.gallery.cover_pic')->getClientOriginalExtension();
              $fileNameDir = $directory.'/'.$fileName;
              $image = Image::make(Input::file('form.gallery.cover_pic'));
              $image->resize(500, null, function ($constraint) {
                  $constraint->aspectRatio();
              });
              $image->save($fileNameDir,100);
              $galleryInput['cover_pic'] = $fileName;

    }

    if ( ! ( $this->photoGallery->updateData($galleryInput, Input::get('form.gallery.id')) )) {
      //now retrieve recently inserted id of row on tbl_page table.

      $data['msgError'] = 'Error Adding Gallery !!';

      return redirect(PREFIX . '/multicms/pages/gallery')->withErrors($data);
    }

    $i   = 0;
    $len = count($langId);
    foreach ($langId as $lang_id) {

      if ( ! empty( Input::get('form.' . $lang_id . '.id') )) {

        //create new record in tbl_page_lg
        $inputs = Input::get('form.' . $lang_id);

        $validator = $this->photoGalleryLg->validate($inputs);
        if ($validator->fails()) {
          Session::put('flag', Input::get('form.' . $lang_id . 'language_id'));

          return redirect(PREFIX . '/multicms/pages/gallery/manage?id=' . Input::get('form.' . $lang_id . '.gallery_id'))->withErrors($validator)->withInput();
        }

        // Store the pages details

        //save changes

        if ($this->photoGalleryLg->updateData($inputs, Input::get('form.' . $lang_id . '.id'))) {

          $inputs = "";
          if ($i == $len - 1) {
            // last iteration of foreach loop
            $data['msgSuccess'] = 'Successfully saved !!';

            return redirect(PREFIX . '/multicms/pages/gallery')->withErrors($data);
          }

        } else {
          $inputs           = "";
          $data['msgError'] = 'Changes could not be saved !!';

          return redirect(PREFIX . '/multicms/pages/gallery')->withErrors($data);
        }
      } else {

        //create new record in tbl_photo_gallery_lg
        $inputs = Input::get('form.' . $lang_id);

        $validator = $this->photoGalleryLg->validate($inputs);
        if ($validator->fails()) {
          Session::put('flag', Input::get('form.' . $lang_id . 'language_id'));

          return redirect(PREFIX . '/multicms/pages/gallery/manage?id=' . Input::get('form.' . $lang_id . 'gallery_id'))->withErrors($validator)->withInput();
        }

        // Store the pages details

        //save changes
        if ($this->photoGalleryLg->add($inputs)) {

          $inputs = "";
          if ($i == $len - 1) {
            // last iteration of foreach loop
            $data['msgSuccess'] = 'Successfully saved !!';

            return redirect(PREFIX . '/multicms/pages/gallery')->withErrors($data);
          }

        } else {
          $inputs           = "";
          $data['msgError'] = 'Changes could not be saved !!';

          return redirect(PREFIX . '/multicms/pages/gallery')->withErrors($data);
        }

      }

      $i++;
    }

  }


  public function galleryLgCreate()
  {
    $langId = $this->language->getAllDataNoPagination()->pluck('id');

    //the validation should be done for title and images so,pages module contains
    //validations for fields other than of its own field as well
    // a separate validation for checking if title of default language is set or not.

    $defLang               = $this->defaultLanguage->getDefaultLang();
    $galleryInput          = Input::get('form.gallery');
    $galleryInput['title'] = Input::get('form.' . $defLang . '.title');

    $validator = $this->photoGallery->validate($galleryInput);
    if ($validator->fails()) {
      Session::put('flag', Input::get('form.' . $defLang . '.language_id'));

      return redirect(PREFIX . '/multicms/pages/gallery/create')->withErrors($validator)->withInput();
    }

    if (Input::hasFile('form.gallery.cover_pic')) {
      if (( ( Input::file('form.gallery.cover_pic')->getClientMimeType() ) != "image/jpeg" ) && ( ( Input::file('form.gallery.cover_pic')->getClientMimeType() ) != "image/bmp" ) && ( ( Input::file('form.gallery.cover_pic')->getClientMimeType() ) != "image/png" )) {
        $data['msgError'] = 'The Icon Image is not valid !only jpeg,jpg,bmp & png image type are supported';
        Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

        return redirect(PREFIX . '/multicms/pages/gallery/create')->withErrors($data)->withInput();
      }

      $directory = base_path() . '/uploads/gallery';

      $originalName = Input::file('form.gallery.cover_pic')->getClientOriginalName();
      $fileName     = uniqid() .'.'.Input::file('form.gallery.cover_pic')->getClientOriginalExtension();
      $fileNameDir  = $directory . '/' . $fileName;
      $image        = Image::make(Input::file('form.gallery.cover_pic'));
      $image->resize(500, null, function ($constraint) {
        $constraint->aspectRatio();
      });
      $image->save($fileNameDir, 100);
      $galleryInput['cover_pic'] = $fileName;
    }

    $savedGallery = $this->photoGallery->add($galleryInput);

    if ($savedGallery) {
      //now retrieve recently inserted id of row on tbl_page table.
      $gallery_id = $savedGallery->id;
    } else {
      $data['msgError'] = 'Error Adding Gallery !!';


              $originalName = InputHelpers::cleanURL(Input::file('form.gallery.cover_pic')->getClientOriginalName());
              $fileName = uniqid() .'.'.Input::file('form.gallery.cover_pic')->getClientOriginalExtension();
              $fileNameDir = $directory.'/'.$fileName;
              $image = Image::make(Input::file('form.gallery.cover_pic'));
              $image->resize(500, null, function ($constraint) {
                  $constraint->aspectRatio();
              });
              $image->save($fileNameDir,100);
              $galleryInput['cover_pic'] = $fileName;

    }

    $i   = 0;
    $len = count($langId);
    foreach ($langId as $lang_id) {

      //create new record in tbl_page_lg
      $inputs = Input::get('form.' . $lang_id);

      $validator = $this->photoGalleryLg->validate($inputs);
      if ($validator->fails()) {
        Session::put('flag', Input::get('form.' . $lang_id . 'language_id'));

        return redirect(PREFIX . '/multicms/pages/pages/managePage?id=' . Input::get('form.' . $lang_id . 'gallery_id'))->withErrors($validator)->withInput();
      }

      // Store the pages details

      //save changes
      $inputs['gallery_id'] = $gallery_id;
      if ($this->photoGalleryLg->add($inputs)) {

        $inputs = "";
        if ($i == $len - 1) {
          // last iteration of foreach loop
          $data['msgSuccess'] = 'Successfully saved !!';

          return redirect(PREFIX . '/multicms/pages/gallery')->withErrors($data);
        }

      } else {
        $inputs           = "";
        $data['msgError'] = 'Changes could not be saved !!';

        return redirect(PREFIX . '/multicms/pages/gallery')->withErrors($data);
      }

      $i++;
    }

  }


  public function galleryLgManage()
  {

    $langId = $this->language->getAllDataNoPagination()->pluck('id');
    $i      = 0;
    $len    = count($langId);
    foreach ($langId as $lang_id) {
      if ( ! empty( Input::get('form.' . $lang_id . '.id') )) {
        //update the existing row on tbl_page_lg table with reference to id.

        $inputs    = Input::get('form.' . $lang_id);
        $id        = Input::get('form.' . $lang_id . '.id');
        $validator = $this->photoGalleryLg->validateUpdate(Input::get('form.' . $lang_id), $id);
        if ($validator->fails()) {
          Session::put('flag', Input::get('form.' . $lang_id . '.language_id'));

          return redirect(PREFIX . '/multicms/pages/pages/managePage?id=' . Input::get('form.' . $lang_id . '.page_id'))->withErrors($validator)->withInput();
        }

        if ($this->photoGalleryLg->updateData($inputs, $id)) {

          $inputs = "";
          if ($i == $len - 1) {
            // last iteration of foreach loop
            return redirect(PREFIX . '/multicms/pages/gallery')->withErrors("successSetting");
          }

        } else {
          $inputs = "";

          return redirect(PREFIX . '/multicms/pages/gallery')->withErrors('errEdit');
        }


      } else {
        //create new record in tbl_page_lg
        $inputs = Input::get('form.' . $lang_id);

        $validator = $this->photoGalleryLg->validate($inputs);
        if ($validator->fails()) {
          Session::put('flag', Input::get('form.' . $lang_id . 'language_id'));

          return redirect(PREFIX . '/multicms/pages/gallery/manage?id=' . Input::get('form.' . $lang_id . 'gallery_id'))->withErrors($validator)->withInput();
        }

        $this->photoGalleryLg->add($inputs);
        $inputs = "";

        if ($i == $len - 1) {
          // last iteration of foreach loop
          return redirect(PREFIX . '/multicms/pages/gallery')->withErrors("successSetting");
        }


      }

      $i++;
    }

  }


/****************photos Methods***********************/



/**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function photoIndex()
  {
    return redirect(PREFIX . '/multicms/pages/gallery');
  }


  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function lists()
  {
    $data['id']           = Input::get('gallery_id');
    $data['gallery']      = PhotoGallery::where('id', '=', $data['id'])->first();
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $data['photos']       = $this->photo->listByGallery($data['id']);

    return view('cms.modules.multicms.photos_listall', $data);
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function photoCreate()
  {
    $gallery_id           = Input::get('gallery_id');
    $gallery              = PhotoGallery::where('id', '=', $gallery_id)->first();
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $flags                = $this->language->getAllDataNoPagination();

    return view('cms.modules.multicms.photos_addnew', compact('flags', 'gallery'), $data);

  }


   /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function multiUpload()
  {
    $gallery_id           = Input::get('gallery_id');
    $gallery              = PhotoGallery::where('id', '=', $gallery_id)->first();
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $flags                = $this->language->getAllDataNoPagination();

    return view('cms.modules.multicms.photos_multiUp', compact('flags', 'gallery'), $data);

  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function multiUploadHandler()
  { 
    
    $gallery_id           = Input::get('gallery_id');
    $langId               = $this->language->getAllDataNoPagination()->pluck('id');
    $files                = Input::file('files');

    foreach ($files as $file) {
      if (( ( $file->getClientMimeType() ) != "image/jpeg" ) && ( ( $file->getClientMimeType() ) != "image/bmp" ) && ( ( $file->getClientMimeType() ) != "image/png" )) {
        
        $data['msgError'] = 'The Image is not valid !,only jpeg,jpg,bmp & png image type are supported';

        return redirect(PREFIX . '/multicms/pages/gallery/multiUpload?gallery_id='.$gallery_id)->withErrors($data)->withInput();
      }

      if (( $file->getClientSize() ) > 3200000) {
        $data['msgError'] = 'The Image size is very large !,The size must me less than 3MB.';

        return redirect(PREFIX . '/multicms/pages/gallery/multiUpload?gallery_id='.$gallery_id)->withErrors($data)->withInput();
      }

      $directory    = base_path() . '/uploads/gallery/pictures';
      $originalName = InputHelpers::cleanURL($file->getClientOriginalName());
      $fileName     = uniqid() .'.'.$file->getClientOriginalExtension();
      $fileNameDir  = $directory . '/' . $fileName;
      $image        = Image::make($file);
      // $image->resize(500, null, function ($constraint) {
      //   $constraint->aspectRatio();
      // });
      $image->save($fileNameDir, 100);
      $photoInput['picture'] = $fileName;
      $photoInput['gallery_id'] = $gallery_id;
      $photoInput['status'] = "active";

      $savedphoto = $this->photo->add($photoInput);
      if ($savedphoto) {

        $pic_id = $savedphoto->id;

      }

      $i   = 0;
      $len = count($langId);
      foreach ($langId as $Lid) {

        //create new record in tbl_pictures_lg
        $inputs['language_id'] = $Lid;
        $input['status']       = "active";
        $inputs['picture_id']  = $pic_id;

        

        //save changes

        if ($this->photoLg->add($inputs)) {

          $inputs = "";
          // if ($i == $len - 1) {
          //   // last iteration of foreach loop
          //   $data['msgSuccess'] = 'Successfully saved !!';

          //   return redirect(PREFIX .'/multicms/pages/gallery/lists?gallery_id=' . $gallery_id)->withErrors($data);
          // }

        } else {
          $inputs           = "";
          $data['msgError'] = 'Either All or Some photos could not be saved !!';

          return redirect(PREFIX . '/multicms/pages/gallery/multiUpload?gallery_id='.$gallery_id)->withErrors($data);
        }

        $i++;
      }

    }

    return redirect(PREFIX.'/multicms/pages/gallery/lists?gallery_id=' . $gallery_id);

  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  Request $request
   *
   * @return Response
   */
  public function photoStore()
  {
    $langId     = $this->language->getAllDataNoPagination()->pluck('id');
    $gallery_id = Input::get('form.photo.gallery_id');

    $defLang               = $this->defaultLanguage->getDefaultLang();
    $photoInput            = Input::get('form.photo');
    $photoInput['picture'] = Input::file('form.photo.picture');

    $validator = $this->photo->validate($photoInput);
    if ($validator->fails()) {
      return redirect(PREFIX . '/multicms/pages/gallery/photoCreate?gallery_id=' . $gallery_id)->withErrors($validator)->withInput();
    }

    if (Input::hasFile('form.photo.picture')) {

      $directory    = base_path() . '/uploads/gallery/pictures';
      $originalName = InputHelpers::cleanURL(Input::file('form.photo.picture')->getClientOriginalName());
      $fileName     = uniqid() .'.'.Input::file('form.photo.picture')->getClientOriginalExtension();
      $fileNameDir  = $directory . '/' . $fileName;
      $image        = Image::make(Input::file('form.photo.picture'));
      $image->save($fileNameDir, 100);
      $photoInput['picture'] = $fileName;

    }

    $savedphoto = $this->photo->add($photoInput);
    if ($savedphoto) {
      $pic_id = $savedphoto->id;

    }

    $i   = 0;
    $len = count($langId);
    foreach ($langId as $Lid) {

      //create new record in tbl_page_lg
      $inputs               = Input::get('form.' . $Lid);
      $inputs['picture_id'] = $pic_id;

      $validator = $this->photoLg->validate($inputs);
      if ($validator->fails()) {
        Session::put('flag', Input::get('form.' . $Lid . 'language_id'));

        return redirect(PREFIX . '/multicms/pages/gallery/lists?gallery_id=' . $gallery_id)->withErrors($validator)->withInput();
      }

      // Store the pages details

      //save changes

      if ($this->photoLg->add($inputs)) {

        $inputs = "";
        if ($i == $len - 1) {
          // last iteration of foreach loop
          $data['msgSuccess'] = 'Successfully saved !!';

          return redirect(PREFIX . '/multicms/pages/gallery/lists?gallery_id=' . $gallery_id)->withErrors($data);
        }

      } else {
        $inputs           = "";
        $data['msgError'] = 'Changes could not be saved !!';

        return redirect(PREFIX . '/multicms/pages/gallery/lists?gallery_id=' . $gallery_id)->withErrors($data);
      }

      $i++;
    }

    // Store the pages details

    return redirect(PREFIX.'/multicms/pages/gallery/lists?gallery_id=' . $id);

  }


  /**
   * Display the specified resource.
   *
   * @param  int $id
   *
   * @return Response
   */
  public function photoShow($id)
  {
    //
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   *
   * @return Response
   */
  public function photoEdit()
  {
    $flags                = $this->language->getAllDataNoPagination();
    $data['id']           = Input::get('picture_id');
    $data['photo']        = Pictures::where('id', '=', $data['id'])->first();
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;

    return view('cms.modules.multicms.photoslg_addnew', $data, $flags);
  }


  // /**
  //  * Update the specified resource in storage.
  //  *
  //  * @param  Request $request
  //  * @param  int     $id
  //  *
  //  * @return Response
  //  */
  // public function photoUpdate()
  // {

  //   $inputs = Input::all();
  //   $id     = Input::get('id');
  //   // dd($id);
  //   $validator = $this->photoGallery->validateUpdate($inputs, $id);
  //   if ($validator->fails()) {
  //     return redirect(PREFIX . '/multicms/pages/photoGallery/edit?id=' . $id)->withErrors($validator)->withInput();
  //   }

  //   if (Input::hasFile('cover_pic')) {
  //     $imageName = $this->photoGallery->getDataById($id)->cover_pic;

  //     $directory = base_path() . '/uploads/gallery';

  //     //if image exists,delete previous image
  //     if ($this->photoGallery->getDataById($id)->cover_pic !== "") {

  //       File::delete($directory . '/' . $imageName);

  //     }

  //     $originalName = InputHelpers::cleanURL(Input::file('cover_pic')->getClientOriginalName());
  //     $fileName     = uniqid() .'.'.Input::file('cover_pic')->getClientOriginalExtension();
  //     $fileNameDir  = $directory . '/' . $fileName;
  //     $image        = Image::make(Input::file('cover_pic'));
  //     $image->resize(200, null, function ($constraint) {
  //       $constraint->aspectRatio();
  //     });

  //     $image->save($fileNameDir, 100);
  //     $inputs['cover_pic'] = $fileName;

  //   }

  //   if ($this->photoGallery->updateData($inputs, $id)) {
  //     return redirect(PREFIX.'/photoGallery')->withErrors('edit');
  //   } else {
  //     return redirect(PREFIX.'/photoGallery')->withErrors('errEdit');
  //   }

  // }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   *
   * @return Response
   */
  public function photoDestroy()
  {

    $id         = Input::get('id');
    $gallery_id = $this->photo->getDataById(Input::get('id'))->gallery->id;
    if ( ! empty( $this->photo->getDataById($id)->picture )) {
      $picture = $this->photo->getDataById($id)->picture;

      $picDirectory = base_path() . '/uploads/gallery/pictures';

      File::delete($picDirectory . '/' . $picture);

    }

    $success = "Successfully deleted picture";
    $error   = "Error! deleting Page";

    if ($this->photo->deleteData($id)) {
      return redirect(PREFIX.'/multicms/pages/gallery/lists?gallery_id=' . $gallery_id)->withErrors($success);
    } else {
      return redirect(PREFIX.'/multicms/pages/gallery/lists?gallery_id=' . $gallery_id)->withErrors($error);
    }


  }

  //methods for tbl_pages_lg

  /**
   * Display create form for managing Page and inserting tbl_pages_lg.
   *
   * @return Response
   */
  public function photoManage()
  {

    $flags                = $this->language->getAllDataNoPagination();
    $id                   = Input::get('picture_id');
    $photoLg              = $this->photoLg->getAllDataNoPagination();
    $photo                = $this->photo->getDataById($id);
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;

    return view('cms.modules.multicms.photosLg_addnew', compact('photo', 'flags', 'photoLg'), $data);
  }


  /**
   * Display add new form for uploading pictures.
   *
   * @return Response
   */
  public function addPicture()
  {

    $flags                = $this->language->getAllDataNoPagination();
    $id                   = Input::get('id');
    $page                 = $this->photoGallery->getDataById($id);
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;

    return view('cms.modules.multicms.photoGallery_addpic', compact('page', 'flags'), $data);
  }


  /**
   * store uploaded pictures.
   *
   * @return Response
   */
  public function storePicture()
  {

    if (Input::hasFile('files')) {
      $pictures = Input::get('files');

      foreach ($pictures as $picture) {

      }
      $directory    = base_path() . '/uploads/gallery/pictures';
      $originalName = InputHelpers::cleanURL(Input::file('cover_pic')->getClientOriginalName());
      $fileName     = uniqid() .'.'.Input::file('cover_pic')->getClientOriginalExtension();
      $fileNameDir  = $directory . '/' . $fileName;
      $image        = Image::make(Input::file('cover_pic'));
      $image->resize(200, null, function ($constraint) {
        $constraint->aspectRatio();
      });

      $image->save($fileNameDir, 100);
      $inputs['cover_pic'] = $fileName;

    }

    return view('cms.modules.multicms.photoGallery_addpic', compact('page', 'flags'), $data);
  }


  /**
   * Display create form for managing photos and inserting tbl_pictures_lg.
   *
   * @return Response
   */
  public function photosLgManage()
  {

    $langId = $this->language->getAllDataNoPagination()->pluck('id');
    $i      = 0;
    $len    = count($langId);
    foreach ($langId as $Lid) {
      if ( ! empty( Input::get('form.' . $Lid . '.id') )) {
        //update the existing row on tbl_page_lg table with reference to id.

        $inputs    = Input::get('form.' . $Lid);
        $id        = Input::get('form.' . $Lid . '.id');
        $validator = $this->photoLg->validateUpdate(Input::get('form.' . $Lid), $id);
        if ($validator->fails()) {
          Session::put('flag', Input::get('form.' . $Lid . '.language_id'));

          return redirect(PREFIX . '/multicms/pages/gallery/photoManage?picture_id=' . Input::get('form.' . $Lid . '.picture_id'))->withErrors($validator)->withInput();
        }

        if ($this->photoLg->updateData($inputs, $id)) {

          $inputs = "";
          if ($i == $len - 1) {
            // last iteration of foreach loop
            return redirect(PREFIX . '/multicms/pages/gallery/lists?gallery_id=' . $this->photo->getDataById(Input::get('form.' . $Lid . '.picture_id'))->gallery->id)->withErrors("successSetting");
          }

        } else {
          $inputs = "";

          return redirect(PREFIX . '/multicms/pages/gallery/lists?gallery_id=' . $this->photo->getDataById(Input::get('form.' . $Lid . '.picture_id'))->gallery->id)->withErrors('errEdit');
        }


      } else {
        //create new record in tbl_page_lg
        $inputs    = Input::get('form.' . $Lid);
        $validator = $this->photoLg->validate($inputs);
        if ($validator->fails()) {

          Session::put('flag', Input::get('form.' . $Lid . 'language_id'));

          return redirect(PREFIX . '/multicms/pages/gallery/photoManage?picture_id=' . Input::get('form.' . $Lid . 'picture_id'))->withErrors($validator)->withInput();
        }

        $this->photoLg->add($inputs);
        $inputs = "";
        if ($i == $len - 1) {
          // last iteration of foreach loop
          return redirect(PREFIX . '/multicms/pages/gallery/lists?gallery_id=' . $this->photo->getDataById(Input::get('form.' . $Lid . '.picture_id'))->gallery->id)->withErrors("successSetting");
        }


      }

      $i++;
    }

  }


}
