@extends('layouts.admin.app')

@section('title',__('Add new sub category'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i
                            class="tio-add-circle-outlined"></i> {{__('Add new sub_category')}}
                    </h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-header">
                <h5>{{isset($category)?__('Update'):__('Add').' '.__('new sub_category')}}</h5>
            </div>
            <div class="card-body">
                <form action="{{isset($category)?route('admin.category.update',[$category['id']]):route('admin.category.store')}}" method="post">
                @csrf
                @php($language=\App\Models\BusinessSetting::where('key','language')->first())
                @php($language = $language->value ?? null)
                @php($default_lang = 'en')
                @if($language)
                    @php($default_lang = json_decode($language)[0])
                    <ul class="nav nav-tabs mb-4">
                        @foreach(json_decode($language) as $lang)
                            <li class="nav-item">
                                <a class="nav-link lang_link {{$lang == $default_lang? 'active':''}}" href="#" id="{{$lang}}-link">{{\App\CentralLogics\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                            </li>
                        @endforeach
                    </ul>
                    @foreach(json_decode($language) as $lang)
                        <div class="form-group {{$lang != $default_lang ? 'd-none':''}} lang_form" id="{{$lang}}-form">
                            <label class="input-label" for="exampleFormControlInput1">{{__('Name')}} ({{strtoupper($lang)}})</label>
                            <input type="text" name="name[]" class="form-control" placeholder="{{__('New category')}}" maxlength="191" {{$lang == $default_lang? 'required':''}} oninvalid="document.getElementById('en-link').click()">
                        </div>
                        <input type="hidden" name="lang[]" value="{{$lang}}">
                    @endforeach
                @else
                    <div class="form-group">
                        <label class="input-label" for="exampleFormControlInput1">{{__('Name')}}</label>
                        <input type="text" name="name" class="form-control" placeholder="{{__('New category')}}" value="{{old('name')}}" required maxlength="191">
                    </div>
                    <input type="hidden" name="lang[]" value="{{$lang}}">
                @endif
                    <div class="form-group">
                        <label class="input-label"
                            for="exampleFormControlSelect1">{{__('main category')}}
                            <span class="input-label-secondary">*</span></label>
                        <select id="exampleFormControlSelect1" name="parent_id" class="form-control js-select2-custom" required>
                            @foreach(\App\Models\Category::where(['position'=>0])->get() as $cat)
                                <option value="{{$cat['id']}}" {{isset($category)?($category['parent_id']==$cat['id']?'selected':''):''}} >{{$cat['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input name="position" value="1" style="display: none">
                    <button type="submit" class="btn btn-primary">{{isset($category)?__('Update'):__('Add')}}</button>
                </form>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header pb-0">
                <h5>{{__('Sub Category list')}}<span class="badge badge-soft-dark ml-2" id="itemCount">{{$categories->total()}}</span></h5>
                <form id="dataSearch">
                    <!-- Search -->
                    <div class="input-group input-group-merge input-group-flush">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tio-search"></i>
                            </div>
                        </div>
                        <input type="hidden" name="sub_category" value="1">
                        <input id="datatableSearch" name="search" type="search" class="form-control" placeholder="{{__('Search sub categories')}}" aria-label="{{__('Search sub categories')}}">
                        <button type="submit" class="btn btn-primary">{{__('Search')}}</button>
                    </div>
                    <!-- End Search -->
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive datatable-custom">
                    <table id="columnSearchDatatable"
                        class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        style="width: 100%;"
                        data-hs-datatables-options='{
                            "search": "#datatableSearch",
                            "entries": "#datatableEntries",
                            "isResponsive": false,
                            "isShowPaging": false,
                            "paging":false,
                        }'>
                        <thead class="thead-light">
                            <tr>
                                <th>{{__('#')}}</th>
                                <th>{{__('id')}}</th>
                                <th>{{__('main category')}}</th>
                                <th>{{__('Sub category')}} </th>
                                <th >{{__('status')}}</th>
                                <th >{{__('priority')}}</th>
                                <th >{{__('Action')}}</th>
                            </tr>
                        </thead>

                        <tbody id="table-div">
                        @foreach($categories as $key=>$category)
                            <tr>
                                <td>{{$key+$categories->firstItem()}}</td>
                                <td>{{$category->id}}</td>
                                <td>
                                    <span class="d-block font-size-sm text-body">
                                        {{Str::limit($category->parent['name'],20,'...')}}
                                    </span>
                                </td>
                                <td>
                                    <span class="d-block font-size-sm text-body">
                                        {{Str::limit($category->name,20,'...')}}
                                    </span>
                                </td>
                                <td>
                                    <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox{{$category->id}}">
                                    <input type="checkbox" onclick="location.href='{{route('admin.category.status',[$category['id'],$category->status?0:1])}}'"class="toggle-switch-input" id="stocksCheckbox{{$category->id}}" {{$category->status?'checked':''}}>
                                        <span class="toggle-switch-label">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                </td>
                                <td style="width:max-content;">
                                    <form action="{{route('admin.category.priority',$category->id)}}">
                                    <select name="priority" id="priority" onchange="this.form.submit()"> 
                                        <option value="0" {{$category->priority == 0?'selected':''}}>{{__('normal')}}</option>
                                        <option value="1" {{$category->priority == 1?'selected':''}}>{{__('medium')}}</option>
                                        <option value="2" {{$category->priority == 2?'selected':''}}>{{__('high')}}</option>
                                    </select>
                                    </form>
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-white"
                                        href="{{route('admin.category.edit',[$category['id']])}}" title="{{__('edit category')}}"><i class="tio-edit"></i>
                                    </a>
                                    <a class="btn btn-sm btn-white" href="javascript:"
                                    onclick="form_alert('category-{{$category['id']}}','Want to delete this category')" title="{{__('delete category')}}"><i class="tio-delete-outlined"></i>
                                    </a>
                                    <form action="{{route('admin.category.delete',[$category['id']])}}" method="post" id="category-{{$category['id']}}">
                                        @csrf @method('delete')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer page-area">
                <!-- Pagination -->
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center"> 
                    <div class="col-sm-auto">
                        <div class="d-flex justify-content-center justify-content-sm-end">
                            <!-- Pagination -->
                            {!! $categories->links() !!}
                        </div>
                    </div>
                </div>
                <!-- End Pagination -->
            </div>
        </div>
    </div>
@endsection

@push('script_2')
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            

            $('#dataSearch').on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post({
                    url: '{{route('admin.category.search')}}',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#loading').show();
                    },
                    success: function (data) {
                        $('#table-div').html(data.view);
                        $('#itemCount').html(data.count);
                        $('.page-area').hide();
                    },
                    complete: function () {
                        $('#loading').hide();
                    },
                });
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>
    <script>
        $(".lang_link").click(function(e){
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.split("-")[0];
            console.log(lang);
            $("#"+lang+"-form").removeClass('d-none');
            if(lang == '{{$default_lang}}')
            {
                $(".from_part_2").removeClass('d-none');
            }
            else
            {
                $(".from_part_2").addClass('d-none');
            }
        });
    </script>
@endpush
