<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    //Function for View Sub Category
    public function SubCategoryView()
    {
        $categories = Category::orderBy('category_name_en', 'ASC')->get();
        $subCategories = SubCategory::latest()->get();
        return view('backend.category.sub_category_view', compact('subCategories', 'categories'));
    }

    // Function for Store Sub Category
    public function SubCategoryStore(Request $request)
    {

        $request->validate([
            'category_id' => 'required',
            'subcategory_name_en' => 'required',
            'subcategory_name_urdu' => 'required',
        ], [
            'category_id.required' => 'Please Select Any Option',
            'subcategory_name_en.required' => 'Input SubCategory English Name',
            'subcategory_name_urdu.required' => 'Input SubCategory Urdu Name',
        ]);


        SubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name_en' => $request->subcategory_name_en,
            'subcategory_name_urdu' => $request->subcategory_name_urdu,

            'subcategory_slug_en' => strtolower(str_replace(' ', '-', $request->subcategory_name_en)),
            'subcategory_slug_urdu' => str_replace(' ', '-', $request->subcategory_name_urdu),
        ]);

        $notification = [
            'message' => 'SubCategory inserted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    // Function for Edit Sub Category
    public function SubCategoryEdit($id)
    {
        $categories = Category::orderBy('category_name_en', 'ASC')->get();
        $subCategories = SubCategory::findOrFail($id);
        return view('backend.category.sub_category_edit', compact('subCategories', 'categories'));
    }

    // Function for Update Sub Category
    public function SubCategoryUpdate(Request $request)
    {
        $subCategory = $request->id;


        $request->validate([
            'category_id' => 'required',
            'subcategory_name_en' => 'required',
            'subcategory_name_urdu' => 'required',
        ], [
            'category_id.required' => 'Please Select Any Option',
            'subcategory_name_en.required' => 'Input SubCategory English Name',
            'subcategory_name_urdu.required' => 'Input SubCategory Urdu Name',
        ]);


        SubCategory::findOrFail($subCategory)->update([
            'category_id' => $request->category_id,
            'subcategory_name_en' => $request->subcategory_name_en,
            'subcategory_name_urdu' => $request->subcategory_name_urdu,

            'subcategory_slug_en' => strtolower(str_replace(' ', '-', $request->subcategory_name_en)),
            'subcategory_slug_urdu' => str_replace(' ', '-', $request->subcategory_name_urdu),
        ]);

        $notification = [
            'message' => 'SubCategory Update Successfully',
            'alert-type' => 'info'
        ];

        return redirect()->route('all.subcategory')->with($notification);
    }

    // Function for Delete Sub Category
    public function SubCategoryDelete($id)
    {
        SubCategory::findOrFail($id)->delete();

        $notification = [
            'message' => 'Sub Category Deleted Successfully',
            'alert-type' => 'error'
        ];

        return redirect()->back()->with($notification);
    }
}
