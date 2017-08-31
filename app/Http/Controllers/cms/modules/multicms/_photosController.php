<?php

namespace App\Http\Controllers\cms\modules\photos;

use Illuminate\Http\Request;
use App\Page;
use App\Services\PicturesService;
use App\Services\PicturesLgService;
use App\Services\LanguageService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\PhotoGallery;
use App\Pictures;
use Input;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use File;
use Image;
use DB;
use App\customHelper\InputHelpers;
use App\Services\DefaultLanguageService;

class photosController extends Controller
{

  public function __construct(
    PicturesService $pService,
    PicturesLgService $pLgService,
    LanguageService $language,
    DefaultLanguageService $defLang
  ) {

    $this->photoLg         = $pLgService;
    $this->photo           = $pService;
    $this->language        = $language;
    $this->defaultLanguage = $defLang;

  }


  public $thisPageId = 'Photos';

  public $thisModuleId = "photoGallery";


  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    return redirect(PREFIX . '/gallery');
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

    return view('cms.modules.photos.listall', $data);
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    $gallery_id           = Input::get('gallery_id');
    $gallery              = PhotoGallery::where('id', '=', $gallery_id)->first();
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;
    $flags                = $this->language->getAllDataNoPagination();

    return view('cms.modules.photos.addnew', compact('flags', 'gallery'), $data);

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
    $langId     = $this->language->getAllDataNoPagination()->pluck('id');
    $gallery_id = Input::get('form.photo.gallery_id');

    $defLang               = $this->defaultLanguage->getDefaultLang();
    $photoInput            = Input::get('form.photo');
    $photoInput['picture'] = Input::file('form.photo.picture');

    $validator = $this->photo->validate($photoInput);
    if ($validator->fails()) {
      return redirect(PREFIX . '/photos/create?gallery_id=' . $gallery_id)->withErrors($validator)->withInput();
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

        return redirect(PREFIX . '/pages/photos?gallery_id=' . $gallery_id)->withErrors($validator)->withInput();
      }

      // Store the pages details

      //save changes

      if ($this->photoLg->add($inputs)) {

        $inputs = "";
        if ($i == $len - 1) {
          // last iteration of foreach loop
          $data['msgSuccess'] = 'Successfully saved !!';

          return redirect(PREFIX . '/photos/lists?gallery_id=' . $gallery_id)->withErrors($data);
        }

      } else {
        $inputs           = "";
        $data['msgError'] = 'Changes could not be saved !!';

        return redirect(PREFIX . '/photos/lists?gallery_id=' . $gallery_id)->withErrors($data);
      }

      $i++;
    }

    // Store the pages details

    return redirect('cms/photos/lists?gallery_id=' . $id);

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
    $flags                = $this->language->getAllDataNoPagination();
    $data['id']           = Input::get('picture_id');
    $data['photo']        = Pictures::where('id', '=', $data['id'])->first();
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;

    return view('cms.modules.photos.photoslg.addnew', $data, $flags);
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

    $inputs = Input::all();
    $id     = Input::get('id');
    // dd($id);
    $validator = $this->photoGallery->validateUpdate($inputs, $id);
    if ($validator->fails()) {
      return redirect(PREFIX . '/photoGallery/edit?id=' . $id)->withErrors($validator)->withInput();
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
      return redirect('cms/photoGallery')->withErrors('edit');
    } else {
      return redirect('cms/photoGallery')->withErrors('errEdit');
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
      return redirect('cms/photos/lists?gallery_id=' . $gallery_id)->withErrors($success);
    } else {
      return redirect('cms/photos/lists?gallery_id=' . $gallery_id)->withErrors($error);
    }


  }

  //methods for tbl_pages_lg

  /**
   * Display create form for managing Page and inserting tbl_pages_lg.
   *
   * @return Response
   */
  public function manage()
  {

    $flags                = $this->language->getAllDataNoPagination();
    $id                   = Input::get('picture_id');
    $photoLg              = $this->photoLg->getAllDataNoPagination();
    $photo                = $this->photo->getDataById($id);
    $data['thisPageId']   = $this->thisPageId;
    $data['thisModuleId'] = $this->thisModuleId;

    return view('cms.modules.photos.photosLg.addnew', compact('photo', 'flags', 'photoLg'), $data);
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

    return view('cms.modules.photoGallery.addpic', compact('page', 'flags'), $data);
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

    return view('cms.modules.photoGallery.addpic', compact('page', 'flags'), $data);
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

          return redirect(PREFIX . '/photos/manage?picture_id=' . Input::get('form.' . $Lid . '.picture_id'))->withErrors($validator)->withInput();
        }

        if ($this->photoLg->updateData($inputs, $id)) {

          $inputs = "";
          if ($i == $len - 1) {
            // last iteration of foreach loop
            return redirect(PREFIX . '/photos/lists?gallery_id=' . $this->photo->getDataById(Input::get('form.' . $Lid . '.picture_id'))->gallery->id)->withErrors("successSetting");
          }

        } else {
          $inputs = "";

          return redirect(PREFIX . '/photos/lists?gallery_id=' . $this->photo->getDataById(Input::get('form.' . $Lid . '.picture_id'))->gallery->id)->withErrors('errEdit');
        }


      } else {
        //create new record in tbl_page_lg
        $inputs    = Input::get('form.' . $Lid);
        $validator = $this->photoLg->validate($inputs);
        if ($validator->fails()) {

          Session::put('flag', Input::get('form.' . $Lid . 'language_id'));

          return redirect(PREFIX . '/photos/manage?picture_id=' . Input::get('form.' . $Lid . 'picture_id'))->withErrors($validator)->withInput();
        }

        $this->photoLg->add($inputs);
        $inputs = "";
        if ($i == $len - 1) {
          // last iteration of foreach loop
          return redirect(PREFIX . '/photos/lists?gallery_id=' . $this->photo->getDataById(Input::get('form.' . $Lid . '.picture_id'))->gallery->id)->withErrors("successSetting");
        }


      }

      $i++;
    }

  }


}
