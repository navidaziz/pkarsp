@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Name')</th>
                                <th>@lang('Username')</th>
                                <th>@lang('Email')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($admins as $admin)
                            <tr>
                                <td data-label="@lang('Name')">
                                    <span class="font-weight-bold">{{$admin->name}}</span>
                                </td>

                                <td data-label="@lang('Username')">
                                    <span class="font-weight-bold">{{$admin->username}}</span>
                                </td>


                                <td data-label="@lang('Email')">
                                    {{ $admin->email }}
                                </td>


                                <td data-label="@lang('Action')">
                                    @if($admin->id != 1)
                                    <button class="icon-btn editBtn" data-name="{{ $admin->name }}" data-username="{{ $admin->username }}" data-email="{{ $admin->email }}" data-action="{{ route('admin.update',$admin->id) }}">
                                        <i class="las la-desktop text--shadow"></i>
                                    </button>
                                    <button class="icon-btn btn--danger removeBtn" data-action="{{ route('admin.remove',$admin->id) }}"><i class="las la-trash text--shadow"></i></button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($admins) }}
                </div>
            </div>
        </div>

    </div>


<!-- Create Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">@lang('Create admin')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="{{ route('admin.create') }}" method="post">
            @csrf
          <div class="modal-body">
            <div class="form-group">
                <label>@lang('Name')</label>
                <input type="text" name="name" class="form-control" placeholder="@lang('Name')" required>
            </div>
            <div class="form-group">
                <label>@lang('Email')</label>
                <input type="email" name="email" class="form-control" placeholder="@lang('Email')" required>
            </div>
            <div class="form-group">
                <label>@lang('Username')</label>
                <input type="text" name="username" class="form-control" placeholder="@lang('Username')" required>
            </div>
            <div class="form-group">
                <label>@lang('Password')</label>
                <input type="password" name="password" class="form-control" placeholder="@lang('Password')" required>
            </div>
            <div class="form-group">
                <label>@lang('Confirm Password')</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="@lang('Confirm Password')" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
            <button type="submit" class="btn btn--primary">@lang('Save')</button>
          </div>
        </form>
    </div>
  </div>
</div>


<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">@lang('Edit admin')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="" method="post">
            @csrf
          <div class="modal-body">
            <div class="form-group">
                <label>@lang('Name')</label>
                <input type="text" name="name" class="form-control" placeholder="@lang('Name')" required>
            </div>
            <div class="form-group">
                <label>@lang('Email')</label>
                <input type="email" name="email" class="form-control" placeholder="@lang('Email')" required>
            </div>
            <div class="form-group">
                <label>@lang('Username')</label>
                <input type="text" name="username" class="form-control" placeholder="@lang('Username')" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
            <button type="submit" class="btn btn--primary">@lang('Update')</button>
          </div>
        </form>
    </div>
  </div>
</div>


<!-- Remove Modal -->
<div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="removeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="removeModalLabel">@lang('Delete admin')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="" method="post">
            @csrf
          <div class="modal-body">
            <h6 class="text-center">@lang('Are you sure to delete this file ?')</h6>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
            <button type="submit" class="btn btn--danger">@lang('Delete')</button>
          </div>
        </form>
    </div>
  </div>
</div>
@endsection
@push('breadcrumb-plugins')
<button class="btn btn--primary icon-btn" data-toggle="modal" data-target="#exampleModal"><i class="las la-pen"></i> @lang('Add New')</button>
@endpush


@push('script')
<script>
    (function($){
        "use strict";
        $('.editBtn').on('click',function(){
            var modal = $('#editModal');
            modal.find('input[name=name]').val($(this).data('name'));
            modal.find('input[name=username]').val($(this).data('username'));
            modal.find('input[name=email]').val($(this).data('email'));
            modal.find('form').attr('action',$(this).data('action'));
            modal.modal('show');
        });

        $('.removeBtn').on('click',function(){
            var modal = $('#removeModal');
            modal.find('form').attr('action',$(this).data('action'));
            modal.modal('show');
        });
    })(jQuery);

</script>
@endpush