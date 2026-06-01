@extends('layouts.app')
@section('content')

<div class="top d-flex justify-content-between">
  <h5 class="head mb-3">Habits</h5>
  <button class="btn btn-primary" onclick="openAdd()">+ Add Habit</button>
</div>


<div class="d-flex gap-2 flex-wrap mb-4">
  <button class="filter-pill active" data-cat="All" onclick="setFilter(this, 'All')">All</button>
  <button class="filter-pill" data-cat="Health" onclick="setFilter(this, 'Health')">Health</button>
  <button class="filter-pill" data-cat="Study" onclick="setFilter(this, 'Study')">Study</button>
  <button class="filter-pill" data-cat="Fitness" onclick="setFilter(this, 'Fitness')">Fitness</button>
  <button class="filter-pill" data-cat="Mindfulness" onclick="setFilter(this, 'Mindfulness')">Mindfulness</button>
  <button class="filter-pill" data-cat="Creative" onclick="setFilter(this, 'Creative')">Creative</button>
  <button class="filter-pill" data-cat="Social" onclick="setFilter(this, 'Social')">Social</button>
</div>


<div class="row g-3" id="habitGrid">
  @foreach ($habits as $habit)
  @php
    $color = match($habit->category) {
      'Health'      => '#4ade80',
      'Study'       => '#60a5fa',
      'Fitness'     => '#f97316',
      'Mindfulness' => '#c084fc',
      'Creative'    => '#fb7185',
      'Social'      => '#fbbf24',
      default       => '#6d5fff',
    };
  @endphp

  <div class="col-md-4 col-sm-6 habit-col" data-cat="{{ $habit->category }}">
    <div class="habit-card {{ !$habit->is_active ? 'checked' : '' }}"
         style="--cat-color: {{ $color }};">

  
      <div class="d-flex justify-content-between align-items-center mb-3">

      
        <button class="check-btn {{ !$habit->is_active ? 'checked' : '' }}"
                style="--cat-color: {{ $color }};"
                onclick="toggleHabit({{ $habit->id }}, this)">✓</button>

        <div class="d-flex gap-1">
          <button class="icon-btn" onclick="openEdit(
            {{ $habit->id }},
            '{{ addslashes($habit->title) }}',
            '{{ $habit->category }}',
            '{{ $habit->user->name }}'
          )">✎</button>
          <button class="icon-btn del" onclick="openDelete({{ $habit->id }}, '{{ addslashes($habit->title) }}')">×</button>
        </div>
      </div>

      <div class="habit-title {{ !$habit->is_active ? 'checked' : '' }}">{{ $habit->title }}</div>
      <div class="habit-user">👤 {{ $habit->user->name }}</div>

      <div class="d-flex justify-content-between align-items-center mt-3">
        <span class="cat-badge"
              style="background: {{ $color }}18;
                     color: {{ $color }};
                     border: 1px solid {{ $color }}33;">
          {{ $habit->category }}
        </span>
        <span class="streak-pill">🔥 {{ $habit->streak }}d</span>
      </div>

    </div>
  </div>
  @endforeach

  <div class="col-md-4 col-sm-6">
    <div class="add-card" onclick="openAdd()">
      <div class="add-card-icon">+</div>
      <div>New Habit</div>
    </div>
  </div>
</div>


<div class="modal-backdrop-custom" id="formModal">
  <div class="modal-box">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="modal-title-custom" id="modalTitle">Add Habit</div>
      <button class="icon-btn" onclick="closeModal()" style="width:32px;height:32px;font-size:18px;">×</button>
    </div>

    <form id="habitForm" method="POST">
      @csrf
      <span id="methodField"></span>

      <div class="mb-3">
        <label class="field-label">Habit Name</label>
        <input class="field-input" name="title" id="formName" placeholder="e.g. Drink 8 glasses of water" required />
      </div>

      <div class="mb-3">
        <label class="field-label">Category</label>
        <select class="field-input" name="category" id="formCategory">
          <option>Health</option>
          <option>Study</option>
          <option>Fitness</option>
          <option>Mindfulness</option>
          <option>Creative</option>
          <option>Social</option>
        </select>
      </div>

      <div class="mb-4">
        <label class="field-label">Assigned User</label>
        <select class="field-input" name="user_id" id="formUser">
          @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="d-flex gap-2">
        <button type="button" class="btn-cancel-custom" onclick="closeModal()">Cancel</button>
        <button type="submit" class="btn-primary-custom">Save Habit</button>
      </div>
    </form>
  </div>
</div>


