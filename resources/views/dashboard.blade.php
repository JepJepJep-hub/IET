<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IET Dashboard</title>
        <link rel="icon" href="{{ asset('WebsiteLogo.png') }}" type="image/x-icon">
    @vite(['resources/js/app.js'])
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" >Dashboard</a>

        <button type="button" class="btn btn-sm btn-primary me-2" onclick="showBarChart()">Show Chart</button>

        <div class="d-flex align-items-center text-white">
        <span class="me-3">Hello, {{ Auth::user()->name }}!</span>
        <form action="/logout" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-sm mt-auto">Logout</button>
        </form>
        </div>
  </div>
</nav>

@if(session('login_success'))
  <script>
    alert('Login was successful!');
  </script>
@endif

  {{-- Expense Part --}}
<div class="container my-5">
    <h2 class="mb-4 text-center">Expense</h2>

    {{-- search bar --}}
    <div class="mb-3">
        <input 
            type="text" 
            id="expenseSearch" 
            class="form-control" 
            placeholder="🔍 Search expenses..."
        >
    </div>

    {{-- filter --}}
    <div class="d-flex align-items-center mb-3">
    <label for="filterExpenseCategory" class="me-2">Category:</label>
    <select id="filterExpenseCategory" class="form-select w-auto">
        <option value="">All</option>
        <option value="Business">Business</option>
        <option value="Tax">Tax</option>
        <option value="Labor">Labor</option>
        <option value="Others">Others</option>
    </select>
    <button type="button" class="btn btn-sm btn-secondary ms-3" onclick="filterExpenseByCategory()">Filter</button>
    </div>

    {{-- table --}}
    <div class="table-responsive">
        <table id="expensesTable" class="table table-striped table-bordered align-middle shadow-sm">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $expense)
                    <tr>
                        <td class="text-center">{{ $expense->id }}</td>
                        <td>{{ $expense->category }}</td>
                        <td>₱{{ number_format($expense->amount, 2) }}</td>
                        <td>{{ $expense->description }}</td>
                        <td>{{ $expense->created_at->format('Y-m-d') }}</td>
                        <td class="text-center">
                            <button 
                                type="button" 
                                class="btn btn-sm btn-primary me-2" 
                                onclick='openEditModal(@json($expense))'>
                                Edit
                            </button>

                            <form 
                                action="{{ route('expenses.destroy', $expense->id) }}" 
                                method="POST" 
                                style="display:inline;" 
                                onsubmit="return confirm('Delete this expense?');"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- add expense --}}
    <div id="AddExpense" class="container my-5">
        <div class="card shadow-lg border-0">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Add New Expense</h2>

                <form action="{{ route('expenses.add') }}" method="POST">
                    @csrf

                    {{-- Category --}}
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select name="category" id="category" class="form-select" required>
                            <option value="" disabled selected>Select Category</option>
                            <option value="Business">Business</option>
                            <option value="Tax">Tax</option>
                            <option value="Labor">Labor</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    {{-- Amount --}}
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input 
                            name="amount" 
                            id="amount" 
                            type="number" 
                            step="0.01" 
                            class="form-control" 
                            placeholder="Enter amount" 
                            required
                        >
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input 
                            name="description" 
                            id="description" 
                            type="text" 
                            class="form-control" 
                            placeholder="Optional description"
                        >
                    </div>

                    {{-- Submit --}}
                        <div class="text-center">
                        <button type="submit" class="btn btn-success px-4">
                            + Add Expense
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- Income Part --}}
<div class="container my-5">

    <h2 class="mb-4 text-center">Income</h2>

    {{-- search bar --}}
    <div class="mb-3">
        <input type="text" id="incomeSearch" class="form-control" placeholder="Search income...">
    </div>

        {{-- filter --}}
    <div class="d-flex align-items-center mb-3">
    <label for="filterIncomeCategory" class="me-2">Category:</label>
    <select id="filterIncomeCategory" class="form-select w-auto">
        <option value="">All</option>
        <option value="Sales">Sales</option>
        <option value="Services">Services</option>
        <option value="Royalty">Royalty</option>
        <option value="Others">Others</option>
    </select>
    <button type="button" class="btn btn-sm btn-secondary ms-3" onclick="filterIncomeByCategory()">Filter</button>
    </div>


    {{-- Income Table --}}
    <div class="table-responsive">
        <table id="incomesTable" class="table table-striped table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Actions</th>
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
                            <button 
                                type="button" 
                                class="btn btn-sm btn-primary me-2"
                                onclick='openEditIncomeModal(@json($income))'>
                                Edit
                            </button>

                            <form action="{{ route('income.destroy', $income->id) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Delete this income?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Add Income Form --}}
