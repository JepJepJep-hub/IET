<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IET Dashboard</title>
</head>
<body>
    
    <h1>Hello, {{ Auth::user()->name }}! This is your dashboard.</h1>
    @if(session('login_success'))
        <script>
            alert('Login was successful!');
        </script>
    @endif

    {{-- Expense Part --}}
    <div>
        <h2>Expense</h2>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $expense)
                    <tr>
                        <td>{{ $expense->id }}</td>
                        <td>{{ $expense->category }}</td>
                        <td>{{ $expense->amount }}</td>
                        <td>{{ $expense->description }}</td>
                        <td>{{ $expense->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id ="AddExpense">
        <form action="{{ route('expenses.add') }}" method="POST" style="margin-top:20px;">
            @csrf
            <h2>Add New Expense</h2>
            <select name="category" required>
                <option value="">Select Category</option>
                <option value="student">Business</option>
                <option value="teacher">Tax</option>
                <option value="admin">Admin</option>
                <option value="guest">Guest</option>
            </select>
            <input name="amount" type="text" step="0.01" placeholder="Amount" required>
            <input name="description" type="text" placeholder="Description">
            <button type="submit">Add Expense</button>
        </form>
    </div>

    {{-- Income Part --}}
    
    <div>
        
    </div>

    {{-- Logout, temporary --}}
    <form action="/logout" method="POST" style="margin-top:20px;">
        @csrf
        <button type="submit">Logout</button>
    </form>

</body>
</html> 