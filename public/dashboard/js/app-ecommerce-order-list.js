/**
 * app-ecommerce-order-list Script
 */

'use strict';

// Datatable (jquery)

$(function () {
    let borderColor, bodyBg, headingColor;

    if (isDarkStyle) {
        borderColor = config.colors_dark.borderColor;
        bodyBg = config.colors_dark.bodyBg;
        headingColor = config.colors_dark.headingColor;
    } else {
        borderColor = config.colors.borderColor;
        bodyBg = config.colors.bodyBg;
        headingColor = config.colors.headingColor;
    }

    // Variable declaration for table

    var dt_order_table = $('.datatables-order'),
        statusObj = {
            1: { title: 'Chờ xử lý', class: 'bg-label-warning' },
            2: { title: 'Đã xác nhận', class: 'bg-label-primary' },
            3: { title: 'Đang giao hàng', class: 'bg-label-info' },
            4: { title: 'Thành Công', class: 'bg-label-success' },
            5: { title: 'Trả Hàng', class: 'bg-label-danger' },
            6: { title: 'Đã hủy', class: 'bg-label-secondary' }
        },
        paymentObj = {
            1: { title: 'Thành công', class: 'text-success' },
            2: { title: 'Chờ thanh toán', class: 'text-warning' },
            3: { title: 'Lỗi thanh toán', class: 'text-danger' },
            4: { title: 'Đã Hủy', class: 'text-secondary' }
        },
        paymentDetailObj = {
            1: { title: 'Thành công', class: 'bg-label-success' },
            2: { title: 'Chờ thanh toán', class: 'bg-label-warning' },
            3: { title: 'Lỗi thanh Toán', class: 'bg-label-danger' },
            4: { title: 'Hủy', class: 'bg-label-secondary' }
        };
    // E-commerce Products datatable

    if (dt_order_table.length) {
        var dt_orders = dt_order_table.DataTable({
            ajax: route('allorders'), // JSON file to add data
            columns: [
                // columns according to JSON
                { data: 'id' },
                { data: 'id' },
                { data: 'order' },
                { data: 'date' },
                { data: 'customer' }, //email //avatar
                { data: 'payment' },
                { data: 'status' },
                { data: 'method' }, //method_number
                { data: '' }
            ],
            columnDefs: [
                {
                    // For Responsive
                    className: 'control',
                    searchable: false,
                    orderable: false,
                    responsivePriority: 2,
                    targets: 0,
                    render: function (data, type, full, meta) {
                        return '';
                    }
                },
                {
                    // For Checkboxes
                    targets: 1,
                    orderable: false,
                    checkboxes: {
                        selectAllRender: '<input type="checkbox" class="form-check-input">'
                    },
                    render: function () {
                        return '<input type="checkbox" class="dt-checkboxes form-check-input" >';
                    },
                    searchable: false
                },
                {
                    // Order ID
                    targets: 2,
                    render: function (data, type, full, meta) {
                        var $order_id = full['id'];
                        // Creates full output for row
                        var $row_output = `<span>#${$order_id}</span>`;
                        return $row_output; ``
                    }
                },
                {
                    // Date and Time
                    targets: 3,
                    render: function (data, type, full, meta) {
                        var date = new Date(full.created_at); // convert the date string to a Date object
                        var formattedDate = date.toLocaleDateString('en-US', {
                            month: 'short',
                            day: 'numeric',
                            year: 'numeric'
                        });
                        // Format the time
                        var hours = date.getHours();
                        var minutes = date.getMinutes();
                        var ampm = hours >= 12 ? 'PM' : 'AM';
                        hours = hours % 12;
                        hours = hours ? hours : 12; // The hour '0' should be '12'
                        minutes = minutes < 10 ? '0' + minutes : minutes;
                        var formattedTime = hours + ':' + minutes + ' ' + ampm;

                        return '<span class="text-nowrap">' + formattedDate + ', ' + formattedTime + '</span>';
                    }
                },
                {
                    // Customers
                    targets: 4,
                    responsivePriority: 1,
                    render: function (data, type, full, meta) {
                        var $name = full['user']['name'],
                            $email = full['user']['email'],
                            $avatar = full['user']['user_image'];
                        if ($avatar) {
                            // For Avatar image
                            var $output =
                                '<img src="' + assetsPath + 'img/avatars/' + $avatar + '" alt="Avatar" class="rounded-circle">';
                        } else {
                            // For Avatar badge
                            var stateNum = Math.floor(Math.random() * 6);
                            var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
                            var $state = states[stateNum],
                                $name = full['user']['name'],
                                $initials = $name.match(/\b\w/g) || [];
                            $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
                            $output = '<span class="avatar-initial rounded-circle bg-label-' + $state + '">' + $initials + '</span>';
                        }
                        // Creates full output for row
                        var $row_output =
                            '<div class="d-flex justify-content-start align-items-center order-name text-nowrap">' +
                            '<div class="avatar-wrapper">' +
                            '<div class="avatar me-2">' +
                            $output +
                            '</div>' +
                            '</div>' +
                            '<div class="d-flex flex-column">' +
                            '<h6 class="m-0"><a href="pages-profile-user.html" class="text-body">' +
                            $name +
                            '</a></h6>' +
                            '<small class="text-muted">' +
                            $email +
                            '</small>' +
                            '</div>' +
                            '</div>';
                        return $row_output;
                    }
                },
                {
                    targets: 5,
                    render: function (data, type, full, meta) {
                        var $payment = full['payment_status'],
                            $paymentObj = paymentObj[$payment];
                        if ($paymentObj) {
                            return (
                                '<h6 class="mb-0 align-items-center d-flex w-px-100 ' +
                                $paymentObj.class +
                                '">' +
                                '<i class="ti ti-circle-filled fs-tiny me-2"></i>' +
                                $paymentObj.title +
                                '</h6>'
                            );
                        }
                        return data;
                    }
                },
                {
                    // Status
                    targets: -3,
                    render: function (data, type, full, meta) {
                        var $status = full['status'];

                        return (
                            '<span class="badge px-2 ' +
                            statusObj[$status].class +
                            '" text-capitalized>' +
                            statusObj[$status].title +
                            '</span>'
                        );
                    }
                },
                {
                    // Payment Method
                    targets: -2,
                    render: function (data, type, full, meta) {
                        var $method = full['payment_method'];
                        return (
                            '<div class="d-flex align-items-center text-nowrap">' +
                            '<img  src="' +
                            assetsPath +
                            'img/icons/payments/' +
                            $method +
                            '.png" alt="' +
                            $method +
                            '"class="me-2" width="16">' + $method +
                            '</div>'
                        );
                    }
                },
                {
                    // Actions
                    targets: -1,
                    title: 'Actions',
                    searchable: false,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        return (
                            '<button class="btn btn-sm btn-icon edit-record-order" data-bs-toggle="modal" data-bs-target="#editOrderModal" data-order-id="' + full.id + '"><i class="ti ti-edit"></i></button>'
                        );
                    }
                }
            ],
            order: [3, 'asc'], //set any columns order asc/desc
            dom:
                '<"card-header pb-md-2 d-flex flex-column flex-md-row align-items-start align-items-md-center"<f><"d-flex align-items-md-center justify-content-md-end mt-2 mt-md-0 gap-2"l<"dt-action-buttons"B>>' +
                '>t' +
                '<"row mx-2"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            lengthMenu: [10, 40, 60, 80, 100], //for length of menu
            language: {
                sLengthMenu: '_MENU_',
                search: '',
                searchPlaceholder: 'Search Order',
                info: 'Displaying _START_ to _END_ of _TOTAL_ entries'
            },
            // Buttons with Dropdown
            buttons: [
                {
                    extend: 'collection',
                    className: 'btn btn-label-secondary dropdown-toggle waves-effect waves-light',
                    text: '<i class="ti ti-download me-1"></i>Export',
                    buttons: [
                        {
                            extend: 'print',
                            text: '<i class="ti ti-printer me-2"></i>Print',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [2, 3, 4, 5, 6, 7],
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('order-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            },
                            customize: function (win) {
                                // Customize print view for dark
                                $(win.document.body)
                                    .css('color', headingColor)
                                    .css('border-color', borderColor)
                                    .css('background-color', bodyBg);
                                $(win.document.body)
                                    .find('table')
                                    .addClass('compact')
                                    .css('color', 'inherit')
                                    .css('border-color', 'inherit')
                                    .css('background-color', 'inherit');
                            }
                        },
                        {
                            extend: 'csv',
                            text: '<i class="ti ti-file me-2"></i>Csv',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [2, 3, 4, 5, 6, 7],
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('order-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'excel',
                            text: '<i class="ti ti-file-export me-2"></i>Excel',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [2, 3, 4, 5, 6, 7],
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('order-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="ti ti-file-text me-2"></i>Pdf',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [2, 3, 4, 5, 6, 7],
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('order-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'copy',
                            text: '<i class="ti ti-copy me-2"></i>Copy',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [2, 3, 4, 5, 6, 7],
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('order-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            }
                        }
                    ]
                }
            ],
            // For responsive popup
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Details of ' + data['customer'];
                        }
                    }),
                    type: 'column',
                    renderer: function (api, rowIdx, columns) {
                        var data = $.map(columns, function (col, i) {
                            return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                ? '<tr data-dt-row="' +
                                col.rowIndex +
                                '" data-dt-column="' +
                                col.columnIndex +
                                '">' +
                                '<td>' +
                                col.title +
                                ':' +
                                '</td> ' +
                                '<td>' +
                                col.data +
                                '</td>' +
                                '</tr>'
                                : '';
                        }).join('');

                        return data ? $('<table class="table"/><tbody />').append(data) : false;
                    }
                }
            }
        });
        $('.dataTables_length').addClass('mt-0 mt-md-3 ms-n2');
        $('.dt-action-buttons').addClass('pt-0');
        $('.dataTables_filter').addClass('ms-n3');
    }
    $('body').on('click', '.edit-record-order', function () {
        // Get the product ID from the data attribute
        var $row = $(this).closest('tr');
        var rowData = dt_orders.row($row).data();

        // Order ID
        $('#order_detail_id').html('#' + rowData.id);

        // Payment status
        var $payment = rowData.payment_status,
            $paymentObj = paymentDetailObj[$payment];
        $('#detail_payment_status').html(`
            <span class="badge px-2 ${$paymentObj.class}">
                <i class="ti ti-circle-filled fs-tiny me-2"></i>
                ${$paymentObj.title}
            </span>
        `);

        // Order status
        var $status = rowData.status,
            $statusObj = statusObj[$status];
        $('#detail_status').html(`
            <span class="badge px-2 ${$statusObj.class}">
                <i class="ti ti-circle-filled fs-tiny me-2"></i>
                ${$statusObj.title}
            </span>
        `);

        // Order time
        var date = new Date(rowData.created_at); // convert the date string to a Date object
        var formattedDate = date.toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // The hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        var formattedTime = hours + ':' + minutes + ' ' + ampm;
        $('#detail_order_time').html(formattedDate + ', ' + formattedTime);

        // Order detail
        const products_orders = rowData.cart_items;
        $("#products_order tbody").empty();

        const calculateTotal = (price, qty) => (price * qty);
        let orderSubtotal = 0;
        let discount = 0;

        $.each(products_orders, function (index, product) {
            const total = calculateTotal(product.price, product.quantity);
            orderSubtotal += (total);
            const row = `
                <tr>
                    <td class="w-50">${product.name}</td>
                    <td class="w-25">${product.price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })}</td>
                    <td class="w-25">${product.quantity}</td>
                    <td>$${calculateTotal(product.price, product.quantity).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })}</td>
                </tr>
            `;
            $("#products_order tbody").append(row);
        });

        $("#orderSubtotal").html(orderSubtotal.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));
        let total = orderSubtotal - discount;
        $("#totalOrder").html(total.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));

        $('#orderId').val(rowData.id);
        $('#totalUserOrder').html(rowData.user_order_count);
        $('#userName').html(rowData.name);
        $('#userId').html(rowData.user.id);
        $('#userEmail').html(rowData.user.email);
        $('#userPhone').html(rowData.phone);
        $('#orderAddress').html(rowData.address);
        $('#paymentMethod').html(rowData.payment_method);

        // Đặt giá trị mặc định và cập nhật các trường ẩn
        $('#shippingBrand').val(rowData.shipping_brand).trigger('change');
        $('#shippingBrandHidden').val(rowData.shipping_brand);

        $('#trackingNumber').val(rowData.tracking_number);
        $('#trackingNumberHidden').val(rowData.tracking_number);
         // Vô hiệu hóa các trường nếu đã có dữ liệu
         if (rowData.shipping_brand && rowData.tracking_number) {
            $('#shippingBrand').prop('disabled', true);
            $('#trackingNumber').prop('disabled', true);
        } else {
            $('#shippingBrand').prop('disabled', false);
            $('#trackingNumber').prop('disabled', false);
        }
        const $timeline = $('#shippingTimeline');
        $timeline.empty();
        JSON.parse(rowData.shipping_activity).forEach(activity => {
            let timelineItem;
            if (activity.event === 'Đã hủy' || activity.event === 'Thành Công' || activity.event === 'Trả hàng') {
                timelineItem = `
                    <li class="timeline-item timeline-item-transparent border-transparent pb-0">
                        <span class="timeline-point timeline-point-secondary"></span>
                        <div class="timeline-event pb-0">
                            <div class="timeline-header">
                                <h6 class="mb-0">${activity.event}</h6>
                                <span class="text-muted">${new Date(activity.timestamp).toLocaleString()}</span>
                            </div>
                            <p class="mt-2 mb-0">${activity.event}</p>
                        </div>
                    </li>
                `;
            } else {
                timelineItem = `
                    <li class="timeline-item timeline-item-transparent border-primary">
                        <span class="timeline-point timeline-point-primary"></span>
                        <div class="timeline-event">
                            <div class="timeline-header">
                                <h6 class="mb-0">${activity.event}</h6>
                                <span class="text-muted">${new Date(activity.timestamp).toLocaleString()}</span>
                            </div>
                            <p class="mt-2">${activity.event}</p>
                        </div>
                    </li>
                `;
            }
            $timeline.append(timelineItem);
        });

        // Function to get options based on the current status
        function getOptionsBasedOnStatus(status) {
            let options = [];
            if (status == 1) {
                options.push(2,6);
            } else if (status == 2) {
                options.push(3, 6);
            } else if (status == 3) {
                options.push(4,5);
            }
            return options;
        }

        // Function to update the status options in the dropdown
        function updateStatusOptions(currentStatus) {
            const optionsToDisplay = getOptionsBasedOnStatus(currentStatus);
            const $statusSelect = $('#statusSelect');
            $statusSelect.empty();
            $.each(optionsToDisplay, function (index, key) {
                const option = `<option value="${key}" class="${statusObj[key].class}">${statusObj[key].title}</option>`;
                $statusSelect.append(option);
            });

            // Add event listener for option change
            $statusSelect.on('change', function () {
                const statusId = $(this).val();
                const statusTitle = statusObj[statusId].title;
            });
        }

        const currentStatus = rowData.status; // Assuming `rowData.status` is available in the scope
        updateStatusOptions(currentStatus);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#updateStatusBtn').off('click').on('click', function () {
            // Code xử lý gửi yêu cầu AJAX
            event.preventDefault(); // Prevent default form submission
            var selectedStatus = $('#statusSelect').val();
            var orderId = $('#orderId').val();
            var shippingBrand = $('#shippingBrand').val()
            var trackingNumber = $('#trackingNumber').val()

            $.ajax({
                url: '/update-status',
                method: 'POST',
                data: {
                    shipping_brand: shippingBrand,
                    tracking_number: trackingNumber,
                    status: selectedStatus,
                    order_id: orderId,
                    _token: $('input[name="_token"]').val() // Include CSRF token
                },
                success: function (response) {
                    $('#statusSelect').empty();
                    $('#orderId').val('');
                    $('#formEditOrder')[0].reset();
                    // Update the status options based on the new status
                    $('#editOrderModal').modal('hide')
                    dt_orders.clear().rows.add(response.data).draw();
                    // Reset the form fields

                    // Thông báo thành công bằng SweetAlert 2
                    Swal.fire({
                        icon: 'success',
                        title: 'Cập nhật thành công',
                        text: 'Trạng thái đơn hàng đã được cập nhật.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function (error) {
                    $('#editOrderModal').modal('hide')

                    Swal.fire({
                        icon: 'error',
                        title: 'Cập nhật thất bại',
                        text: error,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });
        $('#formEditOrder').on('submit', function (event) {

        });
    });


    // Delete Record
    $('.datatables-order tbody').on('click', '.delete-record', function () {
        dt_orders.row($(this).parents('tr')).remove().draw();
    });

    // Filter form control to default size
    // ? setTimeout used for multilingual table initialization
    setTimeout(() => {
        $('.dataTables_filter .form-control').removeClass('form-control-sm');
        $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);
});
