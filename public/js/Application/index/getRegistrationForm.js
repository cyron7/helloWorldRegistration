let getStates = function() {
    let states = {
        "Alabama": "AL",
        "Alaska": "AK",
        "Arizona": "AZ",
        "Arkansas": "AR",
        "California": "CA",
        "Colorado": "CO",
        "Connecticut": "CT",
        "Delaware": "DE",
        "Florida": "FL",
        "Georgia": "GA",
        "Hawaii": "HI",
        "Idaho": "ID",
        "Illinois": "IL",
        "Indiana": "IN",
        "Iowa": "IA",
        "Kansas": "KS",
        "Kentucky": "KY",
        "Louisiana": "LA",
        "Maine": "ME",
        "Maryland": "MD",
        "Massachusetts": "MA",
        "Michigan": "MI",
        "Minnesota": "MN",
        "Mississippi": "MS",
        "Missouri": "MO",
        "Montana": "MT",
        "Nebraska": "NE",
        "Nevada": "NV",
        "New Hampshire": "NH",
        "New Jersey": "NJ",
        "New Mexico": "NM",
        "New York": "NY",
        "North Carolina": "NO",
        "North Dakota": "ND",
        "Ohio": "OH",
        "Oklahoma": "OK",
        "Oregon": "OR",
        "Pennsylvania": "PA",
        "Rhode Island": "RI",
        "South Carolina": "SC",
        "South Dakota": "SD",
        "Tennessee": "TN",
        "Texas": "TX",
        "Utah": "UT",
        "Vermont": "VT",
        "Virginia": "VA",
        "Washington": "WA",
        "West Virginia": "WV",
        "Wisconsin": "WI",
        "Wyoming": "WY"
    };
    return states;
}
$(document).ready(function(){
    let loadStates = function(){
        let stateList = [];
        $.each( getStates(), function( key, val ) {
            stateList.push( "<option value='" + val + "'>" + key + "</option>");
        });
        $('select#inputState').append(stateList.join( "" ));
    };

    let setFormErrors = function(formErrors){
        $.each(formErrors['Input Validation Error'], function(key, val){
            console.log(key + ', ' + val);
            let validator = $("form#registrationForm").validate();
            let errors = {};
            errors[key] = Object.values(val)[0];
            validator.showErrors(errors);
        });
        $('.error').addClass('text-danger');
    };

    let loadSubmitFormOperations = function(){
        $('form#registrationForm').submit(function(e){
            e.preventDefault();
            if($(this).valid() === true) {
                $('div#mainMessageBox').removeClass('d-none').show();
                let url = 'registration-info/send';
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $('form#registrationForm').serialize(), // serializes the form's elements.
                    success: function(data)
                    {
                        if(data.success == true) {
                            $('form#registrationForm').trigger("reset");
                            $('div#mainMessageBox')
                                .removeClass('alert-primary')
                                .addClass('alert-success')
                                .text('Success!');
                            window.location.replace('conformation?id=' + data.id);
                        } else {
                            $('div#mainMessageBox')
                                .removeClass('alert-primary')
                                .addClass('alert-danger')
                                .text('Failed to register');
                            setFormErrors(data.messages);
                        }
                    }
                });
            }
        });
    };

    let loadFormValidationChecking = function(){
        $('input').keyup(function() {
            if($(this).siblings('span').length > 0) {
                $(this).valid();
            }
        });
        $("form#registrationForm").validate({
            rules: {
                First_Name: {
                    minlength: 2,
                    maxlength: 50,
                    pattern: "^[a-zA-Z_]*$",
                    required: true
                },
                Last_Name: {
                    minlength: 2,
                    maxlength: 50,
                    pattern: "^[a-zA-Z_]*$",
                    required: true
                },
                Address1: {
                    minlength: 2,
                    maxlength: 150,
                    required: true
                },
                Address2: {
                    minlength: 2,
                    maxlength: 150,
                    required: false
                },
                City: {
                    minlength: 2,
                    maxlength: 100,
                    required: true,
                    pattern: "^[a-zA-Z_]*$",
                },
                State: {
                    required: true,
                    pattern: "^[a-zA-Z_]*$",
                },
                Zip: {
                    minlength: 5,
                    maxlength: 10,
                    required: true,
                    zipcodeUS: true
                }
            },
            messages: {
                First_Name: {
                    required: "First name is required",
                    pattern: "First name cannot have digits",
                    minlength: "First name has to be at least 2 characters long",
                    maxlength: "Last name cannot exceed a lenght of 50 characters"
                },
                Last_Name: {
                    required: "Last name is required",
                    pattern: "Last name cannot have digits",
                    minlength: "Last name has to be at least 2 characters long",
                    maxlength: "Last name cannot exceed a lenght of 50 characters"
                },
                Address1: {
                    required: "Address name is required",
                    minlength: "Address has to be at least 2 characters long",
                    maxlength: "Address cannot be greater than 150 characters"
                },
                Address2: {
                    minlength: "Address has to be at least 2 characters long",
                    maxlength: "Address cannot be greater than 150 characters"
                },
                City: {
                    required: "City is required",
                    minlength: "City has to be at least 2 digits",
                    maxlength: "City cannot be greater than 100 characters",
                    pattern: "City cannot have digits"
                },
                State: {
                    required: "State is required",
                    pattern: "State cannot have digits"
                },
                Zip:{
                    required: "Zip is required",
                    minlength: "Zip code has to be at least 5 digits long",
                    maxlength: "Zip code cannot be greater than 10 characters",
                    zipcodeUS: "Not a valid zip code"
                }
            },
            onkeyup: true,
            highlight: function(element) {
                $(element).closest('.error').addClass('.text-danger');
            },
            unhighlight: function(element) {
                $(element).closest('.text-danger').removeClass('.error');
            },
            errorElement: 'span',
            errorClass: 'text-danger',
            submitHandler: function(form) {
            }
        });
    };

    let init = function(){
        loadStates();
        loadFormValidationChecking();
        loadSubmitFormOperations();
    };
    init();
});