<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="container">
    <div class="alert alert-danger">
        {ERROR}
    </div>
</div>
<!-- END: error -->

<h3>{LANG.add_time}</h3>
<div class="container">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">{LANG.id}</th>
                <th class="text-center">{LANG.room}</th>
                <th class="text-center">{LANG.user}</th>
                <th class="text-center">{LANG.check_in}</th>
                <th class="text-center">{LANG.check_out}</th>
                <th class="text-center">{LANG.total_price}</th>
                <th class="text-center">{LANG.status}</th>
                <th class="text-center">{LANG.func}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: booking -->
            <tr>
                <td class="text-center">{BOOKING.booking_id}</td>
                <td>{BOOKING.room_name}</td>
                <td>{BOOKING.user_name}</td>
                <td>{BOOKING.checkin}</td>
                <td>{BOOKING.checkout}</td>
                <td>{BOOKING.total_price}₫
                </td>
                <td class="text-center">
                    {BOOKING.status_label}
                </td>
            </tr>
            <!-- END: booking -->
        </tbody>
    </table>
</div>
<!-- END: main -->
