@extends('layouts.app')


@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif

    <section class="section">
      <div class="section-header">
        <h1>Users</h1>
        <div class="section-header-button">
          <a href="{{ route('users.create') }}" class="btn btn-primary">Add New</a>
        </div>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
          <div class="breadcrumb-item"><a href="#">Users</a></div>
          <div class="breadcrumb-item">All Users</div>
        </div>
      </div>
      <div class="section-body">
        <h2 class="section-title">Users</h2>
        <p class="section-lead">

        </p>


        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4>All Users</h4>
              </div>
              <div class="card-body">
                <div class="float-right">
                  <form>
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Search">
                      <div class="input-group-append">
                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                      </div>
                    </div>
                  </form>
                </div>

                <div class="clearfix mb-3"></div>

                <div class="table-responsive">
                  <table class="table table-striped">
                    <tr>
                      <th>No</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Role</th>
                    </tr>
                    @foreach ($data as $key => $user)
                    <tr>
                      <td>
                        {{ ++$i }}
                      </td>
                      <td>{{ $user->name }}
                        <div class="table-links">
                          <a href="{{ route('users.show',$user->id) }}">Show</a>
                          <div class="bullet"></div>
                          <a href="{{ route('users.edit',$user->id) }}">Edit</a>
                          <div class="bullet"></div>
                            {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'text-danger']) !!}
                            {!! Form::close() !!}

                        </div>
                      </td>
                      <td>
                        {{ $user->email }}
                      </td>
                      <td>
                        @if(!empty($user->getRoleNames()))
                            @foreach($user->getRoleNames() as $v)
                            <label class="badge badge-success">{{ $v }}</label>
                            @endforeach
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  </table>
                </div>
                <div class="float-right">
                  <nav>
                    <ul class="pagination">
                      <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                          <span class="sr-only">Previous</span>
                        </a>
                      </li>
                      <li class="page-item active">
                        <a class="page-link" href="#">1</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="#">2</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="#">3</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                          <span class="sr-only">Next</span>
                        </a>
                      </li>
                    </ul>
                  </nav>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
