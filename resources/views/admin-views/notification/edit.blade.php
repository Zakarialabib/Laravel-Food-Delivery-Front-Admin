@extends('layouts.admin.app')

@section('title',__('Update notification'))

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-notifications"></i> {{__('notification update')}}</h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="{{route('admin.notification.update',[$notification['id']])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{__('Title')}}</label>
                                <input type="text" value="{{$notification['title']}}" name="notification_title" class="form-control" placeholder="{{__('New notification')}}" required maxlength="191">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{__('Zone')}}</label>
                                <select name="zone" class="form-control js-select2-custom" >
                                    <option value="all" {{isset($notification->zone_id)?'':'selected'}}>{{__('All zone')}}</option>
                                    @foreach(\App\Models\Zone::orderBy('name')->get() as $z)
                                        <option value="{{$z['id']}}"  {{$notification->zone_id==$z['id']?'selected':''}}>{{$z['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="input-label" for="tergat">{{__('send to')}}</label>
                        
                                <select name="tergat" class="form-control" id="tergat" data-placeholder="{{__('Select tergat')}}" required>
                                    <option value="customer" {{$notification->tergat=='customer'?'selected':''}}>{{__('customer')}}</option>
                                    <option value="deliveryman" {{$notification->tergat=='deliveryman'?'selected':''}}>{{__('Deliveryman')}}</option>
                                    <option value="restaurant" {{$notification->tergat=='restaurant'?'selected':''}}>{{__('Restaurant')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="input-label" for="exampleFormControlInput1">{{__('description')}}</label>
                        <textarea name="description" class="form-control" required>{{$notification['description']}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>{{__('image')}}</label><small style="color: red">* ( {{__('ratio')}} 3:1 )</small>
                        <div class="custom-file">
                            <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                   accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                            <label class="custom-file-label" for="customFileEg1">{{__('Choose file')}}</label>
                        </div>
                        <hr>
                        <center>
                            <img style="width: 30%;border: 1px solid; border-radius: 10px;" id="viewer"
                                 src="{{asset('storage/app/public/notification')}}/{{$notification['image']}}"  onerror="src='{{asset('public/assets/admin/img/900x400/img1.jpg')}}'" alt="image"/>
                        </center>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                </form>
            </div>
            <!-- End Table -->
        </div>
    </div>

@endsection

@push('script_2')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });
    </script>
@endpush
