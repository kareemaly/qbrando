@foreach($order->paypalPayments as $payment)
<table class="table table-striped table-detail-view">
    <thead>
    <tr>
        <th colspan="2"><li class="icol-money-euro"></li> Paypal Payment</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th>Gross amount</th>
        <td>
            {{ $payment->grossAmount->format() }}
        </td>
    </tr>
    @if($payment->feeAmount)
    <tr>
        <th>Fee amount</th>
        <td>
            {{ $payment->feeAmount->format() }}
        </td>
    </tr>
    @endif
    <tr>
        <th>Transaction id</th>
        <td>{{ $payment->transaction_id }}</td>
    </tr>
    <tr>
        <th>Payment status</th>

        @if($payment->hasReceived())
        <td><span class="label label-success">RECEIVED</span></td>
        @elseif($payment->isAwaiting())
        <td><span class="label label-warning">AWAITING</span></td>
        @else
        <td><span class="label label-important">CANCELED</span></td>
        @endif
    </tr>
    </tbody>
</table>
@endforeach