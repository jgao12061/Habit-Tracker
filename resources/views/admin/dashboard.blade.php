@extends('layouts.app')
@section('content')

<h5 class="head mb-3">Overview</h5>

<div class="container-fluid">

  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card bg-dark">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <div class="card-title">TOTAL USERS</div>
            <p class="card-text">{{ $totalUsers }}</p>
          </div>
          <div class="stat-icon" style="background:#6d5fff18;">👥</div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-dark">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <div class="card-title">TOTAL HABITS</div>
            <p class="card-text">{{ $totalHabits }}</p>
          </div>
          <div class="stat-icon" style="background:#4ade8018;">🔥</div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-dark">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <div class="card-title">ACTIVE STREAKS</div>
            <p class="card-text">{{ $activeStreaks }}</p>
          </div>
          <div class="stat-icon" style="background:#fbbf2418;">⚡</div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-dark">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <div class="card-title">CATEGORIES</div>
            <p class="card-text">{{ $totalCategories }}</p>
          </div>
          <div class="stat-icon" style="background:#a78bfa18;">🏷️</div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="card bg-dark mb-4">
        <div class="card-body">
          <div class="card-title">USER REGISTRATIONS</div>
          <canvas id="registrationsChart" height="200"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card bg-dark mb-4">
        <div class="card-body">
          <div class="card-title">HABITS BY CATEGORY</div>
          <canvas id="categoryChart" height="200"></canvas>
        </div>
      </div>
    </div>
  </div>

</div>
</div> 


<div id="toastStack" style="position:fixed; bottom:24px; right:24px; z-index:9999; display:flex; flex-direction:column; gap:10px; pointer-events:none;"></div>

@if (session('success'))
<script>
  document.addEventListener('DOMContentLoaded', () => {
    showToast('✅', 'Welcome back!', '{{ session("success") }}', '#4ade80');
  });
</script>
@endif

@endsection

@push('scripts')
<script>
  function showToast(icon, title, msg, color) {
    const stack = document.getElementById("toastStack");
    const t = document.createElement("div");
    t.className = "toast-item";
    t.style.border = `1px solid ${color}44`;
    t.style.borderLeft = `3px solid ${color}`;
    t.innerHTML = `
      <span style="font-size:16px;">${icon}</span>
      <div style="flex:1;">
        <div style="font-size:13px;font-weight:600;color:#e8e6f0;">${title}</div>
        <div style="font-size:11px;color:#6b6880;margin-top:2px;">${msg}</div>
      </div>
      <button onclick="this.parentElement.remove()"
              style="background:none;border:none;color:#3a3850;cursor:pointer;font-size:18px;">×</button>
    `;
    stack.appendChild(t);
    setTimeout(() => t.remove(), 3500);
  }

  // Registration Chart
  const regCtx = document.getElementById('registrationsChart');
  new Chart(regCtx, {
    type: 'bar',
    data: {
      labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      datasets: [{
        label: 'Registrations',
        data: @json($registrations),
        backgroundColor: '#6d5fff',
        borderRadius: 6,
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: {
        x: { grid: { display: false }, ticks: { color: '#6b6880' } },
        y: { grid: { display: false }, ticks: { color: '#6b6880' }, beginAtZero: true }
      }
    }
  });

  const catCtx = document.getElementById('categoryChart');
  new Chart(catCtx, {
    type: 'bar',
    data: {
      labels: ['Health', 'Study', 'Fitness', 'Mindfulness', 'Creative', 'Social'],
      datasets: [{
        label: 'Habits',
        data: @json($habitsByCategory),
        backgroundColor: ['#4ade80','#60a5fa','#f97316','#c084fc','#fb7185','#fbbf24'],
        borderRadius: 6,
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: {
        x: { grid: { display: false }, ticks: { color: '#6b6880' } },
        y: { grid: { display: false }, ticks: { color: '#6b6880' }, beginAtZero: true }
      }
    }
  });
</script>
@endpush