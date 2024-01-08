{{-- <img src="{{ $message->embed("public/icons/blue-car-logo.png") }}"> --}}

<div style="display: flex; justify-content: center; gap: 5px">
  <img width="50" src="{{ $message->embed(public_path() . "/icons/blue-car-logo.png") }}">
  <h1 style="font-weight: bold; text-align: center">Order #{{ $order->id }}</h1>
</div>

<div style="display: flex; justify-content: space-around; gap: 10px; border: 1px solid black">
  <div>
    <h4>User Info</h4>
    <div>Name: {{ $user->name }}</div>
    <div>Email: {{ $user->email }}</div>
  </div>
  <div>
    <h4>Order Info</h4>
    <div>ID: {{ $order->id }}</div>
    <div>Number of Items: {{ count($items) }}</div>
    <div style="font-weight: bold">Grand Total: {{ number_format($order->total_decimal, 2, ',', '.') }}</div>
  </div>

</div>

<div style="border: 1px solid black; margin-top: 10px; padding: 5px">
  <h4>Order Items</h4>
  <div style="display: flex; justify-content: start; gap: 10px;">
    @foreach ($items as $item)
      <div>
        <div>Item ID: {{ $item->vehicle->id }}</div>
        <div>Price: {{ number_format($item->vehicle->price, 2, ',', '.') }}</div>
        <div>Quantity: {{ $item->quantity }}</div>
        <div>Total: {{ number_format($item->total, 2, ',', '.') }}</div>
        <img width="100" src="{{ $message->embed(public_path() . "/storage/images/vehicles/" . $item->vehicle->id . '/' . $item->vehicle->images[0]->img) }}">

      </div>
    @endforeach
  </div>
</div>


<style>

</style>