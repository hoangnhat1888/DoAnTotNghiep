@extends('master')

@section('head')

@yield('childHead')

<!--begin::Global Theme Styles(used by all pages) -->
<link rel="stylesheet" href="./metronic/css/style.bundle.min.css" />

<!--end::Global Theme Styles -->

<!--begin::Layout Skins(used by all pages) -->
<link rel="stylesheet" href="./metronic/css/skins/header/base/light.min.css" />
<link rel="stylesheet" href="./metronic/css/skins/header/menu/light.min.css" />
<link rel="stylesheet" href="./metronic/css/skins/brand/dark.min.css" />
<link rel="stylesheet" href="./metronic/css/skins/aside/dark.min.css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.4.0/css/perfect-scrollbar.min.css" />
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" /> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" />

<!--end::Layout Skins -->

@endsection

@section('body')

<?php

use App\Role\RoleChecker;
use App\Role\UserRole;
use Illuminate\Support\Str;

function isSelectedMenu($link = '')
{
	if ($link) {
		return Str::startsWith(url()->current(), route('admin') . ($link ? '/' . $link : '')) ? 'kt-menu__item--open' : '';
	} else {
		return url()->current() === route('admin') ? 'kt-menu__item--open' : '';
	}
}
?>

<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
	<!-- begin:: Page -->

	<!-- begin:: Header Mobile -->
	<div id="kt_header_mobile" class="kt-header-mobile kt-header-mobile--fixed ">
		<div class="kt-header-mobile__logo">
			<a href="{{ route('admin') }}">
				<img alt="Logo" src="{{ $config['setting']->logo }}" />
			</a>
		</div>
		<div class="kt-header-mobile__toolbar">
			<button class="kt-header-mobile__toggler" id="kt_aside_mobile_toggler"><span></span></button>
			<button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
		</div>
	</div>

	<!-- end:: Header Mobile -->
	<div class="kt-grid kt-grid--hor kt-grid--root">
		<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

			<!-- begin:: Aside -->
			<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
			<div class="kt-aside kt-aside--fixed kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

				<!-- begin:: Aside -->
				<div class="kt-aside__brand kt-grid__item " id="kt_aside_brand">
					<div class="kt-aside__brand-logo">
						<a href="{{ route('admin') }}">
							<img alt="Logo" src="{{ $config['setting']->logo }}" />
						</a>
					</div>
					<div class="kt-aside__brand-tools">
						<button class="kt-aside__brand-aside-toggler" id="kt_aside_toggler">
							<span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon id="Shape" points="0 0 24 0 24 24 0 24" />
										<path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" id="Path-94" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) " />
										<path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" id="Path-94" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) " />
									</g>
								</svg></span>
							<span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon id="Shape" points="0 0 24 0 24 24 0 24" />
										<path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" id="Path-94" fill="#000000" fill-rule="nonzero" />
										<path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" id="Path-94" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) " />
									</g>
								</svg></span>
						</button>
					</div>
				</div>
				<!-- end:: Aside -->

				<!-- begin:: Aside Menu -->
				<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
					<div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
						<ul class="kt-menu__nav">
							<li class="kt-menu__item kt-menu__item--submenu {{ isSelectedMenu() }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
								<a href="{{ route('admin') }}" class="kt-menu__link kt-menu__toggle">
									<span class="kt-menu__link-text">
										<i class="fas fa-home"></i>{{ __('home') }}<i class="fas fa-chevron-right"></i>
									</span>
								</a>
							</li>
							@if (RoleChecker::check(auth()->user(), UserRole::ADMIN))
							<li class="kt-menu__item kt-menu__item--submenu {{ isSelectedMenu('users') }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
								<a href="{{ route('admin') }}/users" class="kt-menu__link kt-menu__toggle">
									<span class="kt-menu__link-text">
										<i class="fas fa-users"></i>{{ __('usersManagement') }}<i class="fas fa-chevron-right"></i>
									</span>
								</a>
							</li>
							@endif
							@if (RoleChecker::check(auth()->user(), UserRole::MANAGEMENT))
							<li class="kt-menu__item kt-menu__item--submenu {{ isSelectedMenu('settings') }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
								<a href="{{ route('admin') }}/settings" class="kt-menu__link kt-menu__toggle">
									<span class="kt-menu__link-text">
										<i class="fas fa-cog"></i>{{ __('settingsManagement') }}<i class="fas fa-chevron-right"></i>
									</span>
								</a>
							</li>
							@endif
							@if (RoleChecker::check(auth()->user(), UserRole::MANAGEMENT))
							<li class="kt-menu__item kt-menu__item--submenu {{ isSelectedMenu('template') }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
								<a href="{{ route('admin') }}/template" class="kt-menu__link kt-menu__toggle">
									<span class="kt-menu__link-text">
										<i class="fas fa-book-open"></i>{{ __('templateManagement') }}<i class="fas fa-chevron-right"></i>
									</span>
								</a>
							</li>
							@endif
							@if (RoleChecker::check(auth()->user(), UserRole::MANAGEMENT))
							<li class="kt-menu__item kt-menu__item--submenu {{ isSelectedMenu('template-exports') }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
								<a href="{{ route('admin') }}/template-exports" class="kt-menu__link kt-menu__toggle">
									<span class="kt-menu__link-text">
										<i class="fas fa-archive"></i>{{ __('exportManagementTemplate') }}<i class="fas fa-chevron-right"></i>
									</span>
								</a>
							</li>
							@endif

							@if (RoleChecker::check(auth()->user(), UserRole::MANAGEMENT))
							<li class="kt-menu__item kt-menu__item--submenu {{ isSelectedMenu('work-schedule') }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
								<a href="{{ route('admin') }}/work-schedule" class="kt-menu__link kt-menu__toggle">
									<span class="kt-menu__link-text">
										<i class="fas fa-calendar-alt"></i>{{ __('workScheduleManagement') }}<i class="fas fa-chevron-right"></i>
									</span>
								</a>
							</li>
							@endif

							@if (RoleChecker::check(auth()->user(), UserRole::MANAGEMENT))
							<li class="kt-menu__item kt-menu__item--submenu {{ isSelectedMenu('templates') }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
								<a href="{{ route('admin') }}/templates" class="kt-menu__link kt-menu__toggle">
									<span class="kt-menu__link-text">
										{{-- <i class="fas fa-cog"></i>{{ __('workScheduleManagement') }}<i class="fas fa-chevron-right"></i> --}}
										<i class="fas fa-file-signature"></i></i>{{ __('contractManagement') }}<i class="fas fa-chevron-right"></i>
									</span>
								</a>
							</li>
							@endif

							@if (RoleChecker::check(auth()->user(), UserRole::MANAGEMENT))
							<li class="kt-menu__item kt-menu__item--submenu {{ isSelectedMenu('work-off') }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
								<a href="{{ route('admin') }}/work-off" class="kt-menu__link kt-menu__toggle">
									<span class="kt-menu__link-text">
										<i class="far fa-calendar-times"></i>{{__('daysOffPermissionManagement')}}<i class="fas fa-chevron-right"></i>
									</span>
								</a>
							</li>
							@endif

							@if (RoleChecker::check(auth()->user(), UserRole::MANAGEMENT))
							<li class="kt-menu__item kt-menu__item--submenu {{ isSelectedMenu('listEmployee') }}" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
								<a href="{{ route('admin') }}/list-employee" class="kt-menu__link kt-menu__toggle">
									<span class="kt-menu__link-text">
										{{-- <i class="fas fa-cog"></i>{{ __('listEmployeeManagement') }}<i class="fas fa-chevron-right"></i> --}}
										<i class="fas fa-address-book"></i>{{ __('listEmployee') }}<i class="fas fa-chevron-right"></i>
									</span>
								</a>
							</li>
							@endif

						</ul>
					</div>
				</div>

				<!-- end:: Aside Menu -->
			</div>

			<!-- end:: Aside -->
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

				<!-- begin:: Header -->
				<div id="kt_header" class="kt-header kt-grid__item kt-header--fixed ">

					<!-- begin:: Header Menu -->
					<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
					<div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
						<div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile kt-header-menu--layout-default ">
							<ul class="kt-menu__nav ">
								<li class="kt-menu__item kt-menu__item--open kt-menu__item--here kt-menu__item--submenu kt-menu__item--rel kt-menu__item--open kt-menu__item--here kt-menu__item--active" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
									<a href="/"><button class="btn btn-primary">{{ __('home' )}}</button></a>
								</li>
							</ul>
						</div>
					</div>
					<!-- end:: Header Menu -->

					<!-- begin:: Header Topbar -->
					<div class="kt-header__topbar">

						<!--begin: Language bar -->
						<div class="kt-header__topbar-item kt-header__topbar-item--langs">
							<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
								<span class="kt-header__topbar-icon">
									<img src="images/{{ session('locale', config('app.locale')) }}.png" alt="{{ session('locale', config('app.locale')) }}" />
								</span>
							</div>
							<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround">
								<ul class="kt-nav kt-margin-t-10 kt-margin-b-10">
									<li class="kt-nav__item kt-nav__item--active">
										<a href="{{ route('admin') }}?lang=vi&url={{ url()->current() }}" class="kt-nav__link">
											<span class="kt-nav__link-icon"><img src="images/vi.png" alt="vi" /></span>
											<span class="kt-nav__link-text">{{ __('vietnamese') }}</span>
										</a>
									</li>
									<li class="kt-nav__item">
										<a href="{{ route('admin') }}?lang=en&url={{ url()->current() }}" class="kt-nav__link">
											<span class="kt-nav__link-icon"><img src="images/en.png" alt="en" /></span>
											<span class="kt-nav__link-text">{{ __('english') }}</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
						<!--end: Language bar -->

						<!--begin: User Bar -->
						<div class="kt-header__topbar-item kt-header__topbar-item--user">
							<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
								<div class="kt-header__topbar-user">
									<span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
									<span class="kt-header__topbar-username kt-hidden-mobile">{{ auth()->user()->username }}</span>
									<img alt="{{ auth()->user()->username }}" src="{{ auth()->user()->image }}" />
								</div>
							</div>
							<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">

								<!--begin: Head -->
								<div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url(./metronic/media/misc/bg-1.jpg)">
									<div class="kt-user-card__avatar">
										<img alt="{{ auth()->user()->username }}" src="{{ auth()->user()->image }}" />
									</div>
									<div class="kt-user-card__name">
										{{ auth()->user()->username }}
									</div>
									<div class="kt-user-card__badge">
										<a href="{{ route('admin') }}/account"><button class="btn btn-success">{{ __('profile') }}</button></a>
									</div>
								</div>

								<!--end: Head -->

								<!--begin: Navigation -->
								<div class="kt-notification">
									<div class="kt-notification__custom kt-space-between">
										<a class="btn btn-label btn-label-brand btn-sm btn-bold" onclick="$('#logout-form').submit();">{{ __('logout') }}</a>
										<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
											@csrf
										</form>
									</div>
								</div>

								<!--end: Navigation -->
							</div>
						</div>

						<!--end: User Bar -->
					</div>

					<!-- end:: Header Topbar -->
				</div>

				<!-- end:: Header -->
				<div class="kt-content kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
					<!-- begin:: Sub Header -->
					@yield('sub-header')

					<!-- end:: Sub Header -->

					<!-- begin:: Content -->
					@include('errors')
					@yield('content')

					<!-- end:: Content -->
				</div>

				<!-- begin:: Footer -->
				<div class="kt-footer kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer">
					<div class="kt-container kt-container--fluid ">
						<div class="kt-footer__copyright">
							2019&nbsp;&copy;&nbsp;<a href="https://bittosolution.vn" target="_blank" class="kt-link">BitToSolution</a>
						</div>
					</div>
				</div>

				<!-- end:: Footer -->
			</div>
		</div>
	</div>

	<!-- end:: Page -->

	<!-- begin::Scrolltop -->
	<div id="kt_scrolltop" class="kt-scrolltop">
		<i class="fa fa-arrow-up"></i>
	</div>

	<!-- end::Scrolltop -->

	<!-- begin::Global Config(global config for global JS sciprts) -->
	<script>
		var KTAppOptions = {
			"colors": {
				"state": {
					"brand": "#5d78ff",
					"dark": "#282a3c",
					"light": "#ffffff",
					"primary": "#5867dd",
					"success": "#34bfa3",
					"info": "#36a3f7",
					"warning": "#ffb822",
					"danger": "#fd3995"
				},
				"base": {
					"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
					"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
				}
			}
		};
	</script>

	<!-- end::Global Config -->

	<!--begin:: Global Mandatory Vendors -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.0/js.cookie.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tooltip.js/1.3.2/umd/tooltip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.4.0/perfect-scrollbar.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sticky-js/1.2.0/sticky.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/wnumb/1.1.0/wNumb.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>

	<!--end:: Global Mandatory Vendors -->

	<!--begin::Global Theme Bundle(used by all pages) -->
	<script src="./metronic/js/scripts.bundle.min.js"></script>

	<!--end::Global Theme Bundle -->

	<script>
		async function getBase64(file, isFile = true) {
			if (!isFile) {
				return file;
			} else {
				return new Promise((resolve) => {
					var reader = new FileReader();
					reader.readAsDataURL(file);
					reader.onload = () => {
						resolve(reader.result);
					};
					reader.onerror = (error) => {
						console.log('Error: ', error);
					};
				});
			}
		}

		async function previewImage(event) {
			var target = $(event.target)[0];

			if (target.files.length) {
				const file = target.files[0];
				$($(target).prev('img')[0]).attr('src', await getBase64(file));
			}
		}

		function backToPreviousPage() {
			@if(isset($_SERVER['HTTP_REFERER']))

			var previousUrl = '{{ $_SERVER["HTTP_REFERER"] }}';
			while (previousUrl.includes('amp;')) {
				previousUrl = previousUrl.replace('amp;', '');
			}
			location.href = previousUrl;

			@else

			location.href = '{{ route("admin") }}';

			@endif
		}

		function addItem(url = null) {
			location.href = (url ? url : location.pathname) + '/create';
		}

		function setRowClickEvent() {
			// $('.kt-datatable__row').each(function() {
			// 	if ($($(this).children()[0]).prop('tagName') !== 'TH') {
			// 		var isFirst = true;
			// 		var id;
			// 		$(this).children().each(function() {
			// 			if (isFirst) {
			// 				isFirst = false;
			// 				id = $(this).find('input[type="checkbox"]').val();
			// 			} else {
			// 				$(this).click(function() {
			// 					if (id) {
			// 						editItem(id);
			// 					}
			// 				});
			// 			}
			// 		});
			// 	}
			// });

			$('.datatable tr').click(function() {
				if ($($(this).children()[0]).prop('tagName') !== 'TH') {
					var id = $(this).find('input[type=checkbox]').val();
					if (id) {
						editItem(id);
					}
				}
			});

			$('.datatable tr td:first-child').children().each(function() {
				$(this).parent().click(function(e) {
					e.stopPropagation();
				});
			});
		}

		function editItem(id, url = null) {
			location.href = (url ? url : location.pathname) + '/' + id + '/edit';
		}

		function deleteItems(url = null) {
			let chkCheckeds = $('.datatable').find('input[type=checkbox]:checked');

			if (chkCheckeds.length) {
				if (!confirm('{{ __("C001") }}')) {
					return;
				}
			}

			chkCheckeds.each(function() {
				var id = $(this).val();

				$.ajax({
					url: (url ? url : location.pathname) + '/' + id,
					method: 'POST',
					data: {
						'_method': 'DELETE',
						'_token': '{{ csrf_token() }}'
					},
					success: function(result) {
						if ($(chkCheckeds[chkCheckeds.length - 1]).val() === id) {
							location.reload();
						}
					}
				});
			});
		}
	</script>
</body>

@endsection
