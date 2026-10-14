<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Photo;

class PhotosController extends Controller
{
    public function destroy(Photo $photos){
        $photos->delete();

    return redirect()->route("photos");
    }
}
