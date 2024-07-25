@extends('layouts.app')

@section('content')

<style>
    .id-column {
        width: 50px !important;
        max-width: 50px !important;
        min-width: 50px !important;
    }
</style>


<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-danger float-end me-5">Logout</button>
</form>

<form id="redirect-form" action="{{ route('employee.welcome') }}" method="GET" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-danger float-end me-5">Go to EMI Details</button>
</form>

<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div id="success_message">
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>
                    Loan Data
                        
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Client ID</th>
                                <th>No. Of Payment</th>
                                <th>First Payment Date</th>
                                <th>Last Payment Date</th>
                                <th>Loan Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
    $(document).ready(function () {

        fetchemployee();

        function fetchemployee() {
        debugger;
            $.ajax({
                type: "GET",
                url: "/fetch-loan-details",
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    $('tbody').html("");
                    $.each(response.employees, function (key, item) {
                        $('tbody').append('<tr>\
                            <td class="id-column">' + item.clientid + '</td>\
                            <td>' + item.num_of_payment + '</td>\
                            <td>' + item.first_payment_date + '</td>\
                            <td>' + item.last_payment_date + '</td>\
                            <td>' + item.loan_amount + '</td>\
                        \</tr>');
                    });
                }
            });
        }
    });

</script>

@endsection