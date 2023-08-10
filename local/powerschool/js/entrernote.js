
$(document).ready(function () {
    // $(".btnmodnote").click(function (e) { 
        //     e.preventDefault();
        
        //      $(".inputnoteuser").val($(".inputmodi").val());
        // });
        var btnmo=document.querySelectorAll(".btnmodnote")
        btnmo.forEach((e) => {
            e.addEventListener("click",(e)=>{
                 e.preventDefault();
             var inputmodi=document.querySelectorAll(".inputmodi")
             
             inputmodi.forEach((e1)=>{
                      alert(e1.value)
                  })
                //  alert("f")
         })
        });
});