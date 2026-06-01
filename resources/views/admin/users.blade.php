@extends('layouts.app')
@section('content')

<div class="top d-flex justify-content-between">
    <h5 class="head mb-3">Users</h5>
    <a href="{{ route('users.create') }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">+ Add User</a>
</div>

<div class="container-fluid">
    <div class="row m-3">
      <div class="col-12">
        <div class="card-bodyy p-0">
             <table class="table table-dark m-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>USER</th>
                        <th>EMAIL</th>
                        <th>ROLE</th>
                        <th>CREATED</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                
                <tbody>
                      @foreach($users as $user)
                      @php
                      $roleColor = $user->role === 'ADMIN' ? '#fb7185' : '#60a5fa';
                      @endphp
                      
                      <tr>
                        <td>{{ $user->id }}</td>
                        
                        <td>
                          <div class="user-cell d-flex align-items-center gap-2">
                            <div class="avatar-box" style="background-color: {{ $roleColor }}22; border: 1px solid {{ $roleColor }}44; color: {{ $roleColor }};">
                            {{ strtoupper(substr($user->first_name,0,1)) }}{{ strtoupper(substr($user->last_name,0,1)) }}
                            </div>
                          <span class="user-name">{{ $user->first_name }} {{ $user->last_name }}</span>
                          </div>
                        </td>
                        
                        <!-- Email -->
                        <td><span class="user-email">{{ $user->email }}</span></td>

                        <!-- Role badge -->
                        <td>
                          <span class="role-badge" style="background-color: {{ $roleColor }}18; border: 1px solid {{ $roleColor }}33; color: {{ $roleColor }};"> {{ strtoupper($user->role) }} </span>
                        </td>
                        
                        <td><span class="user-email">{{ $user->created_at->format('Y-m-d') }}</span></td>

                        <td>
                          <button type="button" 
                            class="btn-edit btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editUserModal"
                            data-id="{{ $user->id }}"
                            data-first="{{ $user->first_name }}"
                            data-last="{{ $user->last_name }}"
                            data-email="{{ $user->email }}"
                            data-role="{{ $user->role }}">
                            Edit
                          </button>

                           <button type="button" 
                             class="btn-del btn-sm"
                             data-bs-toggle="modal"
                             data-bs-target="#deleteUserModal"
                             data-id="{{ $user->id }}">
                             Delete
                          </button>
                        </td>
                      </tr>
                      @endforeach
                </tbody>
            </table>
          </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content custom-modal">
      <div class="modal-header border-0">
        <h5 class="modal-title modal-title-custom">Add User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label class="form-label-custom">FIRST NAME</label>
            <input type="text" name="first_name" class="form-control form-control-custom" required>
          </div>
          <div class="mb-3">
            <label class="form-label-custom">LAST NAME</label>
            <input type="text" name="last_name" class="form-control form-control-custom" required>
          </div>
          <div class="mb-3">
            <label class="form-label-custom">EMAIL</label>
            <input type="email" name="email" class="form-control form-control-custom" required>
          </div>
          <div class="mb-3">
            <label class="form-label-custom">PASSWORD</label>
            <input type="password" name="password" class="form-control form-control-custom" required>
          </div>
          <div class="mb-3">
            <label class="form-label-custom">CONFIRM PASSWORD</label>
            <input type="password" name="password_confirmation" class="form-control form-control-custom" required>
          </div>
          <div class="mb-3">
            <label class="form-label-custom">ROLE</label>
            <select name="role" class="form-control form-control-custom">
              <option value="USER">User</option>
              <option value="ADMIN">Admin</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label-custom">PROFILE PICTURE</label>
            <input type="file" name="profile" class="form-control form-control-custom">
          </div>
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-cancel flex-fill" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-add flex-fill">Add User</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content custom-modal">
      <div class="modal-header border-0">
        <h5 class="modal-title">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control">
              <option value="USER">User</option>
              <option value="ADMIN">Admin</option>
            </select>
          </div>
          <div class="mb-3">
            <label>Profile Picture</label>
            <input type="file" name="profile" class="form-control">
          </div>
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-cancel flex-fill" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-add flex-fill">Update User</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content custom-modal">
      <div class="modal-header border-0">
        <h5 class="modal-title modal-title-custom">Delete User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p class="form-label-custom">Are you sure you want to delete this user?</p>
        <form action="{{ route('users.destroy', $user->id ?? 1) }}" method="POST">
          @csrf
          @method('DELETE')
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-cancel flex-fill" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-add flex-fill">Delete</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  const addModal = document.getElementById('addUserModal');
  addModal.addEventListener('show.bs.modal', event => {
  const button = event.relatedTarget;

  const first = button.getAttribute('data-first') || '';
  const last = button.getAttribute('data-last') || '';
  const email = button.getAttribute('data-email') || '';
  const role = button.getAttribute('data-role') || 'USER';

  addModal.querySelector('input[name="first_name"]').value = first;
  addModal.querySelector('input[name="last_name"]').value = last;
  addModal.querySelector('input[name="email"]').value = email;
  addModal.querySelector('select[name="role"]').value = role;
});

  document.addEventListener('DOMContentLoaded', () => {
  const editModal = document.getElementById('editUserModal');
  editModal.addEventListener('show.bs.modal', event => {
  const button = event.relatedTarget;

    
    const id = button.getAttribute('data-id');
    const first = button.getAttribute('data-first');
    const last = button.getAttribute('data-last');
    const email = button.getAttribute('data-email');
    const role = button.getAttribute('data-role');

  
    editModal.querySelector('input[name="first_name"]').value = first;
    editModal.querySelector('input[name="last_name"]').value = last;
    editModal.querySelector('input[name="email"]').value = email;
    editModal.querySelector('select[name="role"]').value = role;

    
    editModal.querySelector('form').action = `/admin/users/${id}`;
  });
});

</script>



@endsection