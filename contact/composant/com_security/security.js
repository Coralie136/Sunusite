var url = "composant/com_security/controlersecurity.php";
var datatable = "";
//alert("ok")
$(function () {
    
    //$('#modal_edit_key').submit(function (e) {
    $('#updating').on("click", function (e) {
        //alert("ok"); return;
        e.preventDefault();
        //var lg_SECURITY_ID = $('#modal_edit_key #lg_SECURITY_ID').val();
        //var str_LOGIN = $('#modal_edit_key #str_LOGIN').val();
        var str_PASSWORD= $('#modal_edit_key #str_PASSWORD').val();
        var str_PASSWORD2= $('#modal_edit_key #str_PASSWORD2').val();
        //alert(str_PASSWORD.length);return;
        if (str_PASSWORD =="" ||  str_PASSWORD.length < 9) {
            swal({
                title: "Echec",
                text: "Veuillez remplir tous les champs.\nSi le problème persiste, assurez-vous que le mot de passe contienne plus de 8 caractères.",
                type: "error",
                confirmButtonText: "Ok"
            });
            return false;
        } else {
            if(str_PASSWORD2 == str_PASSWORD){
                editPasswordFirstConnexion(str_PASSWORD);
            }
            else{
                swal({
                title: "Echec",
                text: "Les mots de passe ne sont pas identique.",
                type: "error",
                confirmButtonText: "Ok"
            });
            return false;
            }
        }
    });
});

function editPasswordFirstConnexion(str_PASSWORD){
    $.ajax({
        url: url, // La ressource ciblée
        type: 'POST', // Le type de la requête HTTP.
        data: "task=str_PASSWORD&str_PASSWORD="+str_PASSWORD,
        dataType: 'text',
        success: function (response) {
            var obj = $.parseJSON(response);
            if (obj[0].code_statut == "1") {
                swal({
                        title: "Opération réussie!",
                        text: obj[0].results,
                        type: "success",
                        confirmButtonText: "Ok"
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                                //alert("ok")
                            window.location.href = "login.php";
                        }
                    });
            } else {
                swal({
                    title: "Echec de l'opéraion",
                    text: obj[0].results,
                    type: "error",
                    confirmButtonText: "Ok"
                });
            }
        }
    });
}
function getAccountCustomer()
{
    //alert(lg_OFFRE_ID);
    var task = "getAccountCustomer";
    $.get(url + "?task=" + task, function (json, textStatus)
    {
        var obj = $.parseJSON(json);
        if (obj[0].code_statut == "1")
        {

            var results = obj[0].results;
            if (obj[0].results.length > 0)
            {
                $.each(results, function (i, value)
                {
                    $('#edit_user #str_NAME').val(results[i].str_FIRST_NAME);
                    $('#edit_user #str_LASTNAME').val(results[i].str_LAST_NAME);
                    $('#edit_user #str_MOBILE').val(results[i].str_MOBILE_NUMBER);
                    $('#edit_user #str_FIXE').val(results[i].str_NUMBER);
                    $('#edit_user #str_EMAIL').val(results[i].str_EMAIL);
                    $('#edit_user #lg_CUSTOMER_ID').val(results[i].lg_CUSTOMER_ID);
                    $('#edit_user #str_USER').val(results[i].lg_USER_ID);
                    
                    $( "#str_ILLUSTRATION_ID" ).attr('src', './composant/com_customer/'+results[i].str_ILLUSTRATION);
                    $( "#str_ILLUSTRATION_ID" ).attr('alt', 'image '+results[i].str_FIRST_NAME);
                    $('#edit_user #str_LOGIN').val(results[i].str_LOGIN);
                    $('#edit_user #str_INSTITUTION').val( results[i].lg_INSTITUTION_ID );
                });
            }
        }
    });
}
function editAccount() {
    var form = $('#edit-key-form-user').get(0);
    var formData = new FormData(form);
    $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url		: url, // the url where we want to POST
            data	: formData, // our data object
            dataType	: 'text', // what type of data do we expect back from the server
            processData: false,
            contentType: false,
            success: function (response) {
            var obj = $.parseJSON(response);
            if (obj[0].code_statut == "1")
            {
                swal({
                    title: "Opération réussie!",
                    text: obj[0].results,
                    type: "success",
                    confirmButtonText: "Ok"
                });
                
                $.ajax("./services/center.php" + "?task=showUserAccount")
                    .done(function(data, status, jqxhr){
                        $('#contenue-application').empty();
                        $('#contenue-application').append(jqxhr.responseText).fadeIn();
                });
            } else {
                //alert(obj[0].results);
                swal({
                    title: "Echec de l'opéraion",
                    text: obj[0].results,
                    type: "error",
                    confirmButtonText: "Ok"
                });
                
            }
        }
    });
}
function getUser(lg_SECURITY_ID){
    $.ajax({
        url: url, // La ressource ciblée
        type: 'POST', // Le type de la requête HTTP.
        data: 'getUser=getUser&lg_SECURITY_ID=' + lg_SECURITY_ID,
        dataType: 'text',
        success: function (response) {
            //alert(json);return;
            var obj = $.parseJSON(response);
            if (obj[0].code_statut == "1")
            {
                var results = obj[0].results;
            
                if (obj[0].results.length > 0)
                {
                    $.each(results, function (i, value)
                    {
                        $('#str_LOGIN').val(results[i].str_LOGIN);
                        $('#lg_SECURITY_ID').val(results[i].lg_SECURITY_ID);
                    });
                }
            }
        }
    });
}
function editUserPassword(lg_SECURITY_ID, str_LOGIN, str_PASSWORD){
    $.ajax({
        url: url, // La ressource ciblée
        type: 'POST', // Le type de la requête HTTP.
        data: 'editUserPassword=editUserPassword&lg_SECURITY_ID=' + lg_SECURITY_ID + '&str_LOGIN=' + str_LOGIN+"&str_PASSWORD="+str_PASSWORD,
        dataType: 'text',
        success: function (response) {
            //alert(json);return;
            var obj = $.parseJSON(response);
            if (obj[0].code_statut == "1")
            {
                swal({
                    title: "Opération réussie !",
                    text: obj[0].results,
                    type: "success",
                    confirmButtonText: "Ok"},
                        function (isConfirm) {
                            if (isConfirm) {
                                //alert("ok")
                                window.location.href = "login.php";
                            }
                }
            );
            } else {
                //alert(obj[0].results);
                swal({
                    title: "Echec de l'opéraion",
                    text: obj[0].results,
                    type: "error",
                    confirmButtonText: "Ok"
                });
            }
        }
    });
}