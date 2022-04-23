<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
   <link rel="icon" type="image/png" href="{{asset('assets/images/favicon.png')}}">
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">
    <title>FoodDay - Cart</title>
    @livewireStyles
</head>

<body>

     <!-- header -->
     <header>
        <div class="container-fluid">
            <nav id="navbar_top" class="navbar navbar-expand-lg navbar-light fixed-top">
                <a class="navbar-brand" href="home.html"><img src="assets/images/logo.png" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="{{route('customer.my_home')}}">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="{{route('restaurant_listing')}}">Restaurants</a>
                        </li> -->

                       

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('customer.account')}}">
                                <i class='bx bx-user mr-1'></i>
                                My Account</a>
                        </li>
                        <livewire:cart-count />
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <!-- Header -->

    <div class="search-nav">
        <div class="container">
            <h3 class="mb-0">Checkout</h3>
        </div>
    </div>

    <section class="py-60">
        <div class="container">
        <form method="post" action="/customer/order/store" enctype="multipart/form-data" >
            @csrf
            <div class="row cuisine-dish-wrap">
                <div class="col-lg-8 cuisine-col">

                    
                       
                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <h6 class="checkout-title">Delivery Type</h6>
                                    <select class="form-control " name="delivery_method" id="select" onchange="status(this)">
                                        <option value="delivery" selected="delivery">Delivery</option>
                                        <option value="pickup">Pickup</option>
                                    </select>
                                </div>
                            </div>
                            <h6 class="checkout-title">Payment</h6>
                            <div class="form-group col-lg-12">
                                <div class="custom-radio">
                                    <input type="radio" id="radio1" name="payment-type" checked="checked">
                                    <label for="radio1">Pay via Cash</label>
                                    <img src="{{asset('assets/images/cash.png')}}" alt="Icon">
                                </div>
                             </div>

         

                    <div class="checkout-delivery-address food-item-cards-wrap" id="sub1">
                        <h6 class="checkout-title">Delivery Address</h6>
                          <div class="row">
                            @foreach($address as $add)
                           
                           
                            <div class="col-xl-6">
                                <div class="card address-card">
                                    <div class="card-body deliverable">
                                        <div class="delivery">
                                        @if($add->default==1)
                                            <i class='bx bxs-check-circle'></i>
                                          
                                        @endif
                                        
                                            <h5 class="card-title">{{$add->home}}</h5>
                                        </div>
                                        <h6>{{$add->location}}, {{$add->pincode}}</h6>
                                        <p class="card-text">
                                           {{$add->landmark}}
                                          
                                        </p>
                                        @if(!session('address'))
                                        <button class="btn btn-primary btn-sm"><a href="{{route('customer.addressStore',$add->id)}} "style="color:white">Deliver here</a></button>
                                        @else
                                          
                                      
                                        <button class="btn btn-primary btn-sm"><a href="{{route('customer.addressStore',$add->id)}} "style="color:white">Delivered here</a></button>
                                        
                                        @endif
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="edit-item" data-toggle="modal"
                                            data-target="#exampleModal{{$add->id}}">
                                            Edit</button>   {{session()->get('location')}}
                                        <button class="btn btn-outline-primary btn-sm">
                                            <a href="{{route('customer.address_destroy', $add->id)}}"> Delete</a></button>
                                            
                                    </div>
                                </div>
                            </div>
                          
                            <!-- <div class="col-xl-6">
                                <div class="card address-card">
                                    <div class="card-body unavailable">
                                        <div class="delivery ">
                                            <i class='bx bxs-x-circle'></i>
                                            <h5 class="card-title">{{$add->home}}</h5>
                                        </div>
                                        <h6>{{$add->location}}, {{$add->pincode}}</h6>
                                        <p class="card-text">
                                           {{$add->landmark}}
                                          
                                        </p>
                                        <button class="btn btn-outline-primary btn-sm">Does not deliver here</button>
                                    </div>
                                </div>
                            </div> -->
                           
                            
                    @endforeach
                           
                        </div>

                        <button type="button" class="btn btn-outline-primary mb-lg-auto mb-4" data-toggle="modal"
                        data-target="#exampleModal">Add New Address</button>
                                     
                       </div>
                      
                    @if('delvery_method' !='delivery')
                      <div class="checkout-delivery-address" id="pick1">
                        <h6 class="checkout-title">Pick up</h6>

                        @if(session('restaurant'))                    
                        
                       
                       
                        <p>This is a Pickup order. You'll need to go to
                            <strong>{{ session('restaurant')['name'] }}</strong> to
                            pick up this order.
                            Pick up at <strong>{{ session('restaurant')['location'] }}</strong>.{{ session('restaurant')['addess'] }}
                            <strong>{{ session('restaurant')['mobile'] }}</strong> </p>
                           
                          @endif 
                      
                    </div>
                    @endif
                      </div>

                   

                              
                <div class="col-lg-4 cart-col">
                    <div class="cart d-none d-md-block">
                        <div class="cart-head">
                            <span>Your order</span>
                        </div>
                            @php $total = 0 @endphp
        @if(session('cart'))
            @foreach(session('cart') as $id => $details)
           
                @php
                 $total=0;
                 $total += $details['rate'] * $details['quantity'] 
                 @endphp
                        <div class="cart-body">
                            <div class="cart-item">
                                <div class="details">
                                    <h6> {{ $details['food_item'] }}</h6>
                                  
                                   
                                </div>
                                <div class="price">
                                    <h6>${{ $total }}.00</h6>
                                  
                                </div>
                            </div>

                        </div>
                @endforeach
                            @endif
                        <div class="cart-footer">
                              @php $total = 0 @endphp
                            @foreach((array) session('cart') as $id => $details)
                                @php $total += $details['rate'] * $details['quantity'] @endphp
                               
                            @endforeach
                            <ul>
                                <li>
                                    <h5>
                                        <span>SubTotal</span>
                                        <span class="float-right">${{$total}}.00</span>
                                    </h5>
                                </li>
                                <li>
                                    <p>
                                        <span>Delivery fee</span>
                                        <span class="float-right">$00.00</span>
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        <span>Tax</span> <span class="float-right">$00.00</span>
                                    </p>
                                </li>
                                <li>
                                    <h4>
                                        <span>Total</span>
                                        <span class="float-right">${{$total}}.00</span>
                                    </h4>
                                
                                </li>
                                <li>
                                    <p>
                                         <span>Please keep the exact change for <b>${{$total}}</b> handy to help us serve you better.</span>

                                    </p>
                                </li>
                                
                                   
                                <button class="btn btn-primary mt-3 w-100"
                                    onclick="window.location.href='{{route('customer.order')}}';">Checkout</button>
                                     
                                   

                                
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            </form>
        </div>
    </section>



    <!-- Address Modal -->
    <div class="modal fade address-model" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="bx bx-x btn-close"></i>
                                </button>
                                <h5 class="mb-4">Add Delivery Address</h5>
                                @section('content')
                                @if(Session::has('success'))
                                    <div class="alert alert-success">
                                        {{ Session::get('success') }}
                                        @php
                                            Session::forget('success');
                                        @endphp
                                    </div>
                                    @endif
                                <form method="post" action="{{route('customer.address_store')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">

                                        <div class="form-group col-lg-12">
                                            <input type="text" name="location" class="form-control" placeholder="Location">
                                            @if ($errors->has('location'))
                                                <span class="text-danger">{{ $errors->first('location') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <input type="text" name="house_name"class="form-control" placeholder="House Name/Flat No/Building">
                                            @if ($errors->has('house_name'))
                                                <span class="text-danger">{{ $errors->first('house_name') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input type="text" name="area" class="form-control" placeholder="Area/Street">
                                            @if ($errors->has('area'))
                                                <span class="text-danger">{{ $errors->first('area') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input type="text" name="city" class="form-control" placeholder="City">
                                            @if ($errors->has('city'))
                                                <span class="text-danger">{{ $errors->first('city') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <input type="text" name="landmark" class="form-control" placeholder="Landmark">
                                            @if ($errors->has('landmark'))
                                                <span class="text-danger">{{ $errors->first('landmark') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input type="text" name="pincode" class="form-control" placeholder="Pincode">
                                            @if ($errors->has('pincode'))
                                                <span class="text-danger">{{ $errors->first('pincode') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <select name="home" id="home" class="form-control" >

                                                <option value="0" disabled selected >Address Type</option>

                                                <option value="Home" >Home</option>

                                                <option value="Office" >Office</option>

                                                <option value="Other" >Other</option>

                                            </select>                                     
                                            @if ($errors->has('home'))
                                                <span class="text-danger">{{ $errors->first('home') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <input type="text" name="note_a_driver" id="note_a_driver" class="form-control" placeholder="Note for Driver">
                                            @if ($errors->has('note_a_driver'))
                                                <span class="text-danger">{{ $errors->first('note_a_driver') }}</span>
                                            @endif
                                        </div>
                                        

                                        <div class="form-group col-md-6 mb-md-0 d-none d-md-block">
                                            <button type="button" class="btn btn-outline-primary w-100"
                                                data-dismiss="modal" aria-label="Close">Close</button>
                                        </div>
                                        <div class="form-group col-md-6 mb-0">
                                            <button class="btn btn-secondary w-100">Save changes</button>
                                        </div>

                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                 <!-- Address EDIT Modal -->
                 @foreach($address as $value)
                <div class="modal fade  " id="exampleModal{{$value->id}}" tabindex="-1" role="dialog"
                    aria-labelledby="edit-modal-label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="bx bx-x btn-close"></i>
                                </button>
                                <h5 class="mb-4">Edit Delivery Address</h5>


                                <form method="post" action="{{route('customer.update_address',$value->id)}}" enctype="multipart/form-data">
                                    <div class="form-row">
                                        @csrf 
                                          @method('PATCH')
                                       <!-- @if(Session::get('success'))
                                          <div class="alert alert-success"> 
                                             {{ Session::get('success') }} 
                                           </div>
                                        @endif -->

                                        <div class="form-group col-lg-12">
                                            <input type="text" name="location" class="form-control" id="location" placeholder="Location" value="{{$value->location}}">
                                               @error("location")
                                                    <p style="color:red">{{$errors->first("location")}}
                                                @enderror
                                        </div>
                                         <div class="form-group col-lg-12">
                                            <input type="text" name="house_name" class="form-control" placeholder="House Name / Flat / Building" value="{{$value->house_name}}"> 
                                            @error("house_name")
                                                    <p style="color:red">{{$errors->first("house_name")}}
                                                @enderror
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input type="text" name="area" class="form-control" placeholder="Area / Street" value="{{$value->area}}">
                                            @error("area")
                                                    <p style="color:red">{{$errors->first("area")}}
                                                @enderror
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input type="text" name="city" class="form-control" placeholder="City" value="{{$value->city}}">
                                            @error("city")
                                                    <p style="color:red">{{$errors->first("city")}}
                                                @enderror
                                        </div>
                                          <div class="form-group col-lg-12">
                                            <input type="text" name="landmark" class="form-control" placeholder="Landmark" value="{{$value->landmark}}">
                                        </div>
                                       
                                        <div class="form-group col-lg-6">
                                            <input type="text" name="pincode" class="form-control" placeholder="Pincode" value="{{$value->pincode}}">
                                            @error("pincode")
                                                    <p style="color:red">{{$errors->first("pincode")}}
                                                @enderror
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <select name="home" id="home" class="form-control" >

                                                <option value="0" disabled selected >Address Type</option>

                                                <option value="Home" {{ $value->home === 'Home' ? 'selected' : '' }}>Home</option>

                                                <option value="Office"  {{ $value->home === 'Office' ? 'selected' : '' }}>Office</option>

                                                <option value="Other"  {{ $value->home === 'Other' ? 'selected' : '' }}>Other</option>

                                            </select>                                        </div>
                                        <div class="form-group col-lg-12">
                                            <textarea class="form-control" name="note_a_driver" id="note_A_driver" rows="3"
                                                placeholder="Note for Driver" value="{{$value->note}}">{{$value->note_a_driver}}</textarea>
                                        </div>

                                        <div class="form-group col-md-6 mb-md-0 d-none d-md-block">
                                            <button type="button" class="btn btn-outline-primary w-100"
                                                data-dismiss="modal" aria-label="Close">Close</button>
                                        </div>
                                        <div class="form-group col-md-6 mb-0">
                                            <button class="btn btn-secondary w-100">Save</button>
                                        </div>

                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach
        <!-- Address Modal End -->

                <!-- Address Modal End -->


   <!-- footer -->

   <footer>
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <h3>Quick links</h3>
                        <ul>
                            <li><a href="{{route('index')}}">Home</a></li>
                            <li><a href="{{route('restaurant_listing')}}">Restaurants</a></li>
                            <li><a href="{{route('customer.aboutus')}}">About us</a></li>
                            <li><a href="{{route('customer.contact')}}">Contact</a></li>
                           
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <h3>Quick links</h3>
                        <ul>

                            <li><a href="enrol-delivery-boy.html">Enroll Delivery Boy</a></li>
                            <li><a href="faq.html">FAQ</a></li>
                            <li><a href="terms-and-conditions.html">Terms and Conditions</a></li>
                            <li><a href="privacy-policy.html">Privacy Policy</a></li>
                            <li><a href="enrol-your-restaurant.html">Enroll Your Restaurant</a></li>
                        </ul>
                    </div>

                    <!-- <div class="col-lg-3 col-md-6">
                        <h3>Subscribe to newsletter</h3>
                        <p>Join our newsletter to keep be informed about offers and news.</p>
                        <form action="">
                            <div class="input-group newsletter-group">
                                <input type="text" class="form-control" placeholder="Enter your email" aria-label=""
                                    aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="find-food-btn"><i
                                            class='bx bx-send'></i></button>
                                </div>
                            </div>
                        </form>
                    </div> -->
                    <div class="col-lg-4 col-md-6">
                        <h3>Contact us</h3>
                        <ul class="contact">
                            <li><i class='bx bx-location-plus'></i><span>Down Town Building, MG Road, Toronto, Canada,
                                    784578</span></li>
                            <li><i class='bx bx-mail-send'></i><span>hello@cedextech.com</span></li>
                            <li><i class='bx bx-phone'></i><span>+91-8129881750</span></li>
                        </ul>
                        <div class="social">
                            <i class='bx bxl-facebook-circle'></i>
                            <i class='bx bxl-twitter'></i>
                            <i class='bx bxl-youtube'></i>
                            <i class='bx bxl-instagram-alt'></i>
                        </div>
                    </div>
                </div><!-- End row -->
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">

                <div class="text-center">
                    <p class="mb-0 copy-right">© 2021 FoodDay All Rights Reserved</p>
                </div>
            </div>
        </div>

        <!-- mobile footer -->

        <div class="mobile-footer">
            <div class="row">
                <div class="col-4 item">
                    <a href="home.html">
                        <i class='bx bx-search'></i>
                        <span>Search</span>
                    </a>
                </div>
                <div class="col-4 item">
                    <a href="cart.html">
                        <i class='bx bx-cart'><span class="badge badge-light">22</span></i>
                        <span>Cart</span>
                    </a>
                </div>
                <div class="col-4 item">
                    <a href="my-account.html">
                        <i class='bx bx-user'></i>
                        <span>Account</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- mobile footer end -->

    </footer>

    <!-- footer end -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
        </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>


<script type="text/javascript">
$(document).ready(function(){
    document.getElementById('pick1').style.display = "none";
})
function status(select){
   if(select.value=='delivery'){
    document.getElementById('sub1').style.display = "block";
    document.getElementById('pick1').style.display = "none";

   }else
   {
    document.getElementById('sub1').style.display = "none";
    document.getElementById('pick1').style.display = "block";

   }
} 
</script>
@livewireScripts


</body>

</html>