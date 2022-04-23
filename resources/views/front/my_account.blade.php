<x-my_account-master>
@section('content')
<div class="col-lg-9">
<div class="tab-pane fade show active"  id="v-pills-account" role="tabpanel"
                                aria-labelledby="v-pills-settings-tab">
                                <div class="my-account-content">
                                    <h4>Account Details</h4>
                                    <form method="post" action="{{route('customer.profile_update',$customer->id)}}">
                                    @csrf
                                    @method('PATCH')

                                    @if(Session::get('success'))
                                    <div class="alert alert-success">
                                        {{Session::get('success')}}
                                    </div>
                                    @endif
                                        <div class="form-row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="first_name" placeholder="First Name" value="{{$customer['first_name']}}">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="{{$customer['last_name']}}">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="email" placeholder="Email" value="{{$customer['email']}}">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="mobile" placeholder="Mobile" value="{{$customer['mobile']}}">
                                                </div>
                                                <div class="form-group  mb-0">
                                                    <button class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
         
</div>
@endsection('content')

@section('javascript')
@parent
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@2.8.2/dist/alpine.min.js"></script>
<script>
$("document").ready(function(){
setTimeout(function(){
$("div.alert").remove();
}, 3000 ); // 3 sec
});
</script>
@stop
</x-my_account-master>