<x-app-layout>
    <div class="search-nav">
        <div class="container">
            <h3 class="mb-0">Order Summery</h3>
        </div>
    </div>

    <section class="py-60">
        
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class=" order-success-div">
                        <div class="success-check">
                            <i class='bx bx-check'></i>
                        </div>
                        <h4>Order Placed!</h4>
                        <p>Your order number is <strong>#{{$order->id}}</strong>. The restaurant will deliver your order by
                            <strong>{{$order->created_at->format('H:m:s')}}.</strong>
                            You can view your order on your account page, when you are logged in.
                            For any questions, reach out to us on hello@foodday.com
                        </p>
                        <a href="{{route('my_home')}}" class="btn btn-outline-primary mt-3 mr-sm-3">Continue Shopping</a>
                        <a href="{{route('order_tracking',$order->id)}}" class="btn btn-primary mt-3">View Order</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
   

</x-app-layout>