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
            $('form#registrationForm input[name="' + key + '"]').addClass('is-invalid');
        });
    };

    let loadSubmitFormOperations = function(){
        //TODO: Need to remove the error blocks
        // $('form#registrationForm input').onchange(function(e){
        //     this.removeClass('is-invalid');
        // });
        $('form#registrationForm').submit(function(e){
            e.preventDefault();
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
                    } else {
                        $('div#mainMessageBox')
                            .removeClass('alert-primary')
                            .addClass('alert-danger')
                            .text('Failed to register');
                        setFormErrors(data.messages);
                    }
                }
            });
        });
    };

    let init = function(){
        loadStates();
        loadSubmitFormOperations();

    };
    init();
});