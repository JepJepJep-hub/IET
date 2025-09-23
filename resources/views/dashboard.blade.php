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
                        <td>
                        <button type="button" onclick='openEditModal(@json($expense))'>Edit</button>

                            <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this expense?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </td>
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

    {{-- edit expense --}}

    <div id="editModal" 
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
            background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
        <div style="background:white; padding:10px; border-radius:8px; width:400px;">
            <h2>Edit Data</h2>

            <form id="editModal" method="POST">
                @csrf
                @method('PUT')

                <label>Category:</label>
                <select name="category" id="editCategory" required>
                    <option value="student">Business</option>
                    <option value="teacher">Tax</option>
                    <option value="admin">Admin</option>
                    <option value="guest">Guest</option>
                </select>

                <br><br>

                <label>Amount:</label>
                <input type="text" name="amount" id="editAmount" required>

                <br><br>

                <label>Description:</label>
                <input type="text" name="description" id="editDescription">

                <br><br>

                <button type="submit">Save</button>
                <button type="button" onclick="closeEditModal()">Cancel</button>
            </form>
        </div>
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
                    <td>
                        <button type="button" onclick="openEditModal({{ $income->id }}, 
                        '{{ $income->category }}', 
                        '{{ $income->amount }}', 
                        '{{ $income->description }}')">Edit</button>

                        <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this expense?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
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

    {{-- Income Edit popup --}}

        <div id="editIncomeModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
        <div style="background:white; padding:10px; border-radius:8px; width:400px;">
            <h2>Edit Expense</h2>

            <form id="editExpenseForm" method="POST">
                @csrf
                @method('PUT')

                <label>Category:</label>
                <select name="category" id="editCategory" required>
                    <option value="student">Category</option>
                    <option value="teacher">Sales</option>
                    <option value="admin">Services</option>
                    <option value="guest">Other</option>
                </select>

                <br><br>

                <label>Amount:</label>
                <input type="text" name="amount" id="editAmount" required>

                <br><br>

                <label>Description:</label>
                <input type="text" name="description" id="editDescription">

                <br><br>

                <button type="submit">Save</button>
                <button type="button" onclick="closeEditModal()">Cancel</button>
            </form>
        </div>
    </div>


    {{-- Logout, temporary --}}
    <form action="/logout" method="POST" style="margin-top:20px;">
        @csrf
        <button type="submit">Logout</button>
    </form>



    {{-- Edit Expense Script --}}
    <script>
        function openEditModal(expense) {
        document.getElementById('editCategory').value = expense.category ?? '';
        document.getElementById('editAmount').value = expense.amount ?? '';
        document.getElementById('editDescription').value = expense.description ?? '';
        document.getElementById('editExpenseForm').action = '/expenses/' + expense.id;
        document.getElementById('editModal').style.display = 'flex'; // modal appears centered
        }

        function closeEditModal() 
        {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>
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