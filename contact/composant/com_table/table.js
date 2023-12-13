var url = "composant/com_table/controlertable.php";
var datatable = "";
$(function () {
    getCountry();
    getAllAssurable("");
    getAllAge("");
    getAllSouscription("");
    getAllCategorie("");
    //getAllTable("", "", "", "", "", "", "");

    //useFiltre();

    $('#form_filter select').select2({
        language: "fr"
    });
    $('#add_key_form').submit(function (e) {
        e.preventDefault();
        var str_FILE_NAME = $('#add_key_form #str_FILE_NAME').val();
        extractXSLData(str_FILE_NAME);
    });

    $('.btn[id="modal_add_key"]').click(function () {
        $("#download").addClass('hidden');
        $('.modal[id="modal_add_key"]').modal('show');
    });


    //########################################################################################
    NOMBRE_FOR_REQ = 10;
    var current_index =0;
    var nombre_page=0;
    var nombre_element=0;


    var liste_courrier = [];
    // recuperation de la liste des courriers au format JSON
    function getData(indexs){
        $.get(url+"?task=getData&index="+indexs+"&lg_TABLE_ID="+($("#lg_TABLE_ID").val()==undefined?"":$("#lg_TABLE_ID").val())+"&str_ASSURABLE="+($("#str_ASSURABLE").val()==undefined?"":$("#str_ASSURABLE").val())+"&str_DATE_DEBUT="+($("#str_DATE_DEBUT").val()==undefined?"":$("#str_DATE_DEBUT").val())+"&str_DATE_FIN="+($("#str_DATE_FIN").val()==undefined?"":$("#str_DATE_FIN").val())+"&lg_AGE_ID="+($("#lg_AGE_ID").val()==undefined?"":$("#lg_AGE_ID").val())+"&lg_SOUSCRIPTION_ID="+($("#lg_SOUSCRIPTION_ID").val()==undefined?"":$("#lg_SOUSCRIPTION_ID").val())+"&lg_CATEGORIE_ID="+($("#lg_CATEGORIE_ID").val()==undefined?"":$("#lg_CATEGORIE_ID").val()),function(response){
            var data = JSON.parse(response);
            //console.log(data);
            addToListTagle(data);
        });
    }



    /// recuperation du nombre de page
    function countData(){
        //$.get(url+"?task=countData&lg_TABLE_ID="+$("#lg_TABLE_ID").val()+"&str_ASSURABLE="+$("#str_ASSURABLE").val()+"&str_DATE_DEBUT="+$("#str_DATE_DEBUT").val()+"&str_DATE_FIN="+$("#str_DATE_FIN").val()+"&lg_AGE_ID="+$("#lg_AGE_ID").val()+"&lg_SOUSCRIPTION_ID="+$("#lg_SOUSCRIPTION_ID").val()+"&lg_CATEGORIE_ID="+$("#lg_CATEGORIE_ID").val(),function(response){
        $.get(url+"?task=countData&lg_TABLE_ID="+($("#lg_TABLE_ID").val()==undefined?"":$("#lg_TABLE_ID").val())+"&str_ASSURABLE="+($("#str_ASSURABLE").val()==undefined?"":$("#str_ASSURABLE").val())+"&str_DATE_DEBUT="+($("#str_DATE_DEBUT").val()==undefined?"":$("#str_DATE_DEBUT").val())+"&str_DATE_FIN="+($("#str_DATE_FIN").val()==undefined?"":$("#str_DATE_FIN").val())+"&lg_AGE_ID="+($("#lg_AGE_ID").val()==undefined?"":$("#lg_AGE_ID").val())+"&lg_SOUSCRIPTION_ID="+($("#lg_SOUSCRIPTION_ID").val()==undefined?"":$("#lg_SOUSCRIPTION_ID").val())+"&lg_CATEGORIE_ID="+($("#lg_CATEGORIE_ID").val()==undefined?"":$("#lg_CATEGORIE_ID").val()),function(response){
            var data = JSON.parse(response);
            nombre_element = data[0].numberData;
            nombre_page = Math.ceil(data[0].numberData/NOMBRE_FOR_REQ);

            $("#nombre_element").html(nombre_element);
            $("#nombre_element_contenainer").fadeIn("slow",function(){
                getData(current_index);
            })
        })

    }
    //countData();

    function addToListTagle(data){
        $("#tbody").html("");
        let d="";
        let int_element="10";
        let tr = "";
        data[0].results.map((el,i)=>{
            //console.log(el);
            /*d+= `
            <tr id="${el.id_client_contact}">
                <td>${i+1*current_index+1}</td>
                <td>${el.nom+" "+el.prenoms}</td>
                <td>${el.email}</td>
                <td>${el.telephone}</td>
                <td>${el.date_gmt}</td>
                <td>${el.nom_pays}</td>
                <td>${el.nom_categorie}</td>
                <td>${el.nom_age} Ans </td>
                <td>${el.nom_souscription}</td>
                <td>${el.assurable}</td>
                <td><span class="icon icon-trash retirer_element" onclick="javascript:return(supprimer());" title="Supprimer"></span></td>
            </tr>
            `;*/

        tr = $('<tr class="line-data-table" id="' + el.id_client_contact + '"></tr>');
        var td_ELEMENT = $('<td class="column-data-table">' + eval(i+1*current_index+1) + '</td>');
        var td_NAME = $('<td class="column-data-table">' + el.nom +" "+ el.prenoms+ '</td>');
        var td_EMAIL = $('<td class="column-data-table">' + el.email + '</td>');
        var td_TELEPHONE = $('<td class="column-data-table">' + el.telephone + '</td>');
        var td_DATE_INSCRIPTION = $('<td class="column-data-table">' + el.date_gmt + '</td>');
        var td_PAYS = $('<td class="column-data-table">' + el.nom_pays + '</td>');
        var td_CATEGORIE = $('<td class="column-data-table">' + el.nom_categorie + '</td>');
        var td_AGE = $('<td class="column-data-table">' + el.nom_age + ' ans </td>');
        var td_SOUSCRIPTION = $('<td class="column-data-table">' + el.nom_souscription + '</td>');
        var td_ASSURABLE = $('<td class="column-data-table">' + el.assurable + '</td>');
        //var td_PAYS = $('<td class="column-data-table">' + results[i].nom_pays + '</td>');
        var btn_edit = $('<span class=" btn-action-custom btn-action-edit" id="modal_edit_key" data-toggle="modal"  title="Modifier"><i class="fa fa-edit"></i> | </span> ').click(function () {
            $('.modal[id="modal_edit_key"]').modal('show');
            var id_key = $(this).parent().parent().attr('id');
            //alert(id_key);return;
            $('#edit-key-form #lg_TABLE_ID').val(id_key);
            getKeyById(id_key);
        });

        var btn_delete = $('<span class="btn-action-custom btn-action-delete" title="Retirer" style="cursor: pointer"> <i class="icon icon-trash"></i></span>').click(function () {
            var id_key = $(this).parent().parent().attr('id');

            //$('#edit-key-form #lg_OFFRE_ID').val(id_key);
            swal({
                    title: 'Demande de Confirmation',
                    text: "Etes-vous sûr de vouloir retirer ce prospect de votre liste ?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#c8234a',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $("#"+id_key).fadeOut();
                        //console.log($(this).parents('tr'))
                        deletetable(id_key);
                    } else {
                        swal({
                            title: 'Annulation',
                            text: "Opération annulée",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#c8234a',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            //getKeyById(id_key);
        });
        var td_action = $('<td class="column-data-table" align="center"></td>');
        //td_action.append(btn_edit);
        td_action.append(btn_delete);
        tr.append(td_ELEMENT);
        tr.append(td_NAME);
        tr.append(td_EMAIL);
        tr.append(td_TELEPHONE);
        tr.append(td_DATE_INSCRIPTION);
        tr.append(td_PAYS);
        tr.append(td_CATEGORIE);
        tr.append(td_AGE);
        tr.append(td_SOUSCRIPTION);
        tr.append(td_ASSURABLE);
        tr.append(td_action);
        //tr.append(td_rien);
        //$("#examples tbody").append(tr);

        //$("#tbody").append(tr)
        int_element = i;
        $("#tbody").append(tr);
        });


        //$("#tbody").html(tr);


    }

    countData();



    // precedent
    $("#precedent").click(function(){
        current_index = current_index>NOMBRE_FOR_REQ?current_index-NOMBRE_FOR_REQ:0;

        countData();
        //$("#current_elements").html(current_index+10+"/");
        //console.log(NOMBRE_FOR_REQ)
    });
    // suitant
    $("#suivant").click(function(){
        current_index = current_index>=(nombre_page*NOMBRE_FOR_REQ)?current_index:current_index+NOMBRE_FOR_REQ;
        countData();
        //nombre_element_affiche = parseInt($("#nombre_element_contenainer #nombre_element").text());
        //alert(nombre_element_affiche)
        //$("#current_elements").html((current_index+10>nombre_element_affiche?nombre_element_affiche:current_index+10)+"/");
        //console.log(nombre_page)
    });

    // treinitialisation des parametres de recherche
    $("#form_filter").on("change", function(){
        current_index =0;
        nombre_page=0;
        nombre_element=0;
        $("#current_elements").html("");
        countData();
    });
    //########################################################################################


});
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}
$(document).ready(function(){
    $('.date_timepicker_start').datetimepicker({
        format:'d/m/Y',
        timepicker:false
    });
    $('.date_timepicker_end').datetimepicker({
        format:'d/m/Y',
        timepicker:false
    });
});
$.datetimepicker.setLocale('fr');
function useFiltre(){
    $("#form_filter").on("change", function(){
        var str_DATE_DEBUT = $("#form_filter #str_DATE_DEBUT").val();
        var str_DATE_FIN = $("#form_filter #str_DATE_FIN").val();
        var str_ASSURABLE = $("#form_filter #str_ASSURABLE").val();

        var str_AGE = $("#form_filter #str_AGE").val();
        var int_MONTANT = $("#form_filter #int_MONTANT").val();
        var str_CATEGORIE = $("#form_filter #str_CATEGORIE").val();
        if(!(str_ASSURABLE == "" && str_DATE_FIN == "" && str_DATE_DEBUT == "" && str_AGE == "" && int_MONTANT=="" && str_CATEGORIE==""))
        {
            getAllTable(str_DATE_DEBUT, str_DATE_FIN, str_ASSURABLE, str_ASSURABLE, str_AGE, int_MONTANT, str_CATEGORIE);
        }
    })
}

function getAllAssurable(lg_ASSURABLE_ID){
    var task = "getAllAssurable";
    $.get(url + "?task="+task+'&lg_ASSURABLE_ID='+lg_ASSURABLE_ID, function(json, textStatus){
        var obj = $.parseJSON(json);
        if (obj[0].code_statut == "1")
        {
            var results = obj[0].results;

            if (obj[0].results.length > 0)
            {
                $.each(results, function (i, value)//
                {
                    //alert(results[i].str_WORDING);
                    var option = $('<option value="' + results[i].id_assurable + '">'+ results[i].nom_assurable +'</option>');
                    //var options =$('<option value="' + results[i].id_assurable + '">'+ results[i].nom_assurable +'</option>');
                    //console.log(option);
                    $('#form_filter #str_ASSURABLE').append(option);
                   // $('#form_filter #str_ASSURABLE').append(options);
                });
            }
        }
    });
}
function getCountry(){
    var task = "getCountry";
    $.get(url + "?task="+task, function(json, textStatus){
        var obj = $.parseJSON(json);
        if (obj[0].code_statut == "1")
        {
            var results = obj[0].results;

            if (obj[0].results.length > 0)
            {
                $.each(results, function (i, value)//
                {

                    $(".str_COUNTRY").html(results[i].nom_pays);
                });
            }
        }
    });
}
function getAllAge(lg_AGE_ID){
    var task = "getAllAge";
    $.get(url + "?task="+task+'&lg_AGE_ID='+lg_AGE_ID, function(json, textStatus){
        var obj = $.parseJSON(json);
        if (obj[0].code_statut == "1")
        {
            var results = obj[0].results;

            if (obj[0].results.length > 0)
            {
                $.each(results, function (i, value)//
                {
                    //alert(results[i].str_WORDING);
                    var option = $('<option value="' + results[i].id_age + '">'+ results[i].nom_age +'</option>');
                    //var options =$('<option value="' + results[i].id_assurable + '">'+ results[i].nom_assurable +'</option>');
                    //console.log(option);
                    $('#form_filter #lg_AGE_ID').append(option);
                   // $('#form_filter #str_ASSURABLE').append(options);
                });
            }
        }
    });
}
function getAllSouscription(lg_SOUSCRIPTION_ID){
    var task = "getAllSouscription";
    $.get(url + "?task="+task+'&lg_SOUSCRIPTION_ID='+lg_SOUSCRIPTION_ID, function(json, textStatus){
        var obj = $.parseJSON(json);
        if (obj[0].code_statut == "1")
        {
            var results = obj[0].results;

            if (obj[0].results.length > 0)
            {
                $.each(results, function (i, value)//
                {
                    //alert(results[i].str_WORDING);
                    var option = $('<option value="' + results[i].id_souscription + '">'+ results[i].nom_souscription +'</option>');
                    //var options =$('<option value="' + results[i].id_assurable + '">'+ results[i].nom_assurable +'</option>');
                    //console.log(option);
                    $('#form_filter #lg_SOUSCRIPTION_ID').append(option);
                   // $('#form_filter #str_ASSURABLE').append(options);
                });
            }
        }
    });
}
function getAllCategorie(lg_CATEGORIE_ID){
    var task = "getAllCategorie";
    $.get(url + "?task="+task+'&lg_CATEGORIE_ID='+lg_CATEGORIE_ID, function(json, textStatus){
        var obj = $.parseJSON(json);
        if (obj[0].code_statut == "1")
        {
            var results = obj[0].results;

            if (obj[0].results.length > 0)
            {
                $.each(results, function (i, value)//
                {
                    //alert(results[i].str_WORDING);
                    var option = $('<option value="' + results[i].id_categorie + '">'+ results[i].nom_categorie +'</option>');
                    //var options =$('<option value="' + results[i].id_assurable + '">'+ results[i].nom_assurable +'</option>');
                    //console.log(option);
                    $('#form_filter #lg_CATEGORIE_ID').append(option);
                   // $('#form_filter #str_ASSURABLE').append(options);
                });
            }
        }
    });
}
function getAllTable(str_DATE_DEBUT, str_DATE_FIN, str_ASSURABLE, lg_TABLE_ID, lg_AGE_ID, lg_SOUSCRIPTION_ID, lg_CATEGORIE_ID){
    var task = "getAllTable";
    var cpt = 0;
    if($.fn.DataTable.isDataTable("#examples")){
        datatable.destroy();
    }

    //var tr = $('<tr class="line-data-table" id=""> <td colspan="10" style="text-align: center">Aucune donnée à afficher</td> </tr>');
    $.get(url+"?task="+task+"&lg_TABLE_ID="+lg_TABLE_ID+'&str_ASSURABLE='+str_ASSURABLE+"&str_DATE_DEBUT="+str_DATE_DEBUT+"&str_DATE_FIN="+str_DATE_FIN+"&lg_AGE_ID="+lg_AGE_ID+"&lg_SOUSCRIPTION_ID="+lg_SOUSCRIPTION_ID+"&lg_CATEGORIE_ID="+lg_CATEGORIE_ID, function(json, textStatus){
        cpt++;
        var obj = $.parseJSON(json);
        $("#examples tbody").empty();

        if (obj[0].code_statut == "1")
        {
            var results = obj[0].results;

            if (obj[0].results.length > 0)
            {
                $.each(results, function (i, value)//
                {
                    var tr = $('<tr class="line-data-table" id="' + results[i].id_client_contact + '"></tr>');
                    var td_rien = $("<td></td>");
                    var td_NAME = $('<td class="column-data-table">' + results[i].nom +" "+ results[i].prenoms+ '</td>');
                    var td_EMAIL = $('<td class="column-data-table">' + results[i].email + '</td>');
                    var td_TELEPHONE = $('<td class="column-data-table">' + results[i].telephone + '</td>');
                    var td_DATE_INSCRIPTION = $('<td class="column-data-table">' + results[i].date_gmt + '</td>');
                    var td_PAYS = $('<td class="column-data-table">' + results[i].nom_pays + '</td>');
                    var td_CATEGORIE = $('<td class="column-data-table">' + results[i].nom_categorie + '</td>');
                    var td_AGE = $('<td class="column-data-table">' + results[i].nom_age + ' ans </td>');
                    var td_SOUSCRIPTION = $('<td class="column-data-table">' + results[i].nom_souscription + '</td>');
                    var td_ASSURABLE = $('<td class="column-data-table">' + results[i].assurable + '</td>');
                    //var td_PAYS = $('<td class="column-data-table">' + results[i].nom_pays + '</td>');
                    var btn_edit = $('<span class=" btn-action-custom btn-action-edit" id="modal_edit_key" data-toggle="modal"  title="Modifier"><i class="fa fa-edit"></i> | </span> ').click(function () {
                        $('.modal[id="modal_edit_key"]').modal('show');
                        var id_key = $(this).parent().parent().attr('id');
                        //alert(id_key);return;
                        $('#edit-key-form #lg_TABLE_ID').val(id_key);
                        getKeyById(id_key);
                    });

                    var btn_delete = $('<span class="btn-action-custom btn-action-delete" title="Retirer" style="cursor: pointer"> <i class="icon icon-trash"></i></span>').click(function () {
                        var id_key = $(this).parent().parent().attr('id');

                        //$('#edit-key-form #lg_OFFRE_ID').val(id_key);
                        swal({
                            title: 'Demande de Confirmation',
                            text: "Etes-vous sûr de vouloir retirer ce prospect de votre liste ?",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#c8234a',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Oui',
                            cancelButtonText: 'Non',
                            confirmButtonClass: 'btn btn-success',
                            cancelButtonClass: 'btn btn-danger',
                            buttonsStyling: false,
                            closeOnConfirm: false,
                            closeOnCancel: false
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                deletetable(id_key);
                            } else {
                                swal({
                                    title: 'Annulation',
                                    text: "Opération annulée",
                                    type: 'error',
                                    showCancelButton: false,
                                    confirmButtonColor: '#c8234a',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                        getKeyById(id_key);
                    });
                    var td_action = $('<td class="column-data-table" align="center"></td>');
                    //td_action.append(btn_edit);
                    td_action.append(btn_delete);
                    tr.append(td_NAME);
                    tr.append(td_EMAIL);
                    tr.append(td_TELEPHONE);
                    tr.append(td_DATE_INSCRIPTION);
                    tr.append(td_PAYS);
                    tr.append(td_CATEGORIE);
                    tr.append(td_AGE);
                    tr.append(td_SOUSCRIPTION);
                    tr.append(td_ASSURABLE);
                    tr.append(td_action);
                    tr.append(td_rien);
                    $("#examples tbody").append(tr);
                });
            }

            if ($.fn.dataTable.isDataTable('#example')) {
                table = $('#example').DataTable();
            }
            else {
                table = $('#example').DataTable({
                    paging: false
                });
            }
        }
        datatable = $('#examples').DataTable({
            "order":[[3, "desc"]],
            "language": {
                "lengthMenu": "Afficher _MENU_ enregistrements",
                "zeroRecords": "Aucune ligne trouvée",
                "info": "Affichage des enregistrement(s) _START_ &agrave; _END_ sur _TOTAL_ enregistrement(s)",
                "infoEmpty": "Aucun enregistrement trouvé",
                "infoFiltered": "(filtr&eacute; de _MAX_ enregistrements au total)",
                "emptyTable": "Aucune donnée disponible dans le tableau",
                "search": "Recherche",
                "zeroRecords":    "Aucun enregistrement &agrave; afficher",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "Suivant",
                    "previous": "Précédent"
                }
            },
            aria: {
                sortAscending: ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre décroissant"
            }, responsive: true, retrieve: true
        });
    });
}
function deletetable(lg_TABLE_ID) {
    //alert(lg_TABLE_ID);
    $.ajax({
        url: url, // La ressource ciblée
        type: 'GET', // Le type de la requête HTTP.
        data: 'task=deleteTable&lg_TABLE_ID=' + lg_TABLE_ID,
        dataType: 'text',
        success: function (response) {
            var obj = $.parseJSON(response);
            if (obj[0].code_statut == "1")
            {
                swal({
                    title: "Opération réussie !",
                    text: obj[0].results,
                    type: "success",
                    showCancelButton: false,
                    confirmButtonColor: '#c8234a',
                    confirmButtonText: 'OK'
                });
                $('#contenue-application .modal').modal('hide');
                if ($.fn.DataTable.isDataTable('#examples')) {
                    datatable.destroy();
                }
                //getAllTable("", "", "", "", "", "", "");
            } else {
                //alert(obj[0].results);
                swal({
                    title: "Echec de l'opéraion",
                    text: obj[0].results,
                    type: "error",
                    confirmButtonText: "Ok"
                });
                $('#contenue-application .modal').modal('hide');
            }
        }
    });
}
function getKeyById(lg_TABLE_ID)
{
    //alert(lg_OFFRE_ID);
    var task = "getAllTable";
    $.get(url + "?task=" + task + "&lg_TABLE_ID=" + lg_TABLE_ID, function (json, textStatus)
    {
        var obj = $.parseJSON(json);
        if (obj[0].code_statut == "1")
        {

            var results = obj[0].results;
            if (obj[0].results.length > 0)
            {
                $.each(results, function (i, value)
                {
                    $('#modal_edit_key #str_WORDING').val(results[i].str_WORDING);
                    $('#modal_edit_key #lg_TABLE_ID').val(results[i].lg_TABLE_ID);
                    $('#modal_edit_key #int_NUMBER_PLACE').val(results[i].int_NUMBER_PLACE);
                });
            }
        }
    });
}
function extractXSLData(str_FILE_NAME) {
    var str_DATE_DEBUT = $("#form_filter #str_DATE_DEBUT").val();
    str_DATE_DEBUT = (str_DATE_DEBUT==undefined?"":str_DATE_DEBUT)
    var str_DATE_FIN = $("#form_filter #str_DATE_FIN").val();
    str_DATE_FIN = (str_DATE_FIN==undefined?"":str_DATE_FIN)
    var str_ASSURABLE = $("#form_filter #str_ASSURABLE").val();
    str_ASSURABLE = (str_ASSURABLE==undefined?"":str_ASSURABLE)
    var lg_AGE_ID = $("#form_filter #lg_AGE_ID").val();
    lg_AGE_ID = (lg_AGE_ID==undefined?"":lg_AGE_ID)
    var lg_SOUSCRIPTION_ID = $("#form_filter #lg_SOUSCRIPTION_ID").val();
    lg_SOUSCRIPTION_ID = (lg_SOUSCRIPTION_ID==undefined?"":lg_SOUSCRIPTION_ID)
    var lg_CATEGORIE_ID = $("#form_filter #lg_CATEGORIE_ID").val();
    lg_CATEGORIE_ID = (lg_CATEGORIE_ID==undefined?"":lg_CATEGORIE_ID)

    $.ajax({
        url: url, // La ressource ciblée
        type: 'POST', // Le type de la requête HTTP.
        data: "task=extractXSLData&str_DATE_DEBUT="+str_DATE_DEBUT+"&str_DATE_FIN="+str_DATE_FIN+"&str_ASSURABLE="+str_ASSURABLE+"&str_FILE_NAME="+str_FILE_NAME+"&lg_AGE_ID="+lg_AGE_ID+"&lg_SOUSCRIPTION_ID="+lg_SOUSCRIPTION_ID+"&lg_CATEGORIE_ID="+lg_CATEGORIE_ID,
        dataType: 'text',
        success: function (response) {
            var obj = $.parseJSON(response);
            if (obj[0].code_statut == "1") {
                window.location.href = obj[0].file;
                $('#contenue-application .modal').modal('hide');/*
                $("#download").removeClass('hidden');
                $("#download").attr('href', obj[0].file);
                swal({
                    title: "Opération réussie!",
                    text: "Operation reussi",
                    type: "success",
                    confirmButtonText: "Ok"
                });*/
            } else {
                swal({
                    title: "Echec de l'opéraion",
                    text: obj[0].results,
                    type: "error",
                    confirmButtonColor: '#c8234a',
                    confirmButtonText: "Ok"
                });
                $('#contenue-application .modal').modal('hide');
            }
        }
    });
}
function isInteger(string) {
    var regx = /^\d+$/;
    if (!regx.test(string)) {
        return false
    } else {
        return true;
    }
}