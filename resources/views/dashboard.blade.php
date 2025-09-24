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
                <option value="Business">Business</option>
                <option value="Tax">Tax</option>
                <option value="Labor">Labor</option>
                <option value="Others">Others</option>
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
                    <td>
                        <button type="button" onclick='openEditIncomeModal(@json($income))'>Edit</button>

                        <form action="{{ route('income.destroy', $income->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this income?');">
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
                    <option value="">Category</option>
                    <option value="Sales">Sales</option>
                    <option value="Services">Services</option>
                    <option value="Royalty">Royalty</option>
                    <option value="Other">Other</option>
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

        {{-- edit expense --}}

    <div id="editExpenseModal" 
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
            background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
        <div style="background:white; padding:10px; border-radius:8px; width:400px;">
            <h2>Edit Data</h2>

            <form id="editExpenseForm" method="POST">
                @csrf
                @method('PUT')

                <label>Category:</label>
                <select name="category" id="editCategory" required>
                    <option value="">Select Category</option>
                    <option value="Business">Business</option>
                    <option value="Tax">Tax</option>
                    <option value="Labor">Labor</option>
                    <option value="Others">Others</option>
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

            {{-- edit income --}}

    <div id="editIncomeModal" 
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
            background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
        <div style="background:white; padding:10px; border-radius:8px; width:400px;">
            <h2>Edit Data</h2>

            <form id="editIncomeForm" method="POST">
                @csrf
                @method('PUT')

                <label>Category:</label>
                <select name="category" id="editIncomeCategory" required>
                    <option value="">Category</option>
                    <option value="Sales">Sales</option>
                    <option value="Services">Services</option>
                    <option value="Royalty">Royalty</option>
                    <option value="Other">Other</option>
                </select>

                <br><br>

                <label>Amount:</label>
                <input type="text" name="amount" id="editIncomeAmount" required>

                <br><br>

                <label>Description:</label>
                <input type="text" name="description" id="editIncomeDescription">

                <br><br>

                <button type="submit">Save</button>
                <button type="button" onclick="closeEditModal()">Cancel</button>
            </form>
        </div>
    </div>




    {{-- Edit table --}}
    <script>
        function openEditModal(expense) {
        document.getElementById('editCategory').value = expense.category ?? '';
        document.getElementById('editAmount').value = expense.amount ?? '';
        document.getElementById('editDescription').value = expense.description ?? '';
        document.getElementById('editExpenseForm').action = '/expenses/' + expense.id;
        document.getElementById('editExpenseModal').style.display = 'flex'; // modal appears centered
        }

        function closeEditModal() 
        {
            document.getElementById('editExpenseModal').style.display = 'none';
            document.getElementById('editIncomeModal').style.display = 'none';
        }

        function openEditIncomeModal(income) 
        {
        document.getElementById('editIncomeCategory').value = income.category ?? '';
        document.getElementById('editIncomeAmount').value = income.amount ?? '';
        document.getElementById('editIncomeDescription').value = income.description ?? '';
        document.getElementById('editIncomeForm').action = '/income/' + income.id;
        document.getElementById('editIncomeModal').style.display = 'flex'; // modal appears centered
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