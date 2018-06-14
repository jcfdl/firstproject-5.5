<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class AdminMediasController extends Controller
{
	public function index() {
		$photos = Photo::all();
    	return view('admin.media.index', compact('photos'));
	}

	public function create() {
		return view('admin.media.create');
	}    

	public function store(Request $request) {
		$file = $request->file('file');
		$name = time() . $file->getClientOriginalName();
		$file->move('images', $name);

		Photo::create(['path'=>$name]);
	}

	public function destroy($id) {
		$photo = Photo::findOrFail($id);
		$photo->delete();
		Session::flash('deleted_image', 'The image has been deleted!');
		return redirect('admin/media');
	}
}
