<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .table {
            width: 100%;
            margin-bottom: 20px;
        }
        h2 {
            color: blue;
        }
    </style>
</head>
<body>

    <table class="table">
        <tr>
            <td>Order Number:</td>
            <td>{{ $order->id }}</td>
            <td>Order Date:</td>
            <td>{{ $order->created_at }}</td>
        </tr>
        <tr>
            <td>Customer Name:</td>
            <td>{{ $order->first_name }} {{ $order->last_name }}</td>
            <td>Status:</td>
            <td>{{ $order->status }}</td>
        </tr>
    </table>

    {{-- <h2>{{ $ar->utf8Glyphs('تفاصيل الطلب') }}</h2> --}}
    <h2>Order Details</h2>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Item</th>
                <th scope="col">Qty</th>
                <th scope="col">Unit Price</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->price * $item->quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
