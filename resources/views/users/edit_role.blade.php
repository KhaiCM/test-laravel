@extends('layouts.app')

@section('style')
<link href="bower_components/moneylover-bower/fontawesome-iconpicker/fontawesome-iconpicker.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon m--hide">
                            <i class="la la-gear"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            Form Edit Role
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->
            <form class="m-form" action="{{ route('role.set_role', $user->id) }}" method="POST">
                @csrf
                <div class="m-portlet__body">
                    <div class="khoi" data-index=1>
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group">
                                <label for="example_input_full_name">Name:</label>
                                <input type="text" name="name" class="form-control m-input" placeholder="Enter name" value="{{ old('name', $user->name) }}">
                            </div>
                        </div>
                        <div class="m-form__section m-form__section--first">
                            <div class="form-group m-form__group">
                                <label for="example_input_full_name">Email:</label>
                                <input type="text" name="email" class="form-control m-input" value="{{ old('email', $user->email) }}" readonly="readonly">
                            </div>
                        </div>
                        <select name="role_id" class="browser-default custom-select">
                            @foreach ($roleList as $item)
                            <option 
                            @if (!empty($user->role->first()) && $item->id == $user->role->first()->id)
                            selected="selected"
                            @endif
                            value="{{ $item->id}}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Cancel</button>
                    </div>
                </div>
            </form>

            <!--end::Form-->
        </div>

        <!--end::Portlet-->

    </div>
</div>
@endsection

@section('script')

@endsection
