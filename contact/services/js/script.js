$(function () {
    
    getNumberOfKeyactivation();
    getNumberOfRequest();
    getNumberOfSuscriber();
    getNumberOfOffres();
    $('a#modal_edit_user').click(function (e) {
        e.preventDefault();
        var id_key = $(this).parent().attr('id');
        getSecurity(id_key);
        $('.modal[id="modal_edit_user"]').modal('show');
    });
    $('#link-deconnexion').click(function (e) {
        e.preventDefault();
        deconnexion();
    });
    $('#edit-user-form').submit(function (e) {
        e.preventDefault();
        var lg_SECURITY_ID = $('#edit-user-form #lg_SECURITY_ID').val();
        var str_LOGIN = $('#edit-user-form #str_LOGIN').val();
        var str_LAST_NAME = $('#edit-user-form #str_LAST_NAME').val();
        var str_FIRST_NAME = $('#edit-user-form #str_FIRST_NAME').val();
        var str_EMAIL = $('#edit-user-form #str_EMAIL').val();
        var str_PHONE = $('#edit-user-form #str_PHONE').val();
        var lg_LANGUAGE_ID = $('#edit-user-form #combo-language').val();
        var str_PASSWORD = $('#edit-user-form #str_PASSWORD').val();
        var str_PASSWORD_CONFIRM = $('#edit-user-form #str_PASSWORD_CONFIRM').val();
        var str_PASSWORD_HOLD = $('#edit-user-form #str_PASSWORD_HOLD').val();
        if (lg_SECURITY_ID == "" || str_LOGIN == "" || str_LAST_NAME == "" || str_FIRST_NAME == "" || str_EMAIL == "" || str_PHONE == "" || lg_LANGUAGE_ID == "" || str_PASSWORD == "" || str_PASSWORD_CONFIRM == "" || str_PASSWORD_HOLD == "") {
            swal({
                title: "Echec",
                text: "Veuillez remplir tous les champs",
                type: "error",
                confirmButtonText: "Ok"
            });
            return false;
        } else if (str_PASSWORD != str_PASSWORD_CONFIRM) {
            swal({
                title: "Echec",
                text: "Les mots de passe ne sont pas conformes",
                type: "error",
                confirmButtonText: "Ok"
            });
            return false;
        } else {
            editProfil(lg_SECURITY_ID, str_LOGIN, str_PASSWORD, str_PASSWORD_HOLD, str_FIRST_NAME, str_LAST_NAME, str_EMAIL, str_PHONE, lg_LANGUAGE_ID)
        }


    });
});
function getSecurity(lg_SECURITY_ID)
{
    //alert(lg_OFFRE_ID);
    var url = "composant/com_security/controlersecurity.php";
    var task = "getAllSecurity";
    $.get(url + "?task=" + task + "&lg_SECURITY_ID=" + lg_SECURITY_ID, function (json, textStatus)
    {
        var obj = $.parseJSON(json);
        viderChamps();
        if (obj[0].code_statut == "1")
        {
            var results = obj[0].results;
            if (obj[0].results.length > 0)
            {
                $.each(results, function (i, value)
                {
//                    alert(results[i].lg_SECURITY_ID);
                    $('#modal_edit_user #str_LOGIN').val(results[i].str_LOGIN);
                    $('#modal_edit_user #str_LAST_NAME').val(results[i].str_LAST_NAME);
                    $('#modal_edit_user #str_FIRST_NAME').val(results[i].str_FIRST_NAME);
                    $('#modal_edit_user #str_EMAIL').val(results[i].str_EMAIL);
                    $('#modal_edit_user #str_PHONE').val(results[i].str_PHONE);
                    $('#modal_edit_user #lg_SECURITY_ID').val(results[i].lg_SECURITY_ID);
                    //$('#modal_edit_key #combo-language option[value="' + results[i].lg_LANGUAGE_ID + '"]').attr('selected', 'selected');
                    getAllLanguageForCombo("", results[i].lg_LANGUAGE_ID, "combo-language");
                });
            } /*else {
             getAllLanguageForComboInput("", "", "combo-language");
             }*/
        }
    });
}
function viderChamps() {
    $('#modal_edit_user #str_LOGIN').val('');
    $('#modal_edit_user #str_LAST_NAME').val('');
    $('#modal_edit_user #str_FIRST_NAME').val('');
    $('#modal_edit_user #str_EMAIL').val('');
    $('#modal_edit_user #str_PHONE').val('');
    $('#modal_edit_user #lg_SECURITY_ID').val('');
    $('#modal_edit_user #str_PASSWORD').val('');
    $('#modal_edit_user #str_PASSWORD_CONFIRM').val('');
    $('#modal_edit_user #str_PASSWORD_HOLD').val('');
}
function getAllLanguageForCombo(lg_LANGUAGE_ID, lg_LANGUAGE_ID_SELECT, id_combo)
{//le paramètre lg_LANGUAGE_ID_SELECT a été mis pour toutes les fois ou je voudrais modifier la clé. Elle me permet d'avoir par exemple dans la page de la liste des clés l'offre de la ligne concerné deja selectioné
    var url = "composant/com_security/controlersecurity.php";
    var task = "getAllLanguage";
    $.get(url + "?task=" + task + "&lg_LANGUAGE_ID=" + lg_LANGUAGE_ID, function (json, textStatus)
    {
        var obj = $.parseJSON(json);
        $('#modal_edit_user #' + id_combo).empty();
        if (obj[0].code_statut == "1")
        {
            var results = obj[0].results;
            if (obj[0].results.length > 0)
            {
                $.each(results, function (i, value)
                {
                    var select = (results[i].lg_LANGUAGE_ID == lg_LANGUAGE_ID_SELECT) ? "selected" : "";
                    var option = $('<option class="option-item-offer"' + select + ' value="' + results[i].lg_LANGUAGE_ID + '">' + results[i].str_NAME + '</option>');
                    $('#modal_edit_user #' + id_combo).append(option);
                });
            }
            $('#modal_edit_user #' + id_combo).select2({
                language: "fr"
            });
        }
    });
}

