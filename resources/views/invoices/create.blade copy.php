@extends('layouts.Admin')

@section('content')
<main class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT: Invoice Info --}}
        <section class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow p-6 space-y-6">
                <header class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-800">
                        {{ isset($invoice) ? 'تعديل الفاتورة' : 'فاتورة جديدة' }}
                    </h2>
                </header>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-3">
                        <ul class="list-disc pr-5">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label class="block font-semibold mb-1">اسم العميل</label>
                        <input type="text" name="customer_name" form="invoiceForm"
                               value="{{ old('customer_name', $invoice->customer_name ?? '') }}"
                               class="w-full rounded-lg border-gray-300 focus:ring focus:ring-primary-300"
                               placeholder="أدخل اسم العميل">
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">تاريخ البيع</label>
                        <input type="datetime-local" name="sold_at" form="invoiceForm"
                               value="{{ old('sold_at', isset($invoice) ? $invoice->sold_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
                               class="w-full rounded-lg border-gray-300 focus:ring focus:ring-primary-300">
                    </div>
                </div>

                <div class="text-center pt-4 border-t">
                    <h3 class="font-bold mb-2 text-gray-700">الإجمالي الكلي</h3>
                    <div id="grandTotal"
                         class="text-3xl font-extrabold text-green-600 bg-green-50 px-4 py-2 rounded-lg">
                        0.00 ج
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <button type="submit"
                            class="w-full py-3 rounded-xl text-white font-semibold bg-green-600 hover:bg-green-700"
                            form="invoiceForm">
                        💾 حفظ الفاتورة
                    </button>
                    <a href="{{ route('invoices.index') }}"
                       class="w-full py-2 rounded-xl text-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium">
                        إلغاء
                    </a>
                </div>
            </div>
        </section>

        {{-- RIGHT: Items --}}
        <section class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow">
                <header class="px-6 py-4 border-b">
                    <h3 class="text-lg font-bold text-gray-700">عناصر الفاتورة</h3>
                </header>

                <form action="{{ isset($invoice) ? route('invoices.update',$invoice) : route('invoices.store') }}"
                      method="POST" id="invoiceForm" class="p-4">
                    @csrf
                    @isset($invoice) @method('PUT') @endisset

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border-collapse" id="itemsTable">
                            <thead class="bg-gray-50 text-gray-700 text-center">
                                <tr>
                                    <th class="py-3 px-2">الفئة</th>
                                    <th class="py-3 px-2">طريقة البحث</th>
                                    <th class="py-3 px-2">المنتج</th>
                                    <th class="py-3 px-2">الكمية</th>
                                    <th class="py-3 px-2">السعر</th>
                                    <th class="py-3 px-2">الإجمالي</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="item-row border-t">
                                    {{-- Category --}}
                                    <td class="p-2">
                                        <select name="items[0][category_id]" class="category w-full rounded border-gray-300">
                                            <option value="">-- اختر --</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    {{-- Mode --}}
                                    <td class="p-2">
                                        <select class="search-mode w-full rounded border-gray-300">
                                            <option value="">-- اختر --</option>
                                            <option value="select">بحث واختيار</option>
                                            <option value="barcode">باركود</option>
                                        </select>
                                    </td>

                                    {{-- Product --}}
                                    <td class="p-2 relative">
                                        <div class="choose-mode text-gray-500 text-center">
                                            اختر طريقة البحث أولاً
                                        </div>

                                        <div class="product-search hidden">
                                            <input type="text" class="search-input w-full rounded border-gray-300"
                                                   placeholder="اكتب اسم المنتج...">
                                            <ul class="suggestions absolute left-0 right-0 bg-white border rounded mt-1 shadow hidden z-10"></ul>
                                        </div>

                                        <div class="product-barcode hidden">
                                            <input type="text" class="barcode w-full rounded border-gray-300"
                                                   placeholder="أدخل أو امسح الباركود">
                                        </div>
                                    </td>

                                    {{-- Qty --}}
                                    <td class="p-2">
                                        <input type="number" name="items[0][qty]" value="1" min="1"
                                               class="qty w-20 text-center rounded border-gray-300">
                                    </td>

                                    {{-- Price --}}
                                    <td class="p-2">
                                        <input type="number" step="0.01" name="items[0][price]"
                                               class="price w-28 rounded border-gray-300">
                                    </td>

                                    {{-- Total --}}
                                    <td class="p-2">
                                        <input type="text" class="row-total w-28 rounded bg-gray-50 text-center" readonly>
                                    </td>

                                    {{-- Remove --}}
                                    <td class="p-2 text-center">
                                        <button type="button"
                                                class="remove-row text-red-500 hover:text-red-700 text-lg font-bold">
                                            ×
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <button type="button" id="addRow"
                    class="fixed bottom-8 right-8 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-xl w-14 h-14 text-3xl flex items-center justify-center">
                +
            </button>
        </section>
    </div>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    let rowIndex = 1;

    // helpers: show / hide (manage both class hidden and inline style)
    const showEl = el => {
        if (!el) return;
        el.classList.remove('hidden');
        // some elements are lists (ul) or divs; use block by default
        el.style.display = (el.tagName === 'UL' || el.tagName === 'LI') ? 'block' : '';
    };
    const hideEl = el => {
        if (!el) return;
        el.classList.add('hidden');
        el.style.display = 'none';
    };

    const updateRowTotal = row => {
        const qty = parseFloat(row.querySelector('.qty').value) || 0;
        const price = parseFloat(row.querySelector('.price').value) || 0;
        row.querySelector('.row-total').value = (qty * price).toFixed(2);
        updateGrand();
    };

    const updateGrand = () => {
        let total = 0;
        document.querySelectorAll('.row-total').forEach(i => {
            const v = parseFloat((i.value || '').toString().replace(',', '.')) || 0;
            total += v;
        });
        const grand = document.getElementById('grandTotal');
        if (grand) grand.textContent = total.toFixed(2) + ' ج';
    };

    // set UI for a given row and mode
    const setModeUI = (row, mode) => {
        const placeholder = row.querySelector('.choose-mode');
        const searchBox = row.querySelector('.product-search');
        const barcodeBox = row.querySelector('.product-barcode');

        // hide all first
        hideEl(placeholder);
        hideEl(searchBox);
        hideEl(barcodeBox);

        if (mode === 'select') {
            showEl(searchBox);
            // focus the search input if exists
            const input = row.querySelector('.search-input');
            if (input) { input.focus(); input.select && input.select(); }
        } else if (mode === 'barcode') {
            showEl(barcodeBox);
            const bc = row.querySelector('.barcode');
            if (bc) bc.focus();
        } else {
            // default: show placeholder message
            showEl(placeholder);
        }
    };

    // initialize existing rows on load
    document.querySelectorAll('.item-row').forEach(row => {
        const mode = row.querySelector('.search-mode') ? row.querySelector('.search-mode').value : '';
        setModeUI(row, mode);
    });

    // Toggle between modes (delegated)
    document.addEventListener('change', e => {
        if (e.target.classList.contains('search-mode')) {
            const row = e.target.closest('tr');
            const mode = e.target.value;
            setModeUI(row, mode);
        }
    });

    // Live autocomplete for product search (delegated)
    let searchTimers = new WeakMap();
    document.addEventListener('input', async e => {
        if (e.target.classList.contains('search-input')) {
            const input = e.target;
            const query = input.value.trim();
            const row = input.closest('tr');
            const list = row.querySelector('.suggestions');

            // debounce 300ms
            clearTimeout(searchTimers.get(input));
            searchTimers.set(input, setTimeout(async () => {
                if (query.length < 2) {
                    hideEl(list);
                    list.innerHTML = '';
                    return;
                }

                try {
                    const res = await fetch(`/api/products-search?q=${encodeURIComponent(query)}`);
                    const data = await res.json();
                    list.innerHTML = '';
                    if (!Array.isArray(data) || data.length === 0) {
                        hideEl(list);
                        return;
                    }
                    data.forEach(p => {
                        const li = document.createElement('li');
                        li.textContent = `${p.name} (${p.sale_price} ج)`;
                        li.dataset.price = p.sale_price;
                        li.dataset.id = p.id;
                        li.className = 'px-3 py-1 hover:bg-gray-100 cursor-pointer';
                        list.appendChild(li);
                    });
                    showEl(list);
                } catch (err) {
                    console.error('search error', err);
                    hideEl(list);
                }
            }, 300));
        }
    });

    // Choose product from suggestions (delegated)
    document.addEventListener('click', e => {
        const li = e.target.closest('.suggestions li');
        if (li) {
            const row = li.closest('tr');
            const priceInput = row.querySelector('.price');
            const qtyInput = row.querySelector('.qty');
            const searchInput = row.querySelector('.search-input');
            if (priceInput) priceInput.value = li.dataset.price || '';
            if (qtyInput) qtyInput.value = 1;
            if (searchInput) searchInput.value = li.textContent || '';
            const list = row.querySelector('.suggestions');
            hideEl(list);
            updateRowTotal(row);
            return;
        }

        // click outside suggestions -> hide any open suggestion lists
        document.querySelectorAll('.suggestions').forEach(s => {
            if (!s.contains(e.target)) hideEl(s);
        });
    });

    // Barcode: press Enter to fetch product by barcode
    document.addEventListener('keydown', e => {
        if (e.target.classList.contains('barcode') && e.key === 'Enter') {
            e.preventDefault();
            const code = e.target.value.trim();
            const row = e.target.closest('tr');
            if (!code) return;
            fetch(`/api/product-by-barcode/${encodeURIComponent(code)}`)
                .then(r => r.json())
                .then(p => {
                    if (p && p.id) {
                        const priceInput = row.querySelector('.price');
                        const qtyInput = row.querySelector('.qty');
                        if (priceInput) priceInput.value = p.sale_price;
                        if (qtyInput) qtyInput.value = 1;
                        updateRowTotal(row);
                    } else {
                        alert('المنتج غير موجود');
                    }
                })
                .catch(err => {
                    console.error(err); alert('خطأ في البحث عن الباركود');
                });
        }
    });

    // Qty / Price changes
    document.addEventListener('input', e => {
        if (e.target.classList.contains('qty') || e.target.classList.contains('price')) {
            const row = e.target.closest('tr');
            if (row) updateRowTotal(row);
        }
    });

    // Add row
    document.getElementById('addRow').addEventListener('click', () => {
        const tbody = document.querySelector('#itemsTable tbody');
        const template = document.querySelector('.item-row');
        const row = template.cloneNode(true);

        // reset inputs and selects inside the cloned row
        row.querySelectorAll('input').forEach(i => {
            i.value = '';
        });
        row.querySelectorAll('select').forEach(s => {
            // update name index if present like items[0][...]
            const name = s.getAttribute('name');
            if (name) {
                s.setAttribute('name', name.replace(/\[\d+\]/, `[${rowIndex}]`));
            }
            s.value = '';
        });
        // update names for inputs with name attributes (price/qty)
        row.querySelectorAll('input[name]').forEach(i => {
            const n = i.getAttribute('name');
            if (n) i.setAttribute('name', n.replace(/\[\d+\]/, `[${rowIndex}]`));
        });

        // ensure UI is reset: show placeholder, hide search & barcode & suggestions
        const placeholder = row.querySelector('.choose-mode');
        const searchBox = row.querySelector('.product-search');
        const barcodeBox = row.querySelector('.product-barcode');
        const suggestions = row.querySelector('.suggestions');

        showEl(placeholder);
        hideEl(searchBox);
        hideEl(barcodeBox);
        if (suggestions) { suggestions.innerHTML = ''; hideEl(suggestions); }

        tbody.appendChild(row);
        rowIndex++;
    });

    // Remove row
    document.addEventListener('click', e => {
        if (e.target.classList.contains('remove-row')) {
            const tr = e.target.closest('tr');
            if (!tr) return;
            tr.remove();
            updateGrand();
        }
    });

    // Hide suggestion lists when clicking ESC
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.suggestions').forEach(s => hideEl(s));
        }
    });

    // final initial total calc (in case values exist)
    updateGrand();
});
</script>
@endpush
