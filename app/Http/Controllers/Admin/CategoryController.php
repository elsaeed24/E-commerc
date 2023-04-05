<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $categories = Category::when($request->name, function($query, $value) {

        //         $query->where('name', 'LIKE', "%{$value}%")
        //             ->orWhere('description', 'LIKE', "%{$value}%");

        // })
        // ->when($request->parent_id, function($query, $value) {
        //     $query->where('parent_id', '=', $value);
        // })
        /*->leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
        ->select([
            'categories.*',
            'parents.name as parent_name'
        ])*/
        // Eager loading
        // ->with('parent')
        // ->withoutGlobalScope(ActiveStatusScope::class)
        // ->get();
        //     $parents = Category::orderBy('name', 'asc')->get();

        $categories = Category::with('parent')->get();


            return view('admin.categories.index',[

                    'categories' => $categories,
                    // 'parents' => $parents,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::orderBy('name', 'asc')->get();
        return view('admin.categories.create', [
            'parents' => $parents,
            'category' => new Category(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {

       // $data = $request->all();

          // Request Merge
          $request->merge([   // use to filed not exist in request
            'slug' => Str::slug($request->post('name'))
           ]);

           $data = $request->except('image');

           $data['image'] = uploadImage($request,'image','Categories');

           Category::create($data);

              //PRG  post redirect get
                return redirect()
                ->route('categories.index')
                ->with('success', 'Category Created'); // flash message

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {

        $parents = Category::orderBy('name', 'asc')->get();
        return view('admin.categories.edit', compact('category','parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $old_image = $category->image;

        $data = $request->except('image');

        $new_image = uploadImage($request,'image','Categories');
        if($new_image){
            $data['image']  = $new_image;
        }

        $category->update($data);

        if($old_image && $new_image){     // isset () is exists and null return false
            Storage::disk('uploads')->delete($old_image);
           }

       //PRG  post redirect get
       return redirect()
       ->route('categories.index')
       ->with('success', 'Category Updated'); // flash message


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $old_image = $category->image;

        // Delete Old Image
        if($old_image ){
            Storage::disk('uploads')->delete($old_image);
        }

        $category->delete();

          //PRG  post redirect get
       return redirect()
       ->route('categories.index')
       ->with('success', 'Category Deleted'); // flash message
    }
}
