@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h5 class="head mb-1">My Profile</h5>
    <div style="font-size:12px; color:#6b6880;">Manage your personal information</div>
  </div>
  <button class="btn-primary-custom" style="width:auto; padding:10px 18px;" onclick="toggleEdit()">
    <span id="editBtnText">✎ Edit Profile</span>
  </button>
</div>


<div class="profile-header-card mb-4">
  <div class="glow-blob"></div>
  <div class="d-flex align-items-center gap-4">

    <div style="position:relative; flex-shrink:0;">
      <div class="avatar-circle" id="avatarPreview">
        @if(auth()->user()->avatar)
          <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
               style="width:88px; height:88px; border-radius:20px; object-fit:cover; display:block;" />
        @else
          <span id="avatarInitials">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
        @endif
      </div>
      <button class="avatar-edit-btn" onclick="document.getElementById('avatarInput').click()">✎</button>
    </div>

    <div>
      <div style="font-family:'Syne',sans-serif; font-size:22px; font-weight:800; color:#e8e6f0;">
        {{ auth()->user()->name }}
      </div>
      <div style="font-size:13px; color:#6b6880; margin-top:3px;">{{ auth()->user()->email }}</div>
      <div style="font-size:11px; color:#3a3850; margin-top:6px;">
        Member since {{ auth()->user()->created_at->format('F Y') }}
      </div>
    </div>
  </div>
</div>


<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
  @csrf @method('PUT')

  <input type="file" id="avatarInput" name="avatar" accept="image/*"
         style="display:none;" onchange="previewAvatar(this)" />

  <div class="row g-4">

    <div class="col-md-6">
      <div class="info-card">
        <div class="info-card-title">Personal Info</div>
        <div class="d-flex flex-column gap-3">

          <div>
            <label class="field-label">Full Name</label>
            <input class="field-input" name="name" id="fieldName"
                   value="{{ old('name', auth()->user()->name) }}"
                   placeholder="Your full name" disabled />
          </div>

          <div>
            <label class="field-label">Username</label>
            <input class="field-input" name="username" id="fieldUsername"
                   value="{{ old('username', auth()->user()->username ?? '') }}"
                   placeholder="your_username" disabled />
          </div>

          <div>
            <label class="field-label">Gender</label>
            <select class="field-input" name="gender" id="fieldGender" disabled>
              @foreach(['Prefer not to say','Male','Female','Non-binary','Other'] as $g)
                <option value="{{ $g }}"
                  {{ old('gender', auth()->user()->gender ?? '') === $g ? 'selected' : '' }}>
                  {{ $g }}
                </option>
              @endforeach
            </select>
          </div>

          <div>
            <label class="field-label">Bio</label>
            <textarea class="field-input" name="bio" id="fieldBio"
                      rows="3" placeholder="Tell us something about yourself..."
                      style="resize:none;" disabled>{{ old('bio', auth()->user()->bio ?? '') }}</textarea>
          </div>

        </div>
      </div>
    </div>

    <div class="col-md-6 d-flex flex-column gap-4">
      <div class="info-card">
        <div class="info-card-title">Contact Info</div>
        <div class="d-flex flex-column gap-3">

          <div>
            <label class="field-label">Email Address</label>
            <input class="field-input" name="email" id="fieldEmail"
                   value="{{ old('email', auth()->user()->email) }}"
                   placeholder="you@email.com" disabled />
          </div>

          <div>
            <label class="field-label">Phone Number</label>
            <input class="field-input" name="phone" id="fieldPhone"
                   value="{{ old('phone', auth()->user()->phone ?? '') }}"
                   placeholder="+63 9XX XXX XXXX" disabled />
          </div>

          <div>
            <label class="field-label">Address</label>
            <input class="field-input" name="address" id="fieldAddress"
                   value="{{ old('address', auth()->user()->address ?? '') }}"
                   placeholder="City, Province" disabled />
          </div>

        </div>
      </div>

      <div class="info-card">
        <div class="info-card-title">Account</div>
        <div class="d-flex flex-column gap-2">
          <div class="d-flex justify-content-between align-items-center">
            <span style="font-size:12px; color:#6b6880;">Account Status</span>
            <span style="font-size:12px; font-weight:600; color:#4ade80;">Active</span>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <span style="font-size:12px; color:#6b6880;">Role</span>
            <span style="font-size:12px; font-weight:600; color:#60a5fa;">
              {{ auth()->user()->role ?? 'User' }}
            </span>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <span style="font-size:12px; color:#6b6880;">Member Since</span>
            <span style="font-size:12px; font-weight:600; color:#6b6880;">
              {{ auth()->user()->created_at->format('M d, Y') }}
            </span>
          </div>
        </div>
      </div>

      <div id="saveActions" style="display:none;">
        <div class="info-card" style="border-color:#6d5fff33;">
          <div style="font-size:12px; color:#6b6880; margin-bottom:14px;">Review your changes before saving.</div>
          <div class="d-flex gap-2">
            <button type="button" class="btn-cancel-custom" onclick="cancelEdit()">Cancel</button>
            <button type="submit" class="btn-primary-custom">Save Changes</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</form>

<div id="toastStack" style="position:fixed; bottom:24px; right:24px; z-index:9999; display:flex; flex-direction:column; gap:10px; pointer-events:none;"></div>

<script>
    const FIELDS = ['fieldName','fieldUsername','fieldGender','fieldBio','fieldEmail','fieldPhone','fieldAddress'];
    let isEditing = false;
    
    function toggleEdit() {
        isEditing = true;
        FIELDS.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.disabled = false;
        });
        
        document.getElementById('saveActions').style.display = 'block';
        document.getElementById('editBtnText').textContent = '✎ Editing...';
    }
    
    function cancelEdit() {
        isEditing = false;
        FIELDS.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.disabled = true;
        });

        document.getElementById('saveActions').style.display = 'none';
        document.getElementById('editBtnText').textContent = '✎ Edit Profile';
    }
    
    function previewAvatar(input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];
        if (file.size > 3 * 1024 * 1024) {
            showToast('❌', 'File too large', 'Max size is 3MB.', '#fb7185');
            return;
        }
        
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('avatarPreview');
            preview.innerHTML = `<img src="${e.target.result}"
            style="width:88px;height:88px;border-radius:20px;object-fit:cover;display:block;" />`;
            showToast('✅', 'Photo selected!', 'Save to apply changes.', '#4ade80');
        };
        reader.readAsDataURL(file);
    }
    
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
        
        <button onclick="this.parentElement.remove()" style="background:none;border:none;color:#3a3850;cursor:pointer;font-size:18px;">×</button>`;
        
        stack.appendChild(t);
        setTimeout(() => t.remove(), 3500);
    }
    
    @if(session('success'))
    document.addEventListener('DOMContentLoaded', () => {
    showToast('✅', 'Profile updated!', '{{ session("success") }}', '#4ade80');
});
@endif
</script>

@endsection