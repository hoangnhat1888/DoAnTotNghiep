@extends('admin.master')

@section('childHead')

<title>{{ __('timeInOutManagement') }}</title>


@endsection

<?php

use App\Role\RoleChecker;
use App\Role\UserRole;

?>
@section('sub-header')

<div class="margin-sub-header"></div>
<div class="kt-subheader kt-grid__item" id="kt_subheader">
	<div class="kt-container kt-container--fluid ">
		<div class="kt-subheader__main">
			<h3 class="kt-subheader__title">{{ __('timeInOutManagement') }}</h3>
			<span class="kt-subheader__separator kt-subheader__separator--v"></span>{{ strtoupper($name) }}
		</div>
	</div>
</div>

@endsection

@section('content')

<div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
	<div class="kt-portlet kt-portlet--mobile">

	    <div class="kt-portlet__head">
			<div class="kt-portlet__head-label">
				<button type="button" class="btn btn-primary back" onclick="backToPreviousPage();">
					<i class="fas fa-angle-double-left">&nbsp;</i>
				</button>
				<h3 class="kt-portlet__head-title">
					{{ __('timeInOutManagement') }} <i class="fas fa-angle-double-right"></i> {{ __('edit') }}
				</h3>
			</div>
		</div>

        <form method="POST" action="admin/list-employee/{{$work->id}}">
            @csrf
            @method('PATCH')
            <div class="kt-portlet__body">
				<div class="row">

                    <div class="col-xl-3">
                        <label  class="col-form-label"> User_id</label>
                    </div>
                    <div class="col-xl-9">
                        <input class="form-control" type='text' name='user_id' value = "{{$work->user_id}}" readonly >
                    </div>
                    <div class="col-xl-3">
                        <label class="col-form-label">Trạng thái: </label>
                    </div>
                    <div class="col-xl-9">
                        <input class="form-control" type='text' name='direction' value="{{$work->direction}}">
                        <!-- <select class="form-control" value="{{$work->direction}}"> -->
                            <!-- <option name='direction' value="in">In</option> -->
                            <!-- <option name='direction' value="out">Out</option> -->
                        <!-- </select> -->
                    </div>
                    <div class="col-xl-3">
                        <label class="col-form-label">Ngày: </label>
                    </div>
                    <div class="col-xl-9">
                    <input class="form-control" type='date' name='interactive_date' value = "{{$work->interactive_date}}">
                    </div>
                    <div class="col-xl-3">
                        <label class="col-form-label">Giờ: </label>
                    </div>
                    <div class="col-xl-9">
                    <input class="form-control" type='time' name='interactive_time' value = "{{$work->interactive_time}}">
                    </div>

                </div>

                <div class="kt-portlet__foot">
					<div class="kt-form__actions">
                        <button type='submit' class="btn btn-primary">{{ __('edit') }}</button>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>

@endsection