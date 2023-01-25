$(document).ready(function(){
	$('.cloner').click(multipleClones);
	$('.remover').click(remove);
        $('#save-client-category').validate({ 
            rules : {
            'productsIds[]': { required: true, minlength: 1 }
          }
//                submitHandler: function(form) {
//                }
            });
//        
//        
//        $(".validaSend").click(function(e){
//        e.preventDefault();
//        
////            $(this).submit();
//        });
        
});
function callbackAction(clone, index, callback){
	switch (callback) {
	case 'field-action':
	case 'document-action':
	default:
		defaultAction(clone,index);
		break;
	}
}
function defaultAction(clone, index){
	clone.css({display : 'block'});
}