<x-my_account-master>
@section('change_password')
<div class="col-lg-9">
<div class="tab-pane fade show " id="v-pills-password" role="tabpanel"
                                aria-labelledby="v-pills-settings-tab">
                                <div class="my-account-content">
                                    <h4>Change Password</h4>
                                   <form action="{{route('customer.change_password')}}" method="post" class="needs-validation" novalidate enctype="multipart">
                                    @csrf
                                    @if(Session::get('success'))
                                          <div class="alert alert-success" role="alert"> 
                                             {{ Session::get('success') }} 
                                           </div>
                                        @endif

                                       
                                   <div class="form-row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <input type="password" class="form-control" name="current_password"
                                                        placeholder="Current Password">
                                                        @if ($errors->has('current_password'))
                                    <span class="help-block" style="color:red">
                                       {{ $errors->first('current_password') }}
                                    </span>
                                @endif
                                                        
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" class="form-control" name="new_password" placeholder="New Password">
                                                    @if ($errors->has('new_password'))
                                    <span class="help-block" style="color:red">
                                        {{ $errors->first('new_password') }}
                                    </span>
                                @endif
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" class="form-control" name="new_confirm_password"
                                                        placeholder="Confirm New Password">
                                                        @if ($errors->has('new_confirm_password'))
                                    <span class="help-block" style="color:red">
                                      {{ $errors->first('new_confirm_password') }}
                                    </span>
                                @endif
                                                </div>
                                                <div class="form-group  mb-0">
                                                    <button class="btn btn-primary">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
</div>

@endsection('change_password')
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