/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function onLoad(){let search = document.getElementById("search-bar");
search.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
      pretraga();
  }
});
let dugme=document.getElementById("msg_send_btn");
dugme.addEventListener("click",function(){
    let poruka=document.getElementsByName("porukica")[0].value;
   posalji(poruka);
   
});

}

let osoba;
function pretraga(){
    osoba=document.getElementById("search-bar").value;
    id=document.getElementById("hidden1").value;
    if(id==5)
    window.location.href="http://localhost:8080/index.php/Klijent/chat/"+id+"/"+osoba;
else  window.location.href="http://localhost:8080/index.php/Menadzer/chat/"+id+"/"+osoba;
    
}


function posalji(poruka) {
            var poruka = document.getElementById("porukica").value;

            if (poruka == "") {
                alert("Niste uneli poruku");
                return;
            }
          
        }







