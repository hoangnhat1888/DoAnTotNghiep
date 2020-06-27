@extends('master')

@section('head')

@yield('childHead')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.smartmenus/1.1.0/css/sm-blue/sm-blue.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.smartmenus/1.1.0/jquery.smartmenus.min.js"></script>

@endsection

@section('body')

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xl-12">
				@yield('content')
			</div>
		</div>
		<div class="row">
			<div class="col-xl-12 copyright">
				© 2019, {{ $config['setting']->website_owner }}, All rights reserved
			</div>
		</div>
		<script>
			var cart = {};

			function addToCart(id, quantity = 1) {
				cart[id] = cart[id] ? cart[id] + quantity : quantity;

				cookies.setData('cart', JSON.stringify(cart));
				refreshCart();
			}

			function removeFromCart(id) {
				delete(cart[id]);

				cookies.setData('cart', JSON.stringify(cart));
				location.reload();
			}

			function updateWantQuantity(id, quantity) {
				cart[id] = Number(quantity);
			}

			function updateCart() {
				cookies.setData('cart', JSON.stringify(cart));
				location.reload();
			}

			function clearCart(need_confirm = true) {
				if (need_confirm) {
					if (confirm('Bạn có chắc chắn muốn xóa giỏ hàng?')) {
						cookies.setData('cart', JSON.stringify({}));
						location.reload();
					}
				} else {
					cookies.setData('cart', JSON.stringify({}));
					location.href = '/';
				}
			}

			function refreshCart() {
				getCart();

				$("#my-cart").html(Object.keys(cart).length);
			}

			function getCart() {
				try {
					cart = JSON.parse(cookies.getData('cart'))
				} catch (err) {
					cart = {}
				}

				for (k in cart) {
					if (!Number.isInteger(cart[k]) || cart[k] < 1) {
						delete(cart[k]);
					}
				}
				cookies.setData('cart', JSON.stringify(cart));
			}

			$(document).ready(function() {
				refreshCart();
			});
		</script>

		@include('dialog')
	</div>

	<script>
		function showMessage(message) {
			$('#message').html(message);
			$('#messageModal').modal();
		}
	</script>
</body>

@endsection