@extends('layouts.auth')
@section('content')

<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="form-box">
        <h4 class="mb-4 text-center">Log In</h4>
        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="mb-2">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Log In</button>

            <div class="text-center mt-3">
                <span>Don't have an account?</span>
                <a href="/register" class="login-link">Register</a>
            </div>

        </form>
    </div>
</div>


<div id="toastStack" style="position:fixed; bottom:24px; right:24px; z-index:9999; display:flex; flex-direction:column; gap:10px; pointer-events:none;"></div>

@if ($errors->any())
<script>
  document.addEventListener('DOMContentLoaded', () => {
    @foreach ($errors->all() as $error)
      showToast('❌', 'Login Failed', '{{ $error }}', '#fb7185');
    @endforeach
  });
</script>
@endif

@if (session('success'))
<script>
  document.addEventListener('DOMContentLoaded', () => {
    showToast('✅', 'Success', '{{ session("success") }}', '#4ade80');
  });
</script>
@endif

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
</script>

@endsection