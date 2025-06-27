{{ $address->name }}</br>
{{ $address->address1 }}</br>
{{ $address->city }}/{{ $address->state }} - CEP {{ $address->postcode }}
{{ core()->country_name($address->country) }} </br></br>
{{ __('shop::app.checkout.onepage.contact') }}: {{ $address->phone }}</br>
{{ __('shop::app.checkout.onepage.taxvat') }}: {{ $address->taxvat }}