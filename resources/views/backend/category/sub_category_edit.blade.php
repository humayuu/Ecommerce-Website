@extends('admin.admin_master')

@section('main')
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">

                {{-- _________________ Edit Category Page________________ --}}

                <div class="col-8">

                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit SubCategory</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <form method="POST" action="{{ route('subcategory.update') }}">
                                    <input type="hidden" name="id" value="{{ $subCategories->id }}">
                                    @csrf
                                    <div class="form-group">
                                        <h5>Category Select<span class="text-danger">*</span></h5>
                                        <select name="category_id" class="form-control">
                                            <option value="" selected disabled>Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ ($category->id == $subCategories->category_id) ? 'selected' : null ; }}>{{ $category->category_name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <h5>SubCategory Name English<span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="subcategory_name_en" class="form-control" value="{{ $subCategories->subcategory_name_en }}">
                                            @error('subcategory_name_en')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <h5>SubCategory Name Urdu<span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="subcategory_name_urdu" class="form-control"  value="{{ $subCategories->subcategory_name_urdu }}">
                                            @error('subcategory_name_urdu')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="text-xs-right">
                                        <input type="submit" class="btn btn-rounded btn-primary mb-5" value="Update">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
    </div>
@endsection