function editProfil(lg_SECURITY_ID, str_LOGIN, str_PASSWORD, str_PASSWORD_HOLD, str_FIRST_NAME, str_LAST_NAME, str_EMAIL, str_PHONE, lg_LANGUAGE_ID) {
    var url = "composant/com_security/controlersecurity.php";
    $.ajax({
        url: url, // La ressource ciblée
        type: 'POST', // Le type de la requête HTTP.
        //data: 'editPartner=editPartner&lg_PARTNER_ID=' + lg_PARTNER_ID + '&str_NAME=' + str_NAME + '&str_DESCRIPTION=' + str_DESCRIPTION + '&lg_LANGUAGE_ID=' + lg_LANGUAGE_ID,
        data: 'editSecurity=editSecurity&lg_SECURITY_ID=' + lg_SECURITY_ID + '&str_LOGIN=' + str_LOGIN + '&str_PASSWORD=' + str_PASSWORD + '&str_PASSWORD_HOLD=' + str_PASSWORD_HOLD + '&str_FIRST_NAME=' + str_FIRST_NAME + '&str_LAST_NAME=' + str_LAST_NAME + '&str_EMAIL=' + str_EMAIL + '&str_PHONE=' + str_PHONE + '&lg_LANGUAGE_ID=' + lg_LANGUAGE_ID,
        dataType: 'text',
        success: function (response) {
            //alert(json);return;
            var obj = $.parseJSON(response);
            if (obj[0].code_statut == "1")
            {
                swal({
                    title: "Opération réussie!",
                    text: obj[0].results,
                    type: "success",
                    confirmButtonText: "Ok"
                });
                $('.modal').modal('hide');
                datatable.destroy();
                getAllSecurity("");
                //swal("Opération réussie!", obj[0].results, "success");
            } else {
                //alert(obj[0].results);
                swal({
                    title: "Echec de l'opération",
                    text: obj[0].results,
                    type: "error",
                    confirmButtonText: "Ok"
                });
                //$('.modal').modal('hide');
            }
        }
    });
}

