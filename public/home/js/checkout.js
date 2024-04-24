var citis = $("#cityCheckout");
var districts = $("#districtCheckout");
var wards = $("#wardCheckout");

var Parameter = {
    url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
    method: "GET",
    responseType: "json",
};
var promise = axios(Parameter);
promise.then(function(result) {
    renderCity(result.data);
});

function renderCity(data) {
    for (const x of data) {
        citis.append($("<option></option>").val(x.Name).text(x.Name)); // Use city.Name for both value and text
    }

    // Initialize Nice Select after dynamically adding options
    $(document).ready(function() {
        citis.niceSelect(); // Initialize city dropdown first

        citis.change(function() {
            wards.find('option').not(':first').remove(); // Clear the wards dropdown

            districts.find('option').not(':first').remove();
            if ($(this).val() !== "") {
                const result = data.filter(n => n.Name === $(this).val()); // Change from Id to Name

                for (const district of result[0].Districts) {
                    districts.append($("<option></option>").val(district.Name).text(district
                    .Name)); // Use district.Name for both value and text
                }

                // Refresh the Nice Select dropdown
                districts.niceSelect('update');
            }
        });

        districts.change(function() {
            wards.find('option').not(':first').remove(); // Clear the wards dropdown
            const dataCity = data.filter(n => n.Name === citis.val());
        
            if ($(this).val() !== "") {
                const dataWards = dataCity[0].Districts.filter(n => n.Name === $(this).val())[0].Wards;
        
                for (const ward of dataWards) {
                    wards.append($("<option></option>").val(ward.Name).text(ward.Name));
                }
        
                wards.niceSelect('update'); // Refresh the Nice Select dropdown
            }
        });

        // Initialize districts and wards Nice Select after dynamically adding options
        districts.niceSelect();
        wards.niceSelect();
    });
}

//checkout btn
$(document).on('click', '#checkout-btn', function(e) {
    e.preventDefault();

    showConfirmationAlert('Are you sure you want to proceed with the checkout?', function(result) {
        if (result.value) {
            performCheckout();
        }
    });
});

function showConfirmationAlert(message, callback) {
    Swal.fire({
        title: 'Confirm',
        text: message,
        type: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, proceed',
        cancelButtonText: 'Cancel',
    }).then(callback);
}

function performCheckout() {
    var formData = {
        name: $('#name_order').val(),
        phone: $('#phone_order').val(),
        city: $('#cityCheckout').val(),
        district: $('#districtCheckout').val(),
        ward: $('#wardCheckout').val(),
        address: $('#adressCheckout').val(),
        // ... Include other data if needed ...
    };

    $.ajax({
        url: cartCheckout,
        method: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                // Show Toastr success notification
                window.location.href = cartThanks;
             
            } else {
                // Show Toastr error notification
                toastr.error('Checkout failed. Please try again later.');
            }
        },
        error: function() {
            // Show Toastr error notification
            toastr.error('An error occurred during checkout.');
        }
    });
}