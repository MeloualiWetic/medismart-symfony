// this variable is the list in the dom, it's initiliazed when the document is ready
var $collectionHolder;
// the link which we click on to add new items
var $addNewItem = $('<a href="#" class="btn btn-info">Add new Detail</a>');
// when the page is loaded and ready
$(document).ready(function () {
    $collectionHolder = $('#detail_list');
    $('#consultation_detailConsultations').hide();
    // $('.col-form-label').hide();
    // append the add new item link to the collectionHolder
    // $collectionHolder.append($addNewItem);
    // $('#new-detail').append($addNewItem);
    $collectionHolder.data('index', $collectionHolder.find('.detail-consultation').length)
    $collectionHolder.find('.detail-consultation').each(function () {
        // $(this) means the current panel that we are at
        // which means we pass the panel to the addRemoveButton function
        // inside the function we create a footer and remove link and append them to the panel
        // more informations in the function inside
        // addRemoveButton($(this));


    });


         $('#prestations-list').change(function (e) {

        $('#prestation-libelle').val( $('#prestations-list').find(":selected").text());
        $('#prestation-frais').val( $('#prestations-list').val());
        $('#prestation-id').val( $('#prestations-list').val());

             var selected = $('#prestations-list').val();
             var inputID = $('#prestation-id').val();

        if (selected == inputID ){
            // $("#prestations-list option:selected").remove();
            $("#prestations-list option:selected").attr('disabled', 'disabled');
        }
    })

    $('#new-row').click(function (e) {
        // preventDefault() is your  homework if you don't know what it is
        // also look up preventPropagation both are usefull
        e.preventDefault();
        // create a new form and append it to the collectionHolder
        // and by form we mean a new panel which contains the form
        addNewForm();
    })

});
/*
 * creates a new form and appends it to the collectionHolder
 */
function addNewForm() {

    // getting the prototype
    // the prototype is the form itself, plain html
    var prototype = $collectionHolder.data('prototype')

    // get the index
    // this is the index we set when the document was ready, look above for more info
    var index = $collectionHolder.data('index');
    // create the form
    var newForm = prototype;
    // replace the __name__ string in the html using a regular expression with the index value
    console.log("new Form " +newForm);
    newForm = newForm.replace(/__name__/g, index);
    newForm = newForm.replace(/div/g, 'td');
    var idLibelle = "consultation_detailConsultations_"+index+"_prestationLibelle"
    var idFrais = "consultation_detailConsultations_"+index+"_frais"
    var idPrestation = "consultation_detailConsultations_"+index+"_prestation"

    // incrementing the index data and setting it again to the collectionHolder
    $collectionHolder.data('index', index+1);
    // create the panel-body and append the form to it
    var $Body = $('<tr></tr>').append(newForm);
    // $panel.append($panelBody);

    addRemoveButton($Body);

    $($collectionHolder).append($Body);

    $('#'+idLibelle).val($('#prestation-libelle').val());
    $('#'+idFrais).val($('#prestation-frais').val());
    $('#'+idPrestation).val($('#prestation-id').val);
    $('#'+idPrestation).hide();
}

/**
 * adds a remove button to the panel that is passed in the parameter
 * @param $row
 */
function addRemoveButton ($row) {
    // create remove button
    var $removeButton = $('<a href="#" class="btn btn-danger">Supprimer</a>');
    var $actionTd = $('<td ></td>').append($removeButton);

    $removeButton.click(function (e) {
        e.preventDefault();
    $(e.target).parents('.detail-consultation').slideUp(1000, function () {
        $(this).remove();
    })
    });



    $row.append($actionTd);
}



//add new detail

//remove detail