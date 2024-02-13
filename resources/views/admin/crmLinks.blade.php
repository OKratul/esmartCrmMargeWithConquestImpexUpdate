@include('partials.layoutHead')

<div id="bg">
    <canvas></canvas>
    <canvas></canvas>
    <canvas></canvas>
</div>

<!-- / Content -->
<div class="container d-flex align-items-center justify-content-center gap-5" style="height: 850px">
    <div class="card" style="background: rgba(0,0,0,0.5)">
        <div class="card-body">
          <a href="{{route('dashboard')}}">
              <h3 class="text-white">eSmart Dashboard</h3>
              <img src="{{asset('images/12356.png')}}" width="300px" alt="esmart.com.bd">
          </a>
        </div>
    </div>
    <div class="card"  style="background: rgba(0,0,0,0.5)">
        <div class="card-body">
          <a href="{{route('conquest-dashboard')}}">
              <h3 class="text-white">ConquestImpex Dashboard</h3>
              <img class="p-1" src="{{asset('bjhgj.png')}}" width="300px" alt="ConquestImpex">
          </a>
        </div>
    </div>
</div>

@include('partials.layoutEnd')
