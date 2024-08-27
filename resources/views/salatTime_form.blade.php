<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="title">Salat Time Table</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Waqt name</th>
                    <th>Time</th>
                    <th>Action</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($waqts as $waqt)
                <tr>
                    <td><input type="text" class="name_{{$waqt->id }}" name="name" placeholder="waqt name" value="{{ old('name', $waqt->name) }}"></td>
                    <td><input type="time" class="time_{{$waqt->id }}" name="time" value="{{ old('time', $waqt->time ? date('H:i', strtotime($waqt->time)) : '') }}"></td>
                    <td><button class="btn updateButton" data-id="{{ $waqt->id }}">Edit</button></td>
                    <td><button class="btn deleteButton" data-id="{{ $waqt->id }}">Delete</button></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="text-align: center;"><button class="btn" id="createButton" data-id="{{ $waqt->id }}">Create New</button></div>
    </div>
    <div class="container hidden" id= "submitForm" style="margin-top:20px">
        <h1 class="title">Create a new salat waqt</h2>
        <form action="{{ URL::to('create_waqt') }}" method="post">
            <label for="name">Waqt Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>
            <div style="text-align: center;">
                <button class="btn" type="submit">Submit</button>
            </div>
            
        </form>
    </div>

</body>

<script>
    $(document).ready(function() {
        $('.updateButton').click(function() {
            var Id = $(this).data('id');
            var name = $('.name_'+Id).val();
            var time = $('.time_'+Id).val();
            console.log(name);

            $.ajax({
                url: '/update_waqt/' + Id,
                method: 'PUT',
                data: {
                    name: name,
                    time: time,
                    _token: '{{ csrf_token() }}' // Include CSRF token for security
                },
                success: function(response) {
                    alert(response.message);
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        $('.deleteButton').click(function() {
            var Id = $(this).data('id');

            $.ajax({
                url: '/delete_waqt/' + Id,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}' // Include CSRF token for security
                },
                success: function(response) {
                    alert(response.message);
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });

        $('#createButton').click(function() {
            $('#submitForm').removeClass('hidden');
        });
    });
</script>

<style type="text/css">
    body {
        font-family: Arial, sans-serif;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f4f4f4;
    }

    .container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 80%; /* Adjust width as needed */
        max-width: 800px; /* Maximum width */
    }

    .title {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    .table th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    .table input[type="text"] {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .table input[type="text"]:focus {
        border-color: #007bff;
        outline: none;
    }
    .buttons {
        display: flex;
        justify-content: space-between;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
        font-size: 16px;
        width: 70%; /* Adjust button width */
    }
    .deleteButton{
        background-color: red;
    }

    .deleteButton:hover {

        background-color: #c30010 !important;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    #createButton{
        margin-top:20px;
    }

    .container label {
        display: block;
        margin-bottom: 8px;
    }
    .container input {
        width: 90%;
        padding: 8px;
        margin-bottom: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .hidden{
        display: none;
    }
     
</style>

</html>
