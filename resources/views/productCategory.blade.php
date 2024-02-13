@include('partials.layoutHead')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @if(request()->routeIs('user-product-category'))
            @include('user.partials.sidebar')
        @else
            @include('partials.sidebar')
        @endif

        <div class="layout-page">
            @include('partials.navbar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y text-center">

                    <div class="card">
                        <h5 class="card-header">Product Category</h5>
                        <div class="table-responsive text-nowrap">
                            @include('error')
                            @include('success')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl">
                                        <div class="card mb-4">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">Add new category</h5>
                                            </div>
                                            <div class="card-body">
                                                <form method="POST" action="{{route('add-category')}}" enctype="multipart/form-data">
                                                    {{csrf_field()}}
                                                    <div class="mb-3">
                                                        <label class="form-label" for="basic-default-fullname">Name</label>
                                                        <input name="name" type="text" class="form-control" id="basic-default-fullname" placeholder="Category Name...">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="basic-default-company">Slug</label>
                                                        <input type="text" name="slug" class="form-control" id="basic-default-company">
                                                    </div>
                                                    <div class="input-group">
                                                        <label class="input-group-text" for="inputGroupSelect01">Parent</label>
                                                        <select name="parent" class="form-select" id="inputGroupSelect01">
                                                            <option selected="">Choose...</option>
                                                            @foreach($categoriesWithSubcategories as $category)
                                                            <option value="{{$category->id}}"><strong>{{$category->name}}</strong></option>
                                                                @foreach($category->subcategories as $subcategory)
                                                                    <option class="ml-2" value="{{$subcategory->id}}">{{$subcategory->name}}</option>
                                                                @endforeach
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="basic-default-message">Description</label>
                                                        <textarea name="description" id="basic-default-message" class="form-control"></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="basic-default-company">Group of</label>
                                                        <input type="text" name="group_of_quantity" class="form-control" id="basic-default-company">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <label class="input-group-text" for="inputGroupSelect01">Display Type</label>
                                                        <select class="form-select" id="inputGroupSelect01">
                                                            <option selected="">Default</option>
                                                            <option selected="">Products</option>
                                                            <option selected="">Subcategories</option>
                                                            <option selected="">Both</option>
                                                        </select>
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <label class="input-group-text" for="inputGroupFile01">Thumbnail</label>
                                                        <input name="thumbnail" type="file" class="form-control" id="inputGroupFile01">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Send</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl">
                                        <form method="POST" action="{{route('search-category')}}">
                                            {{csrf_field()}}
                                            <div class="input-group input-group-merge">
                                                <div class="input-group">
                                                    <input name="name" type="text" class="form-control p-4" placeholder="Search...">
                                                    <button type="submit" class="btn btn-outline-primary"><i class='bx bx-search'></i></button>
                                                </div>
                                            </div>

                                        </form>
                                        <div class="card mb-4">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">All Category</h5>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>Category</th>
                                                        <th>Description</th>
                                                        <th>Slug</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="table-border-bottom-0">
                                                            @foreach($categoriesWithSubcategories as $category)

                                                                <tr>
                                                                    <td class="text-left">
                                                                        <strong>{{$category->name}}</strong><br>

                                                                        <table class="table table-hover ml-3 mt-2">
                                                                            <thead>
                                                                                <tr>

                                                                                </tr>
                                                                                <tbody>
                                                                            @foreach($category->subcategories as $subcategory)
                                                                                    <tr>
                                                                                        <td>{{$subcategory->name}}</td>
                                                                                        <td>{{$subcategory->description}}</td>
                                                                                        <td>{{$subcategory->slug}}</td>
                                                                                        <td>
                                                                                            <div class="d-flex" >
                                                                                                <a class="dropdown-item" style="font-size:12px " href=""><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                                                                                <a class="dropdown-item" style="font-size:12px " href=""><i class="bx bx-trash me-1"></i> Delete</a>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                            @endforeach
                                                                                </tbody>
                                                                            </thead>
                                                                        </table>

                                                                    </td>
                                                                    <td>
                                                                        <p>
                                                                            @if($category->description == null or 'undefined')
                                                                                ---
                                                                            @else
                                                                                {!! $category->descrrtiption !!}
                                                                            @endif
                                                                        </p>
                                                                    </td>
                                                                    <td>
                                                                        {{$category->slug}}
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex" >
                                                                            <a class="dropdown-item" style="font-size:12px " href=""><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                                                            <a class="dropdown-item" style="font-size:12px " href=""><i class="bx bx-trash me-1"></i> Delete</a>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                            @endforeach
{{--                                                            {{$categories->links()}}--}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@include('partials.layoutEnd')
