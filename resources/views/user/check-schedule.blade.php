@extends('user.master')
@section('childHead')
<title>Index</title>
@endsection
@section('content')
<html>


    
    <head>
      <title>Bootstrap Example</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <style type="text/css">
            table, th, td {
                border: 5px solid purple;
            }
        </style>
    </head>
        
    <body>
    <div id="jquery-accordion-menu" class="jquery-accordion-menu">
        <ul>
            <li><a href="schedule/create"><i class="fa fa-glass"></i>Sign up for the calendar </a></li>
            <li><a href="booking-time-off"><i class="fa fa-glass"></i>Booking time off </a></li>
        </ul>
    </div>
    <h1>Schedule For Employee</h1>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">T2</th>
                    <th scope="col">T3</th>
                    <th scope="col">T4</th>
                    <th scope="col">T5</th>
                    <th scope="col">T6</th>
                    <th scope="col">T7</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        {{ $schedule['fullName'] }}
                    </td>
                    <td>
                        {{ $schedule['t2'] }}
                    </td>
                    <td>
                        {{ $schedule['t3'] }}
                    </td>
                    <td>
                        {{ $schedule['t4'] }}
                    </td>
                    <td>
                        {{ $schedule['t5'] }}
                    </td>
                    <td>
                        {{ $schedule['t6'] }}
                    </td>
                    <td>
                        {{ $schedule['t7'] }}
                    </td>
                </tr>
            </tbody>
        </table>

    <h1>Work Time</h1>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Name</th>
                    <th scope='col'>Work Time </th>
                    <th scope='col'>Salary</th>

                </tr>
            </thead>
            <tbody>
                <!-- @php $i=1; @endphp -->
                <tr>
                    <td>
                        {{ $schedule['fullName'] }}
                    </td>

                    <td>
                        {{ $work_time }}
                    </td>
                    <td>
                        {{ $salary }}
                    </td>
                </tr>
            </tbody>
        </table>

        <h1>Check Work Time</h1>
        <div class="scroll">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope='col'>Check In</th>
                        <th scope='col'>Check Out</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td>
                                {{ isset($check_schedule['fullName']) ? $check_schedule['fullName'] :"Không có"}}
                            </td>
                            <td>
                                {{ isset($check_schedule['in']) ? $check_schedule['in'] :"Chua có"}}
                            </td>
                            <td>
                                {{ isset($check_schedule['out']) ? $check_schedule['out'] :"Chua có"}}
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>
@endsection
