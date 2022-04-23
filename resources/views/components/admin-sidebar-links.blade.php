<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-user-friends"></i>
          <span>USERS</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Users:</h6>
            <a class="collapse-item" href="{{route('admin.restaurant_user.show')}}">Restaurant Users</a>
            <a class="collapse-item" href="{{route('admin.show')}}">Admin Users</a>
            <a class="collapse-item" href="{{route('admin.driver.show')}}">Drivers</a>
            <a class="collapse-item" href="{{route('admin.customer.show')}}">Customers</a>
          </div>
        </div>
       
    