@extends('layouts.templateAdmin')

@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row gy-6">
      <div class="col">
        <div class="card h-100">
          <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
              <h5 class="card-title m-0">Transactions</h5>
            </div>
          </div>
          <div class="card-body pt-lg-10">
            <div class="row g-6 justify-content-between">
              <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                  <div class="avatar">
                    <div class="avatar-initial bg-primary rounded shadow-xs">
                      <i class="ri-pie-chart-2-line ri-24px"></i>
                    </div>
                  </div>
                  <div class="ms-3">
                    <p class="mb-0">Sales</p>
                    <h5 class="mb-0">@currency($totalSales)</h5>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                  <div class="avatar">
                    <div class="avatar-initial bg-success rounded shadow-xs">
                      <i class="ri-group-line ri-24px"></i>
                    </div>
                  </div>
                  <div class="ms-3">
                    <p class="mb-0">Customers</p>
                    <h5 class="mb-0">{{ $totalCustomers }}</h5>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                  <div class="avatar">
                    <div class="avatar-initial bg-warning rounded shadow-xs">
                      <i class="ri-macbook-line ri-24px"></i>
                    </div>
                  </div>
                  <div class="ms-3">
                    <p class="mb-0">Products</p>
                    <h5 class="mb-0">{{ $totalProducts }}</h5>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                  <div class="avatar">
                    <div class="avatar-initial bg-danger rounded shadow-xs">
                      <i class="ri-user-3-line ri-24px"></i>
                    </div>
                  </div>
                  <div class="ms-3">
                    <p class="mb-0">Users</p>
                    <h5 class="mb-0">{{ $totalUsers }}</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card mt-4">
          <div class="card-body">
            <h5 class="card-title">Penjualan Bulanan</h5>
            <canvas id="salesChart"></canvas>
          </div>
        </div>

      </div>
      <!-- Table for User -->
      <div class="col-12">
        <div class="card overflow-hidden">
          <div class="table-responsive">
            <table class="table table-sm text-center">
              <thead>
                <tr>
                  <th class="text-truncate">No</th>
                  <th class="text-truncate">Name</th>
                  <th class="text-truncate">Email</th>
                  <th class="text-truncate">Role</th>
                </tr>
              </thead>
              <tbody class="text-center">
                @foreach ($users as $user)
                <tr>
                  <td class="text-truncate">{{ $loop->iteration }}</td>
                  <td class="text-truncate">{{ $user->name }}</td>
                  <td class="text-truncate">{{ $user->email }}</td>
                  <td class="text-truncate">
                    @if ($user->role == 'admin')
                    <i class="ri-vip-crown-line ri-22px text-primary me-2"></i>
                    <span>{{ $user->role }}</span>
                    @else
                    <i class="ri-user-3-line ri-22px text-success me-2"></i>
                    <span>{{ $user->role }}</span>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
  const ctx = document.getElementById('salesChart').getContext('2d');
  const chartLabels = @json($chartLabels);
  const chartValues = @json($chartValues);
  const salesChart = new Chart(ctx, {
    type: 'line', // Bisa diganti dengan 'bar', 'pie', dsb.
    data: {
      labels: chartLabels, // Data tanggal dari backend
      datasets: [{
        label: 'Total Penjualan',
        data: chartValues, // Data total penjualan
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
        fill: true,
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          display: true,
        },
      },
      scales: {
        x: {
          title: {
            display: true,
            text: 'Tanggal',
          }
        },
        y: {
          title: {
            display: true,
            text: 'Total Penjualan (IDR)',
          },
          beginAtZero: true,
        }
      }
    }
  });
</script>

@endsection