<?php

    // title to be set on article's form
    $frmTitle   = "Ajouter des photos";
    $submit     = "Ajouter";
    $color      = "red-thunderbird";
    $icon       = "camera";
    $required   = (empty($image)) ? 'required="required"' : '';

    ?>

    <!-- BEGIN CONTENT -->
    <div class="page-content">

        <!-- BEGIN PAGE TITLE-->
        <h1 class="page-title"> <?php echo strtoupper($page_title); ?> <br />
            <small>[ <?php echo ucfirst($page_description); ?> ]</small>
        </h1>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->

        <!-- BEGIN PAGE BODY -->
        <div class="row">
            <div class="col-md-12">

                <!-- BEGIN PROFILE CONTENT -->
                <div class="profile-content">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="btn-group">
                                <a href="<?php echo site_url("home/"); ?>" class="btn btn-outline <?php echo $color; ?>">
                                    <i class="fa fa-long-arrow-left"></i>&nbsp; Retour au site
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="fa fa-camera theme-font"></i>
                                        <span class="caption-subject font-red-thunderbird bold uppercase">Photos</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#photo_tab_1" data-toggle="tab">Gérer</a>
                                        </li>

                                        <li>
                                            <a href="#photo_tab_2" data-toggle="tab">Ajouter</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <?php
                                    $feedBack   = $this->session->flashdata('retour');
                                    if (isset($feedBack)) {
                                        ?>
                                        <div class="alert alert-<?php echo $feedBack['type']; ?> alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                            <?php echo $feedBack['message']; ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PROFILE CONTENT -->

            </div>
        </div>
        <!-- END PAGE BODY -->

    </div>
    <!-- END CONTENT -->


    <script type="text/javascript">

        var controller = 'admin/ajax';
        var base_url   = '<?php echo site_url(); //you have to load the "url_helper" to use this function ?>';
        var aid        = '<?php echo $aid; // article id ?>';

        //    $("my-dropzone").dropzone();
        //    alert('test');

        //----------------------------------------------------------------------------------------------------
        // GET ALL INFORMATIONS ABOUT THE FILE SELECTED AND DISPLAY THEM WITH A SUBMIT BUTTON IN SUCCESS CASE
        //----------------------------------------------------------------------------------------------------
        function importDetail() {

            // Get the input file
            var fileInput       = $('#import-file');

            // Get the file details elements
            var tableDetail     = $('#import-detail');
            var fileDetail      = $('#import-detail-file');
            var fileError       = $('#import-detail-error');
            var submitButton    = $('#submit-import-file');

            // Get the selected file if exists
            var selectedFile    = ((typeof fileInput !== undefined) && (fileInput[0].files.length > 0)) ? fileInput[0].files[0] : '';

            // Set the array of granted file extensions
            var grantedExtension    = ['.gif', '.jpg', '.jpeg', '.svg'];
            var grantedFileTypes    = ['image/gif', 'image/jpeg', 'image/png', 'image/svg+xml'];
            var fileExtension       = '';

            // Display details about selected file or display a "empty-message" if there no selected file
            if (selectedFile != '') {

                // Get the file extension
                fileExtension   = selectedFile.name.substring(selectedFile.name.lastIndexOf('.'));

                // Check if the file extension is correct
                if ((grantedExtension.indexOf(fileExtension) != (-1)) && (grantedFileTypes.indexOf(selectedFile.type) != (-1))) {
                    fileError.toggleClass('hidden-element', true); // hide file error
                    tableDetail.toggleClass('table-danger', false); // remove table danger state
                    tableDetail.toggleClass('table-info', true); // add table info state
                    fileDetail.text(selectedFile.name); // display file name
                    fileDetail.toggleClass('hidden-element', false); // show file detail
//                    submitButton.toggleClass('hidden-element', false); // show submit button
                    submitButton.disabled   = '';
                    tableDetail.toggleClass('hidden-element', false); // show table detail
                } else {
                    fileDetail.toggleClass('hidden-element', true); // hide file detail
//                    submitButton.toggleClass('hidden-element', true); // hide submit button
                    submitButton.disabled   = 'disabled';
                    tableDetail.toggleClass('table-info', false); // remove table info state
                    tableDetail.toggleClass('table-danger', true); // add table danger state
                    fileError.toggleClass('hidden-element', false); // show file error
                    tableDetail.toggleClass('hidden-element', false); // show table detail
                }

            } else {

                tableDetail.toggleClass('table-info', false); // remove table info state
                tableDetail.toggleClass('table-danger', false); // remove table danger state
                fileError.toggleClass('hidden-element', true); // hide file error
//                submitButton.toggleClass('hidden-element', true); // hide submit button
                submitButton.disabled   = 'disabled';
                fileDetail.text('Aucun fichier n\'a été sélectionné !'); // display empty-message
                fileDetail.toggleClass('hidden-element', false); // show file detail
                tableDetail.toggleClass('hidden-element', false); // show table detail

            }

        }
        //----------------------------------------------------------------------------------------------------

        //-----------------------------------------------------------------------------
        // LOAD ALL THE CURRENT ARTICLE PHOTOS AND DISPLAY THEM INTO THE TAB CONTAINER
        //-----------------------------------------------------------------------------
        function load_articlePhoto() {

            // Empty the select input field
            $('#photo_tab_1').html('');

            $.ajax({
                'url': base_url + controller + '/loadSliderPhoto/',
                'type': 'GET', //the way you want to send data to your URL
                /*'data': {
                    'aid':  aid, // article id
                },*/
                'success': function(data) { //probably this request will return anything, it'll be put in var "data"
                    var photoTab = $('#photo_tab_1'); //jquery selector (get element by id)
                    if (data) {
                        photoTab.html(data);
//                        swal('hoy', 'hey', 'success');
                    } // End if
                } // End success
            });
        } //
        //-----------------------------------------------------------------------------

        //-------------------------------------
        // FUNCTION TO DELETE AN ARTICLE PHOTO
        //-------------------------------------
        function deleteSliderPhoto  (pid) {
            // console.log(pid);return;
            // Sweetalert confirmation
            swal({
                    title: "Etes vous sur?",
                    text: "Une fois supprimé l'image du slider ne pourra plus être restauré!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    cancelButtonText: "Annuler",
                    confirmButtonText: "Supprimer",
                    closeOnConfirm: false
                },
                function() {
                    $.ajax({
                        'url': base_url + controller + '/deleteSliderPhoto/?delete='+pid,
                        'type': 'GET', //the way you want to send data to your URL
                        'data': {
                            //'pid':      pid, // photo's id
                            'aid':      aid, // article's id
                        },
                        'success': function() { //probably this request will return anything, it'll be put in var "data"
                            load_articlePhoto();
                            swal({
                                title:  "Photo supprimée",
                                type:   "success",
                                button: "false",
                            });

                        }
                    });
                    //load_articlePhoto();
                });

        } // End function
        //-------------------------------------


    </script>
    <?php

?>