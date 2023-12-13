/**
Custom module for you to write your own javascript functions
**/
var Custom = function () {

    // private functions & variables

    var myFunc = function(text) {
        alert(text);
    }

    // public functions
    return {

        //main function
        init: function () {
            //initialize here something.            
        },

        //some helper function
        doSomeStuff: function () {
            myFunc();
        }

    };

}();

jQuery(document).ready(function() {    
   Custom.init(); 
});

/***
Usage
***/
//Custom.doSomeStuff();







//var Custom  = function () {
//    $(document).ready(function(){
//        alert('test');
//    });
//}();


//------------------------------------------------------
// CHECK THE READ CHECKBOX ON THREE OTHERS BUTTON CLICK
//------------------------------------------------------

function checkRead (data) {
    
    if ($('#create'+data)[0].checked || $('#edit'+data)[0].checked || $('#status'+data)[0].checked) {
        $('#read'+data).each(function() {
            $(this).attr('checked', 'checked');
            this.checked    = 'checked';
        });
    } else {
        $('#read'+data).each(function() {
            $(this).removeAttr('checked');
        });
    }
    
}

//------------------------------------------------------

//------------------------------------------------------------------------------
// UNCHECK AND DISABLE ALL CHECKBOXES OF A MODULE WHEN READ BUTTON IS UNCHECKED
//------------------------------------------------------------------------------

function requiredCheck (data) {
    
    var access  = ['create', 'edit', 'status'];
    
    if (!$('#read'+data)[0].checked) {
           $(access).each(function() {
               $('#'+this+data).each(function() {
                   this.checked     = '';
               });
           });
    }
    
}

//------------------------------------------------------------------------------

//------------------------------------------------------------
// UNCHECK AND DISABLE ALL CHECKBOXES FOR A DISBALED CATEGORY
//------------------------------------------------------------

function checkItem (item, data) {
    
    var access  = ['create', 'read', 'edit', 'status'];
    
    if ($('#'+item)[0].checked) {
        $(data).each(function(index, element) {
           $(access).each(function() {
               $('#'+this+element).each(function() {
                   this.disabled    = '';
               });
           });
            
           $('#read'+element)[0].checked    = 'checked';
        });
    } else {
        $(data).each(function(index, element) {
           $(access).each(function() {
               $('#'+this+element).each(function() {
                   this.checked     = '';
                   this.disabled    = 'disabled';
               });
           });
        });
    }
    
}

//------------------------------------------------------------

//-----------------------------------------------------------------
// DISPLAY ALL THE ACTIONS BUTTON IF THERE ARE CHECKBOXES SELECTED
//-----------------------------------------------------------------

function selectItems () {
    
    var items   = 0;
    
    $('.checkboxes').each(function () {
        if (this.checked) {
            items   += parseInt(this.value);
        }
    });
    
    if (items > 0) {
        $('.actions').each(function () {
            $(this).show("fast");
        });
    } else {
        $('.actions').each(function () {
            $(this).hide(500);
        });
        $('[name="allId"]').each(function() {
            this.checked = '';
        });
    }
    
}

//-----------------------------------------------------------------

//-----------------------------------------------------------------
// DISPLAY ALL THE ACTIONS BUTTON IF THERE ARE CHECKBOXES SELECTED
//-----------------------------------------------------------------

function checkItems () {
    
    if ($('[name="allId"]')[0].checked) {
        
//        var items   = 0;
//    
//        $('.checkboxes').each(function () {
//            if (this.checked) {
//                items   += parseInt(this.value);
//            }
//        });
//        
//        if (items > 0) {
            $('.actions').each(function () {
                $(this).show("fast");
            });
//        }
    } else {
        $('.actions').each(function () {
            $(this).hide(500);
        });
    }
    
}

//-----------------------------------------------------------------