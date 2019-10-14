
@foreach($products as $product)
	<div class="card" style="">
		<img class="card-img-top" src="/{{ $product->images->find(1)->pivot->filepath }}" alt="Card image cap">
		<div class="card-body">
			<h5 class="card-title">{{ $product->name }}</h5>
				<ul class="list-group pb-2">
				@foreach ($product->properties as $prop)
					<li class="list-group-item p-1"><b>{{ $prop->name }}</b>: {{ $prop->pivot->content}}</li>
					{{-- <li><div><b>{{ $prop->name }}</b>:</div></li> --}}
				@endforeach
				</ul>
			<div class="row align-items-baseline">
				<div class="col">
					<div class="">
						@isset($product->rrp)
						<b><small><del class="text-muted">{{ $product->coin }}{{ $product->rrp }}</del></small></b>
						@endisset
						<b><div class="text-danger h3">{{ $product->coin }}{{ $product->price }}</div></b>

					</div>
				</div>
				<div class="col">
					@auth
					<div class="dropdown">
						<button class="btn btn-primary dropdown-toggle" type="button" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Add to whislist
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" data-prid='{{ $product->id }}'>
							<a class="dropdown-item" href="{{ route('wishlist.create') }}">New Wishlist</a>
							<div class="dropdown-divider"></div>

							@foreach ( Auth::user()->wishlists as $wl)
							<?php
								$added = '';
								if(App\Wishlist::find($wl->id)->products->find($product->id)) {
									$added = 'bg-primary';
								}
							?>
								<a class="dropdown-item wl {{ $added }}" data-wlid="{{ $wl->id }}" href="javascript:void(0)"> {{ $wl->name }}</a>
							@endforeach

						</div>
					</div>
					@endauth
				</div>
			</div>
		</div>
	</div>
@endforeach


@section('scripts')

<script type="text/javascript">

window.onload = function() {


	$(".wl").click(function(e){
		e.preventDefault();

		let wl = $(this);
		let wishlist_id = wl.data('wlid');
		let product_id = wl.parent().data('prid')



		let headers = {
			"Content-Type": "application/json",
			"accept": "application/json, text-plain, */*",
			'X-CSRF-TOKEN': '{{ csrf_token() }}',
			'X-Requested-With': 'XMLHttpRequest' ,
		}
		console.log(wl.hasClass('bg-primary'));

		if ( wl.hasClass('bg-primary') ) {

			let ajaxRoute = '{{ route('wishlist.ajax.product.detach',[':wishlist_id', ':product_id']) }} ';
			ajaxRoute = ajaxRoute.replace(':wishlist_id', wishlist_id);
			ajaxRoute = ajaxRoute.replace(':product_id', product_id);

			console.log(ajaxRoute);
			fetch( ajaxRoute, {
				headers: headers,
				credentials: "same-origin",
				method: 'PUT',
				body: JSON.stringify({
					product_id: product_id
				}),
				// body: { '_token': form[0].value, 'name': 'juenito' },
			}).then(function(resp) {
				if(resp.ok) {
					// console.log(resp);
					wl.removeClass('bg-primary');
				}
				return resp.json;
			})
		} else {

			let ajaxRoute = '{{ route('wishlist.ajax.update',':wishlist_id') }}';
			ajaxRoute = ajaxRoute.replace(':wishlist_id', wishlist_id, );

			fetch( ajaxRoute, {
				headers: headers,
				credentials: "same-origin",
				method: 'PUT',
				body: JSON.stringify({
					product_id: product_id
				}),
				// body: { '_token': form[0].value, 'name': 'juenito' },
			}).then(function(resp) {
				if(resp.ok) {
					// console.log(resp);
					wl.addClass('bg-primary');
				}
				return resp.json;
			})
		}

	});


};

</script>


@endsection