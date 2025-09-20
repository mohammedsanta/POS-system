@extends('layouts.app')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">Return Product (Static)</h1>

        {{-- Search Sale --}}
        <div class="mb-6">
            <label class="block text-gray-700 mb-1">Search Sale ID</label>
            <input type="text" id="searchSale"
                   placeholder="Enter sale ID"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
        </div>

        {{-- Invoice List --}}
        <div class="overflow-x-auto mb-4">
            <table class="w-full border text-left text-sm">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 border">Sale ID</th>
                        <th class="px-4 py-2 border">Customer</th>
                        <th class="px-4 py-2 border">Total</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody id="saleTable">
                    <tr>
                        <td class="px-4 py-2 border">1</td>
                        <td class="px-4 py-2 border">Ahmed</td>
                        <td class="px-4 py-2 border">46,000</td>
                        <td class="px-4 py-2 border text-center">
                            <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 selectBtn">Select</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border">2</td>
                        <td class="px-4 py-2 border">Mona</td>
                        <td class="px-4 py-2 border">12,000</td>
                        <td class="px-4 py-2 border text-center">
                            <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 selectBtn">Select</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Selected Invoice Details --}}
        <div id="selectedInvoice" class="hidden bg-gray-50 border rounded p-4">
            <h2 class="font-bold mb-2">Selected Invoice:</h2>
            <p><strong>Sale ID:</strong> <span id="selSaleID"></span></p>
            <p><strong>Customer:</strong> <span id="selCustomer"></span></p>
            <p><strong>Total:</strong> EGP <span id="selTotal"></span></p>

            {{-- Reason --}}
            <div class="mt-4">
                <label class="block text-gray-700 mb-1">Return Reason</label>
                <textarea id="returnReason" rows="2"
                          placeholder="Enter reason for return"
                          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"></textarea>
            </div>

            <button id="processReturn" class="mt-4 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Process Return
            </button>
        </div>
    </div>

    {{-- ===== JavaScript ===== --}}
    <script>
        const selectButtons = document.querySelectorAll('.selectBtn');
        const selectedDiv = document.getElementById('selectedInvoice');
        const selSaleID = document.getElementById('selSaleID');
        const selCustomer = document.getElementById('selCustomer');
        const selTotal = document.getElementById('selTotal');

        selectButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const row = e.target.closest('tr');
                selSaleID.textContent = row.cells[0].textContent;
                selCustomer.textContent = row.cells[1].textContent;
                selTotal.textContent = row.cells[2].textContent;
                selectedDiv.classList.remove('hidden');
            });
        });

        // Filter table by Sale ID
        const searchInput = document.getElementById('searchSale');
        const saleTable = document.getElementById('saleTable');

        searchInput.addEventListener('input', () => {
            const filter = searchInput.value.trim();
            Array.from(saleTable.rows).forEach(row => {
                if(row.cells[0].textContent.includes(filter)){
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Process return button
        document.getElementById('processReturn').addEventListener('click', () => {
            const reason = document.getElementById('returnReason').value.trim();
            if(!reason){
                alert('Please enter a return reason!');
                return;
            }
            alert('Return processed! (Static Data)');
            selectedDiv.classList.add('hidden');
            document.getElementById('returnReason').value = '';
        });
    </script>
</main>
@endsection
