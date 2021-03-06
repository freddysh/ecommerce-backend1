<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_view()
    {
        //
        return view('admin.categories.index');
    }

    public function index()
    {
        //

        return Category::get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validated=$request->validate([
            'name'=>'required|unique:categories',
            'description'=>'required',
            'photo'=>'required',
            'father_id'=>'required',
            'state'=>'required',
        ]);
        $category=new Category();
        $category->name=$request->name;
        $category->description=$request->description;
        $category->photo='';
        $category->father_id=$request->father_id;
        $category->state=1;
        $category->save();
        $imagen=$request->photo;
        if ($imagen) {
            $imagen_explode = explode(',', $imagen);
            $imagen_decode = base64_decode($imagen_explode[1]);
            // $photo = IImage::make($imagen)
            // ->resize(150, 150, function ($constraint) { $constraint->aspectRatio(); } )
            // ->encode('jpg');
            $src =  'photo_' . $category->id . '.jpg';
            $path=  url("").'/storage/app/public/category/'.$src;
            Storage::disk('category')->put($src, $imagen_decode);
            $category->photo=$src;
            $category->save();
        }

        return response()->json(['state'=>'1']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
        $validated=$request->validate([
            'name'=>'required',
            'description'=>'required',
            'photo'=>'required',
            'father_id'=>'required',
            'state'=>'required',
        ]);
        // $category= Category::findOrfail($category_->id);
        $category->name=$request->name;
        $category->description=$request->description;
        // $category->photo='';
        $category->father_id=$request->father_id;
        $category->state=$request->state;
        $category->save();

        $imagen=$request->photo;
        if ($imagen) {
            $imagen_explode = explode(',', $imagen);
            if(count($imagen_explode)>1){
                $imagen_decode = base64_decode($imagen_explode[1]);
                $src =  'photo_' . $category->id . '.jpg';
                $path=  url("").'/storage/app/public/category/'.$src;

                // $photo = IImage::make($imagen)
                // ->resize(150, 150, function ($constraint) { $constraint->aspectRatio(); } )
                // ->encode('jpg');
                Storage::disk('category')->put($src,  $imagen_decode);
                $category->photo=$src;
                $category->save();
            }
        }
        else{
            $category->photo='';
            $category->save();
            Storage::disk('category')->delete($imagen);
        }

        return response()->json(['state'=>'1']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        $objeto= Category::findorfail($category->id);
        $objeto->delete();
        return response()->json(['status'=>'1']);
    }
    public function get_imagen($filename)
    {
        $file = Storage::disk('category')->get($filename);
        return response($file, 200);
    }
}
