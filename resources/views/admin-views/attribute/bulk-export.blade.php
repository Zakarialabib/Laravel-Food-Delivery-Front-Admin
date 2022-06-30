@extends('layouts.admin.app')

@section('title','Food Bulk Export')

 
@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{trans('Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page"><a
                        href="{{route('admin.attribute.add-new')}}">{{__('attributes')}}</a>
                </li>
                <li class="breadcrumb-item">{{__('Bulk import')}} </li>
            </ol>
        </nav>


        <div class="card mt-2 rest-part">
            <div class="card-header">
                <h4>Export Attributes</h4>
            </div>
            <div class="card-body">
                <form class="product-form" action="{{route('admin.attribute.bulk-export')}}" method="POST"
                        enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlSelect1">{{__('Type')}}<span
                                        class="input-label-secondary"></span></label>
                                <select name="type" id="type" data-placeholder="{{__('Select type')}}" class="form-control" required title="Select Type">
                                    <option value="date_wise">{{__('Date wise')}}</option>
                                    <option value="id_wise">{{__('id wise')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group id_wise">
                                <label class="input-label" for="exampleFormControlSelect1">{{__('Start id')}}<span
                                        class="input-label-secondary"></span></label>
                                <input type="number" name="start_id" class="form-control">
                            </div>
                            <div class="form-group date_wise">
                                <label class="input-label" for="exampleFormControlSelect1">{{__('From date')}}<span
                                        class="input-label-secondary"></span></label>
                                <input type="date" name="from_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group id_wise">
                                <label class="input-label" for="exampleFormControlSelect1">{{__('End id')}}<span
                                        class="input-label-secondary"></span></label>
                                <input type="number" name="end_id" class="form-control">
                            </div>
                            <div class="form-group date_wise">
                                <label class="input-label text-capitalize" for="exampleFormControlSelect1">{{__('to date')}}<span
                                        class="input-label-secondary"></span></label>
                                <input type="date" name="to_date" class="form-control">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">{{__('Save')}}</button>
                    </div>
                </form>
            </div>
            <div class="card card-footer">
            </div>
        </div>
    </div>
@endsection

@push('script_2')
<script>
    $(document).on('ready', function (){
        $('.id_wise').hide();

        $('#type').on('change', function()
        {
            $('.id_wise').hide();
            $('.date_wise').hide();
            $('.'+$(this).val()).show();
        })
    });
</script>
@endpush