<div class="modal-backdrop-custom" id="deleteModal">
  <div class="delete-box">
    <div style="font-size:38px; margin-bottom:12px;">🗑️</div>
    <div class="modal-title-custom mb-2">Delete this habit?</div>
    <div style="color:#6b6880; font-size:13px; margin-bottom:24px;">
      <strong id="deleteHabitName" style="color:#e8e6f0;"></strong> will be permanently removed.
    </div>
    <div class="d-flex gap-2">
      <button class="btn-cancel-custom" onclick="closeDelete()">Keep it</button>
      <form id="deleteForm" method="POST" style="flex:1;">
        @csrf @method('DELETE')
        <button type="submit"
                style="width:100%; padding:12px; border-radius:11px; border:none; background:#fb7185;
                       color:#fff; font-size:13px; font-weight:700; cursor:pointer; font-family:'DM Sans',sans-serif;">
          Delete
        </button>
      </form>
    </div>
  </div>
</div>

<div id="toastStack" style="position:fixed; bottom:24px; right:24px; z-index:9999; display:flex; flex-direction:column; gap:10px; pointer-events:none;"></div>

@if (session('success'))
<script>
  document.addEventListener('DOMContentLoaded', () => {
    showToast('✅', 'Success', '{{ session("success") }}', '#4ade80');
  });
</script>
@endif

<script>
  const STORE_ROUTE  = "{{ route('habits.store') }}";
  const UPDATE_ROUTE = "{{ url('admin/habits') }}";
  const DELETE_ROUTE = "{{ url('admin/habits') }}";
  const TOGGLE_ROUTE = "{{ url('admin/habits') }}";
  const CSRF         = document.querySelector('meta[name="csrf-token"]')?.content
                    ?? "{{ csrf_token() }}";

  const COLORS = {
    Health: "#4ade80", Study: "#60a5fa", Fitness: "#f97316",
    Mindfulness: "#c084fc", Creative: "#fb7185", Social: "#fbbf24"
  };


  function toggleHabit(id, btn) {
  fetch(`${TOGGLE_ROUTE}/${id}/toggle`, {
    method: 'PATCH',
    headers: {
      'X-CSRF-TOKEN': CSRF,
      'Content-Type': 'application/json',
    }
  })
  .then(res => {
    if (!res.ok) throw new Error('Toggle failed');
    return res.json();
  })
  .then(data => {
    const card  = btn.closest('.habit-card');
    const title = card.querySelector('.habit-title');
    const streakPill = card.querySelector('.streak-pill');
    const isDone = !data.is_active; 
    
    btn.classList.toggle('checked', isDone);
    card.classList.toggle('checked', isDone);
    title.classList.toggle('checked', isDone);
    streakPill.innerHTML = `🔥 ${data.streak}d`;

    showToast(
      isDone ? '✅' : '↩️',
      isDone ? 'Habit completed!' : 'Habit unmarked',
      isDone ? 'Keep it up!' : 'Marked as incomplete.',
      isDone ? '#4ade80' : '#fbbf24'
    );
  })
  .catch(() => showToast('❌', 'Error', 'Something went wrong.', '#fb7185'));
}

 
  function setFilter(btn, cat) {
    document.querySelectorAll(".filter-pill").forEach(b => {
      b.classList.remove("active");
      b.style.background = "#16151f";
      b.style.borderColor = "#1f1e2e";
      b.style.color = "#6b6880";
    });
    btn.classList.add("active");
    btn.style.background = cat === "All" ? "#6d5fff" : (COLORS[cat] || "#6d5fff");
    btn.style.borderColor = "transparent";
    btn.style.color = "#0d0d12";

    document.querySelectorAll(".habit-col").forEach(col => {
      col.style.display = (cat === "All" || col.dataset.cat === cat) ? "" : "none";
    });
  }

  // ── Add modal ──
  function openAdd() {
    document.getElementById("modalTitle").textContent = "Add Habit";
    document.getElementById("habitForm").action = STORE_ROUTE;
    document.getElementById("methodField").innerHTML = "";
    document.getElementById("formName").value = "";
    document.getElementById("formCategory").value = "Health";
    document.getElementById("formModal").classList.add("show");
  }

  // ── Edit modal ──
  function openEdit(id, name, category, userName) {
    document.getElementById("modalTitle").textContent = "Edit Habit";
    document.getElementById("habitForm").action = `${UPDATE_ROUTE}/${id}`;
    document.getElementById("methodField").innerHTML = `<input type="hidden" name="_method" value="PUT">`;
    document.getElementById("formName").value = name;
    document.getElementById("formCategory").value = category;
    document.getElementById("formModal").classList.add("show");
  }

  function closeModal() {
    document.getElementById("formModal").classList.remove("show");
  }

  // ── Delete modal ──
  function openDelete(id, name) {
    document.getElementById("deleteHabitName").textContent = name;
    document.getElementById("deleteForm").action = `${DELETE_ROUTE}/${id}`;
    document.getElementById("deleteModal").classList.add("show");
  }

  function closeDelete() {
    document.getElementById("deleteModal").classList.remove("show");
  }

  document.getElementById("formModal").addEventListener("click", function(e) {
    if (e.target === this) closeModal();
  });
  document.getElementById("deleteModal").addEventListener("click", function(e) {
    if (e.target === this) closeDelete();
  });

  // ── Toast ──
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