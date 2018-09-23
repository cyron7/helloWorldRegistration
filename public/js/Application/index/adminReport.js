$(document).ready(function(){
    let checkNullReturnBlank = function(item) {
        return item = (item == null) ? '' : item;
    };
    let loadReport = function(){
        jQuery.getJSON('report/get', function(data){
            let items = [];
            $.each( data.registeredUsers, function( key, val ) {
                items.push( "<tr>" +
                    "<td>" + checkNullReturnBlank(val.FirstName) + "</td>" +
                    "<td>" + checkNullReturnBlank(val.LastName) + "</td>" +
                    "<td>" + checkNullReturnBlank(val.Address1) + "</td>" +
                    "<td>" + checkNullReturnBlank(val.Address2) + "</td>" +
                    "<td>" + checkNullReturnBlank(val.City) + "</td>" +
                    "<td>" + checkNullReturnBlank(val.State) + "</td>" +
                    "<td>" + checkNullReturnBlank(val.Zip) + "</td>" +
                    "<td>" + checkNullReturnBlank(val.Country) + "</td>" +
                    "</tr>" );
            });
            $('table#adminReport > tbody:last-child').append(items.join( "" ));
            $('.loader').hide();
            $('#tableReportContainer').removeClass('d-none');
        });
    };
    let init = function(){
        loadReport();
    };
    init();
});