$(document).ready(function(){

   var currentIdCompany = 0;
   $('#id_company').click(function(){
      
      var idCompany = $(this).val();
      if( idCompany.length > 0 && currentIdCompany != idCompany ){
         currentIdCompany = idCompany; 
         $('#categorySelect').load(baseUrl + '/ticket/filter-category/id_company/'+ idCompany)
      }
      
   });
   
});