<div id="AddIncome" class="container my-5">
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Add New Income</h2>

            <form action="{{ route('income.add') }}" method="POST">
                @csrf

                {{-- Category --}}
                <div class="mb-3">
                    <label for="incomeCategory" class="form-label">Category</label>
                    <select name="category" id="incomeCategory" class="form-select" required>
                        <option value="" disabled selected>Select Category</option>
                        <option value="Sales">Sales</option>
                        <option value="Services">Services</option>
                        <option value="Royalty">Royalty</option>
                        <option value="Other">Other</option> 
                    </select>
                </div>

                {{-- Amount --}}
                <div class="mb-3">
                    <label for="incomeAmount" class="form-label">Amount</label>
                    <input 
                        name="amount" 
                        id="incomeAmount" 
                        type="number" 
                        step="0.01" 
                        class="form-control" 
                        placeholder="Enter amount" 
                        required
                    >
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label for="incomeDescription" class="form-label">Description</label>
                    <input 
                        name="description" 
                        id="incomeDescription" 
                        type="text" 
                        class="form-control" 
                        placeholder="Optional description"
                    >
                </div>

                {{-- Submit --}}
                <div class="text-center">
                    <button type="submit" class="btn btn-success px-4">
                        + Add Income
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


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
                <input type="number" name="amount" id="editIncomeAmount" required>

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

        function showBarChart() 
        {
            document.getElementById('BarChart').style.display ='block';
            document.getElementById('BarChart').style.display = 'flex';
        }

        function closeBarChart() {
            document.getElementById('BarChart').style.display = 'none';
        }

    </script>

    {{-- Search logic --}}
    <script>
        
    document.getElementById('expenseSearch').addEventListener('keyup', function() 
    {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#expensesTable tbody tr');

        document.getElementById("filterExpenseCategory").value = "";

        rows.forEach(row => 
        {
            let text = row.innerText.toLowerCase();
            if (text.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });

    document.getElementById('incomeSearch').addEventListener('keyup', function()
    {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#incomesTable tbody tr');

        document.getElementById("filterCategory").value = "";

        rows.forEach(row => 
        {
            let text = row.innerText.toLowerCase();
            if (text.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    })
    </script>

    {{-- Filter logic --}}

    <script>
    function filterExpenseByCategory() {
        let selected = document.getElementById("filterExpenseCategory").value.toLowerCase();
        let rows = document.querySelectorAll("#expensesTable tbody tr");

        rows.forEach(row => {
        let category = row.cells[1].textContent.toLowerCase();
        if (selected === "" || category === selected) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
        });
    }

    function filterIncomeByCategory() {
        let selected = document.getElementById("filterIncomeCategory").value.toLowerCase();
        let rows = document.querySelectorAll("#incomesTable tbody tr");

        rows.forEach(row => {
        let category = row.cells[1].textContent.toLowerCase();
        if (selected === "" || category === selected) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
        });
    }
    </script>


<div id="BarChart" 
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
            background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
    
    <div style="background:white; padding:20px; border-radius:8px; width:800px; max-width:90%;">
        <h3 style="text-align:center;">Revenue Chart</h3>
        <div id="ChartContainer" style="width:100%; height:400px;">
            <canvas id="myExpenseChart"></canvas>
        </div>
    <p><strong>Total Income:</strong> {{ number_format($totalIncome, 2) }}</p>
    <p><strong>Total Expense:</strong> {{ number_format($totalExpense, 2) }}</p>
    <p><strong>Total Revenue:</strong> <span class="{{ $totalRevenue < 0 ? 'text-danger' : 'text-success' }}">
            {{ number_format($totalRevenue, 2) }}
        </span></p>
        <div style="text-align:center; margin-top:15px;">
            <button onclick="closeBarChart()">Close</button>
        </div>
    </div>
</div>


</body>

<script  src="https://cdn.jsdelivr.net/npm/chart.js" ></script>
<script>
const ctx = document.getElementById('myExpenseChart');

    const labels = @json($labels);             // categories
    const expenseValues = @json($expenseValues); 
    const incomeValues = @json($incomeValues); 

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {   
                    label: 'Incomes',
                    data: incomeValues,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1

                },
                {
                    label: 'Expenses',
                    data: expenseValues,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
</html> 