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

    <div>
        <canvas id="myChart"></canvas>
    </div>

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
    
    <h2>Income</h2>
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
            @foreach($incomes as $income)
                <tr>
                    <td>{{ $income->id }}</td>
                    <td>{{ $income->category }}</td>
                    <td>{{ $income->amount }}</td>
                    <td>{{ $income->description }}</td>
                    <td>{{ $income->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    <div id="AddIncome">
        <form action="{{ route('income.add') }}" method="POST" style="margin-top:20px;">
            @csrf
            <h2>Add New Income</h2>
            <select name="category" required>
                <option value="">Select Category</option>
                <option value="sales">Sales</option>
                <option value="services">Services</option>
                <option value="other">Other</option>
            </select>
            <input name="amount" type="text" step="0.01" placeholder="Amount" required>
            <input name="description" type="text" placeholder="Description">
            <button type="submit">Add Income</button>
        </form>
    </div>


    {{-- Logout, temporary --}}
    <form action="/logout" method="POST" style="margin-top:20px;">
        @csrf
        <button type="submit">Logout</button>
    </form>

</body>
    {{-- chartjs script --}}
<canvas id="expenseChart" width="400" height="200"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('expenseChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},   // PHP → JS
            datasets: [{
                label: 'Expenses by Category',
                data: {!! json_encode($data) !!},   // PHP → JS
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</html> 