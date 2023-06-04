// fetch('corde_petzl_line6.jpg')
// .then(function(response) {
//   return response.blob();
// })
// .then(function(myBlob) {
//   const objectURL = URL.createObjectURL(myBlob);
//   myImage.src = objectURL;
// });

// button.onclick = () => {
//   fetch("../images/" + navSearch + ".jpg")
//   .then(function(response) {
//     return response.blob();
//   })
//   .then(function(myBlob) {
//     const objectURL = URL.createObjectURL(myBlob);
//     myImage.src = objectURL;
//   });
// }

$(document).ready(function(){
  $('#navSearch').keyup(function(){
    var input = $(this).val();
    if (input != "") {
      $.ajax({
        url:'core/fetchBDD.php',
        method:'POST',
        data:{input:input},
        success:function(data){
          $('.searchResult').html(data);
          //$('.searchResult').css('display', 'block');
          $('#searchResultsContainer').show();
        }
      })
    }else {
      //$('.searchResult').css('display', 'none');
      $('#searchResultsContainer').hide();
    }
  });
});
