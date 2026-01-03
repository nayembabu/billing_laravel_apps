@extends('layout.main')
@section('content')

<section>
    <div class="container mt-4">
        <div class="mb-3">
            <button type="button" class="btn btn-primary" id="sendSmsBtn">
                SEND SMS OPTION
            </button>
        </div>
        <!-- Search Box -->
        <div class="mb-3" style="float: right; width: 350px; margin-right: 20px; ">
            <input type="text" id="searchInput" class="form-control" placeholder="Search by name or mobile number">
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="selectAll">
                    </th>
                    <th>Name</th>
                    <th>Mobile Number</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <!-- Data will be loaded here -->
            </tbody>
        </table>
        <!-- Pagination -->
        <nav style="float: right; margin-right: 40px; ">
            <ul class="pagination" id="pagination"></ul>
        </nav>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="smsModal" tabindex="-1" role="dialog" aria-labelledby="smsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="smsModalLabel">Send SMS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Mobile Numbers:</label>
                        <input type="text" id="mobileNumbers" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Message:</label>
                        <textarea id="smsMessage" class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitSmsBtn" >Save changes</button>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection

@push('scripts')

<script type="text/javascript">
    $(document).ready(function(){
        const itemsPerPage = 10;
        let currentPage = 1;
        let allCustomers = [];
        let filteredCustomers = allCustomers;

        function fetchCustomers(){
            $.ajax({
                url: '/crm/get_customer',
                method: 'GET',
                dataType: 'json'
            }).done(function(res){
                console.log(res);
                // API returns allCustomer array inside response
                const data = res.allCustomer || res.data || res;
                allCustomers = (Array.isArray(data) ? data : []).map(c => ({
                    id: c.id || null,
                    name: c.name || '',
                    mobile: (c.phone_number || c.phone || c.mobile || '').toString(),
                    address: c.address || ''
                }));
                filteredCustomers = allCustomers;
                currentPage = 1;
                renderTable();
            }).fail(function(){
                alert('Failed to load customers.');
                renderTable();
            });
        }


        function renderTable() {
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const pageData = filteredCustomers.slice(start, end);

            let html = '';
            pageData.forEach(customer => {
                html += `<tr>
                    <td><input type="checkbox" class="customerCheckbox" data-mobile="${customer.mobile}"></td>
                    <td>${customer.name}</td>
                    <td>${customer.mobile}</td>
                    <td>${customer.address}</td>
                </tr>`;
            });

            $('#tableBody').html(html);
            renderPagination();
        }

        function renderPagination() {
            const totalPages = Math.ceil(filteredCustomers.length / itemsPerPage);
            let paginationHtml = '';

            for (let i = 1; i <= totalPages; i++) {
                paginationHtml += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>`;
            }

            $('#pagination').html(paginationHtml);
        }

        $('#searchInput').on('keyup', function(){
            const searchTerm = $(this).val().toLowerCase();
            filteredCustomers = allCustomers.filter(customer =>
                customer.name.toLowerCase().includes(searchTerm) ||
                customer.mobile.includes(searchTerm)
            );
            currentPage = 1;
            renderTable();
        });

        $(document).on('click', '.page-link', function(e){
            e.preventDefault();
            currentPage = $(this).data('page');
            renderTable();
        });

        $('#selectAll').on('change', function(){
            $('.customerCheckbox').prop('checked', this.checked);
        });

        $('#sendSmsBtn').on('click', function(){
            let mobiles = [];
            $('.customerCheckbox:checked').each(function(){
                mobiles.push($(this).data('mobile'));
            });

            if(mobiles.length === 0){
                alert('Please select at least one customer');
                return;
            }

            $('#mobileNumbers').val(mobiles.join(', '));
            new bootstrap.Modal(document.getElementById('smsModal')).show();
        });

        $('#submitSmsBtn').on('click', function(){
            let message = $('#smsMessage').val();
            if(message.trim() === ''){
                alert('Please enter a message');
                return;
            }
            alert('SMS sent successfully!');
            new bootstrap.Modal(document.getElementById('smsModal')).hide();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        fetchCustomers();
    });
</script>
@endpush
