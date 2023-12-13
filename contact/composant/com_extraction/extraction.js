var url = "composant/com_extraction/controlerExtraction.php";
var datatable = "";
$(function () {
    const NOMBRE_FOR_REQ = 10;
    let current_index =0;
    let nombre_page=0;
    let nombre_element=0;



    let liste_courrier = [];
    // recuperation de la liste des courriers au format JSON
    function getData(index){
        $.get(url+"?task=getAllExtraction&index="+index+`&id=${$("#id").val()}&libelle=${$("#libelle").val()}&params=${$("#params").val()}&nbre=${$("#nbre").val()}`,function(response){
            let data = JSON.parse(response);
            console.log(data);
            addToListTagle(data);
        })
    }



    /// recuperation du nombre de page
    function countData(){
        $.get(`${url}?task=countData&id=${$("#id").val()}&libelle=${$("#libelle").val()}&params=${$("#params").val()}&nbre=${$("#nbre").val()}`,function(response){
            let data = JSON.parse(response);
            nombre_element = data[0].numberData;
            nombre_page = Math.ceil(data[0].numberData/NOMBRE_FOR_REQ);

            $("#nombre_element").html(nombre_element);
            $("#nombre_element_contenainer").fadeIn("slow",function(){
                getData(current_index);
            })
        })
    }


    function addToListTagle(data){
        let d="";
        data.map((el,i)=>{
            d+= `
            <tr>
                <td>${i+1*current_index+1}</td>
                <td>${el.str_EXTRACTION_ID}</td>
                <td>${el.str_PARAM}</td>
                <td>${el.dt_CREATED}</td>
                <td>${el.int_NUMBER_EXTRACT}</td>
                <td><a href="${el.str_FILE}" target="_blank" class=" btn-action-custom fa fa-download"  title="Télécharger le courrier"></a></td>
            </tr>
            `
        });

        $("#tbody").html(d);

    }

    countData();


    // precedent
    $("#precedent").click(function(){
        current_index = current_index>NOMBRE_FOR_REQ?current_index-NOMBRE_FOR_REQ:0;
        countData();
    });
    // suitant
    $("#suivant").click(function(){
        current_index = current_index>=(nombre_page*NOMBRE_FOR_REQ)?current_index:current_index+NOMBRE_FOR_REQ;
        countData();
    });

    // treinitialisation des parametres de recherche
    $(".critere").on("change", function(){
        current_index =0;
        nombre_page=0;
        nombre_element=0;
        countData();
    });

});


