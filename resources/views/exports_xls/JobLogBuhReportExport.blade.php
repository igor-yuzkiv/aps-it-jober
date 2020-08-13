<table>
    <thead>
    <tr>
        <td><strong>Послуга</strong></td>
        <td><strong>Кількість</strong></td>
        <td><strong>Одиниця</strong></td>
        <td><strong>Ціна без ПДВ</strong></td>
        <td><strong>Ціна з ПДВ</strong></td>
        <td><strong>Сума буз ПДВ</strong></td>
    </tr>
    </thead>
    <tbody>
    @foreach($dataTable as $item)
        <tr>
            <td width="90">{{ $item->name }}</td>
            <td>1</td>
            <td>послуга</td>
            <td width="20">{{ $item->total_price }}</td>
            <td width="20">{{round(($item->total_price * 0.2) + $item->total_price, config("my.round.db")) }}</td>
            <td width="20">{{round(($item->total_price * 0.2) + $item->total_price, config("my.round.db")) }}</td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><strong>Разом:</strong></td>
        <td><strong>{!! round($total, config("my.round.public")) !!}</strong></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><strong>Сума ПДВ:</strong></td>
        <td><strong>{{round( $total * 0.2, config("my.round.public"))}}</strong></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><strong>Усього з ПДВ:</strong></td>
        <td><strong>{{round($total_pdv, config("my.round.public"))}}</strong></td>
    </tr>
    </tbody>
</table>