function deconnexion()
{
    //alert(lg_OFFRE_ID);
    var url = "composant/com_security/controlersecurity.php";
    var task = "getAllSecurity";
    $.get(url + "?task=deconnexion", function (json, textStatus)
    {
        var obj = $.parseJSON(json);
        if (obj[0].code_statut == "1")
        {
            window.location.replace("index.php");
        } else {
            swal({
                title: "Echec de l'opération",
                text: "Erreur lors de la deconnexion",
                type: "error",
                confirmButtonText: "Ok"
            });
        }
    });
}
function getNumberOfKeyactivation()
{
    //alert(lg_OFFRE_ID);
    var url = "composant/com_accueil_admin/controleraccueil_admin.php";
    var task = "getNumberOfKeyactivation";
    $.get(url + "?task=getNumberOfKeyactivation", function (json, textStatus)
    {
        var obj = $.parseJSON(json);
        $('.info-box-number[id=number_key_activation]').html('<i class="fa fa-refresh fa-spin"></li>');
        //<i class="fa fa-refresh fa-spin"></li>
        if (obj[0].code_statut == "1")
        {
            var results = obj[0].results;
            $.each(results, function (i, value)
            {
                $('.info-box-number[id=number_key_activation]').empty().html(results[i].int_NUMBER);
            });
        }
    });
}
function getNumberOfRequest()
{
    //alert(lg_OFFRE_ID);
    var url = "composant/com_accueil_admin/controleraccueil_admin.php";
    var task = "getNumberOfRequest";
    $.get(url + "?task=getNumberOfRequest", function (json, textStatus)
    {
        var obj = $.parseJSON(json);
        $('.info-box-number[id=number_requete]').html('<i class="fa fa-refresh fa-spin"></li>');
        //<i class="fa fa-refresh fa-spin"></li>
        if (obj[0].code_statut == "1")
        {
            var results = obj[0].results;
            $.each(results, function (i, value)
            {
                $('.info-box-number[id=number_requete]').empty().html(results[i].int_NUMBER);
            });
        }
    });
}

function getNumberOfSuscriber()
{
    //alert(lg_OFFRE_ID);
    var url = "composant/com_accueil_admin/controleraccueil_admin.php";
    var task = "getNumberOfSuscriber";
    $.get(url + "?task=getNumberOfSuscriber", function (json, textStatus)
    {
        var obj = $.parseJSON(json);
        $('.info-box-number[id=number_suscriber]').html('<i class="fa fa-refresh fa-spin"></li>');
        //<i class="fa fa-refresh fa-spin"></li>
        if (obj[0].code_statut == "1")
        {
            var results = obj[0].results;
            $.each(results, function (i, value)
            {
                $('.info-box-number[id=number_suscriber]').empty().html(results[i].int_NUMBER);
            });
        }
    });
}

function getNumberOfOffres()
{
    //alert(lg_OFFRE_ID);
    var url = "composant/com_accueil_admin/controleraccueil_admin.php";
    var task = "getNumberOfOffres";
    $.get(url + "?task=getNumberOfOffres", function (json, textStatus)
    {
        var obj = $.parseJSON(json);
        $('.info-box-number[id=number_offer]').html('<i class="fa fa-refresh fa-spin"></li>');
        //<i class="fa fa-refresh fa-spin"></li>
        if (obj[0].code_statut == "1")
        {
            var results = obj[0].results;
            $.each(results, function (i, value)
            {
                $('.info-box-number[id=number_offer]').empty().html(results[i].int_NUMBER);
            });
        }
    });
}