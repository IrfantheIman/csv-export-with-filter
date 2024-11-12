<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Customers</title>
</head>
<body>
    <h1>Export Customers to CSV</h1>

    @if(session('message'))
        <div style="color: green;">{{ session('message') }}</div>
    @endif

    <!-- Form to apply filters -->
    <form action="{{ url('/export-customers') }}" method="POST">
        @csrf <!-- CSRF protection -->

        <div>
            <label for="fields">Select Filter Fields:</label><br>
            <input type="checkbox" id="name" name="fields[]" value="name">
            <label for="name">Name</label><br>
            <input type="checkbox" id="email" name="fields[]" value="email">
            <label for="email">Email</label><br>
            <input type="checkbox" id="phone" name="fields[]" value="phone">
            <label for="phone">Phone</label><br>
            <input type="checkbox" id="address" name="fields[]" value="address">
            <label for="address">Address</label><br>
        </div>

        <!-- Filter value input -->
        <div>
            <label for="filter_value">Filter Value:</label>
            <input type="text" id="filter_value" name="filter_value" placeholder="Enter filter value">
        </div>

        <!-- Submit button -->
        <div>
            <button type="submit">Export CSV</button>
        </div>
    </form>

</body>
</html>
