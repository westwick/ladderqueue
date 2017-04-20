<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Auth;
use App\User;
use Image;

class ImageController extends Controller
{
    public function profile_image_upload()
    {
        try{
            $input = Input::all();
            $file = $input['img'];
            $size = filesize($file);
            $user = Auth::user();
            if (!$size || $size == 0 || $size > 8000000) {
                throw new Exception('File size too large - please try a smaller file.');
            }
            $local_path = '/uploads/tmp/upload_' . $user['id'] . '_' . time() . '.jpg';

            $image = Image::make($file->getRealPath());
            $width = $image->width();
            $height = $image->height();
            $image->save(public_path() . $local_path);

            $return = array(
                'status' => 'success',
                'url'    => $local_path,
                'width'  => $width,
                'height' => $height
            );
        } catch(exception $e) {
            return response()->json(array('status' => 'error', 'message' => $e->getMessage()));
        }

        return response()->json($return);
    }

    public function user_profile_image_save()
    {
        $input = Input::all();
        $user = Auth::user();

        $local_path = public_path().$input['imgUrl'];
        $new_path = '/uploads/images/team_' . time() . '.jpg';
        //$s3_prefix = $GLOBALS['env']!='production'?'/dev':'';
        //$s3_path = $s3_prefix.'/users/user_' . $user->id . '_' . time() . '.jpg';

        $image = Image::make($local_path);
        $image->resize(intval($input['imgW']), intval($input['imgH']));
        $image->crop(intval($input['cropW']), intval($input['cropH']), intval($input['imgX1']), intval($input['imgY1']));
        $image->resize(250,250);
        $image->save(public_path() . $new_path);

        // delete temp file
        unlink($local_path);

        $return = array(
            'status' => 'success',
            'url' => $new_path
        );

        return response()->json($return);

    }
}
