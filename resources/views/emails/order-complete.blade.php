<!doctype html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order complete!</title>
</head>
<body>
заказ № {{ $order->id }} завершен
состав заказа
<table class="table">
    <thead>
    <tr>
        <th>Товар</th>
        <th>Количество</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($order->order_products as $orderProducts)
        <tr>
            <td>{{ $orderProducts->product->name }}</td>
            <td>
                {{ $orderProducts->quantity }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
стоимость заказа {{ $order->ordercost }}
</body>
</html>
