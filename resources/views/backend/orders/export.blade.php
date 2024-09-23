<table>
    <thead>
    <tr style="background: #1844c7; border: 1px solid">
        <th class="text-center" style="background: #1844c7; border: 1px solid; color: white; font-weight: bold;">Mã ĐH</th>
        <th  class="text-center" style="background: #1844c7; border: 1px solid; color: white; font-weight: bold;">Tên KH</th>
        <th class="text-center" style="background: #1844c7; border: 1px solid; color: white; font-weight: bold;">Số điện thoại</th>
        <th class="text-center" style="background: #1844c7; border: 1px solid; color: white;font-weight: bold;">Địa chỉ</th>
        <th class="text-center" style="background: #1844c7; border: 1px solid; color: white;font-weight: bold;">Tổng tiền</th>
        <th class="text-center" style="background: #1844c7; border: 1px solid; color: white;font-weight: bold;">Số lượng SP</th>
        <th class="text-center" style="background: #1844c7; border: 1px solid; color: white;font-weight: bold;">Chi tiết </th>
        <th class="text-center" style="background: #1844c7; border: 1px solid; color: white;font-weight: bold;">Phí Ship </th>
        <th class="text-center" style="background: #1844c7; border: 1px solid; color: white;font-weight: bold;">Trạng thái </th>
        <th class="text-center" style="background: #1844c7; border: 1px solid; color: white;font-weight: bold; ">Ngày đặt </th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $k=>$row)
        <tr style="border: 1px solid">
            <td style="width: 100%; border: 1px solid">#{{$row['id']}}</td>
            <td style="width: 100%; border: 1px solid">
                {{$row['fullname']}}
            </td>
            <td style="width: 100%; border: 1px solid">
                {{$row['phone']}}
            </td>
            <td style="width: 100%; border: 1px solid">
                {{$row['address']}}
            </td>
            <td style="width: 100%; border: 1px solid">
                {{number_format($row['total_price'])}} đ
            </td>

            <td style="width: 100%; border: 1px solid">{{ \App\Models\OrdersDetail::where('order_id', $row['id'])->count() }}</td>

            <td style="width: 100px; border: 1px solid; height: 20px ">
                    <?php
                    $ars = App\Models\OrdersDetail::where('order_id', $row['id'])->get();
                    foreach ($ars as $ar) {
                        $productName = \App\Models\Product::where('id', $ar['product_id'])->first();
                        echo '<p> -'.$productName['title'].' số lượng:  '.$ar['quantity'] .'</p>';
                    }
                    ?>
            </td>
            <td style="width: 100%; border: 1px solid">{{ number_format($row['shipping_fee']) }} đ</td>
            <td style="width: 100%; border: 1px solid">
                @if($row['status'] == 1)
                    Mới đặt
                @elseif($row['status'] == 2)
                    Đã xác nhận
                @elseif($row['status'] == 3)
                    Đang giao

                @elseif($row['status'] == 4)
                    Hoàn thành
                @elseif($row['status'] == 5)
                    Đã hũy
                @endif
            </td>
            <td style="width: 100%; border: 1px solid">
                {{$row['created_at']}}
            </td>


        </tr>
    @endforeach
    </tbody>
</table>
