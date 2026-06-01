@extends('layouts.auth')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="form-box">
        <h4 class="mb-4 text-center">Create account</h4>
        <form method="POST" action="{{ route('register') }}" autocomplete="off" enctype="multipart/form-data">
            @csrf

            <div class="mb-2">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email" autocomplete="off" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Profile Picture</label>
                <input type="file" name="profile" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary w-100">Create Account</button>

            <div class="text-center mt-3">
                <span>Already have an account? </span>
                <a href="/login" class="login-link">Log in</a>
            </div>
        </form>
    </div>
</div>

<div id="toastStack" style="position:fixed; bottom:24px; right:24px; z-index:9999; display:flex; flex-direction:column; gap:10px; pointer-events:none;"></div>

@if ($errors->any())
<script>
  document.addEventListener('DOMContentLoaded', () => {
    @foreach ($errors->all() as $error)
      showToast('❌', 'Registration Failed', '{{ $error }}', '#fb7185');
    @endforeach
  });
</script>
@endif

<script>
  document.querySelector('form').addEventListener('submit', function(e) {
    const password = document.querySelector('input[name="password"]').value;
    const confirm  = document.querySelector('input[name="password_confirmation"]').value;

    if (password !== confirm) {
      e.preventDefault(); // stop form from submitting
      showToast('❌', 'Password Mismatch', 'Passwords do not match!', '#fb7185');
    }
  });

  function showToast(icon, title, msg, color) {
    let stack = document.getElementById("toastStack");
    if (!stack) {
      stack = document.createElement("div");
      stack.id = "toastStack";
      stack.style = "position:fixed; bottom:24px; right:24px; z-index:9999; display:flex; flex-direction:column; gap:10px; pointer-events:none;";
      document.body.appendChild(stack);
    }
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