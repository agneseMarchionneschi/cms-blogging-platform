/***************************************************************
 Codice Esterno, fonte W3C
 ****************************************************/
function autocomplete(inp, arr) {
  /*La funzione ha due parametri il campo di testo e un'array contenente tutti i valori per l'autocompletamento*/
 var currentFocus;
 /*esegue la funzione al momento della scrittura nel campo di testo*/
 inp.addEventListener("input", function(e) {
     var a, b, i, val = this.value;
      /*chiude le liste di autocompletamento aperte*/
     closeAllLists();
     if (!val) { return false;}
     currentFocus = -1;
     /*crea un elemento DIV per contenere i valori di autocompletamento*/
     a = document.createElement("DIV");
     a.setAttribute("id", this.id + "autocomplete-list");
     a.setAttribute("class", "autocomplete-items");
     this.parentNode.appendChild(a);
     /*per ogni elemento dell'array...*/
     for (i = 0; i < arr.length; i++) {
           /*controlla se la stringa inserita sia l'inizio di uno o più degli elementi*/
       if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
         /*crea un DIV per ogni elemento che matcha:*/
         b = document.createElement("DIV");
         /*mette in grassetto la parte di stringa che ha un match:*/
         b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
         b.innerHTML += arr[i].substr(val.length);
         /*inserisce un campo input per contenere il valore dell'elemento dell'array:*/
         b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
        /*esegue una funzione al click sul DIV element:*/
             b.addEventListener("click", function(e) {
               /*che inserisce il valore dell'elemento clickato nel campo input a disposizione dell'utente*/
             inp.value = this.getElementsByTagName("input")[0].value;
                /*chiudendo tutte le liste ancora presenti:*/
             closeAllLists();
         });
         a.appendChild(b);
       }
     }
 });
  /*al click su un tasto della keyboard:*/
 inp.addEventListener("keydown", function(e) {
     var x = document.getElementById(this.id + "autocomplete-list");
     if (x) x = x.getElementsByTagName("div");
     if (e.keyCode == 40) {
        /*se viene clickata la freccia in Basso incrementa il valore di currentFocus:*/
       currentFocus++;
       /*mettendo l'elemento in questione in evidenza:*/
       addActive(x);
     } else if (e.keyCode == 38) { //up
         /*Per la arrow UP key currentFocus è decrementata:*/
       currentFocus--;
     
       addActive(x);
     } else if (e.keyCode == 13) {
      /*Al click su enter evita che si azioni il Submit del form*/
       e.preventDefault();
       if (currentFocus > -1) {
          /*e "simula" il click sull'elemento in selezione:*/
         if (x) x[currentFocus].click();
       }
     }
 });
 function addActive(x) {
    /*funzione che classifica un elemento come "active":*/
   if (!x) return false;
    /*rimuove la "active" class da tutti gli elementi:*/
   removeActive(x);
   if (currentFocus >= x.length) currentFocus = 0;
   if (currentFocus < 0) currentFocus = (x.length - 1);
   /*agiungi la classe  "autocomplete-active":*/
   x[currentFocus].classList.add("autocomplete-active");
 }
 function removeActive(x) {
   /*rimuove la "active" class da ogni elemento della lista autocomplete:*/
   for (var i = 0; i < x.length; i++) {
     x[i].classList.remove("autocomplete-active");
   }
 }
 function closeAllLists(elmnt) {
       /*chiude tutte le liste autocomplete ad eccezione di quella passata come parametro:*/
   var x = document.getElementsByClassName("autocomplete-items");
   for (var i = 0; i < x.length; i++) {
     if (elmnt != x[i] && elmnt != inp) {
     x[i].parentNode.removeChild(x[i]);
   }
 }
}
/*al click sul documento si attiva la chiusura di tutte le liste:*/
document.addEventListener("click", function (e) {
   closeAllLists(e.target);
});
}
/***************************************************************
***************************************************************/

function creaCheck() {
 var Uinput = document.getElementById("myInput");
 var cont;
 cont = document.getElementById("containerCreateT");
 a_comp = document.getElementById("autocomplete");
 var msg= document.getElementById("msg_error");
 msg.style.display = "hidden";//al via della funzione i precedenti messaggi vengono nascosti
 
 if(Uinput.value !== ""){
   //ottiene il valore inserito nel campo input
   var tema = document.getElementById("myInput").value;
    //controllo sulla correttezza del valore passato
 }else{
   return;
 }
   if((tema.search([/[\'^£$%&*()}{@#~?><>,|=_+¬]/]|["0-9"])) === -1){//il metodo search ritorna -1 in caso non si trovino i valori passati nella stringa
   //in caso il controllo dia esito positivo si inizializza una casella checkbox spuntata con valore uguale a quello passato in Input
   var label = document.createElement("label");
   label.innerHTML = tema;
   label.setAttribute("class", "container");

   cont.appendChild(label);
 
   var input= document.createElement("input");
   label.appendChild(input);
   input.setAttribute("type", "checkbox");
   input.setAttribute("checked", "checked");
   input.setAttribute("name", "temi_list[]");//viene inserito in una list per l'utilizzo futuro
   input.setAttribute("value", tema );
   var span = document.createElement("span");
   label.appendChild(span);
   span.setAttribute("class", "checkmark");
   Uinput.value= "";//la casella di input viene svuotata
   cont.insertBefore(label, a_comp);
   return;
   }else{//se il controllo dà esito negativo si mostra un messaggio di errore
   document.getElementById("msg_error").style.display = "block";
   return;
 }


}

function GestoreL() {
 var xmlhttp = new XMLHttpRequest();//si crea un elemento XMLHTTPREQUEST
 xmlhttp.onreadystatechange = function() {
   if (this.readyState == 4 && this.status == 200) {//readyState == 4 stabilisce che la richiesta è stata spedita e la risposta è pronta, status==200 significa che è andata buon fine
     var topics = JSON.parse(this.responseText);//si decodifica con il metodo .parse il testo ottenuto(i nomi dei topic, ottenuti dalla query sulla tabella topics)
     autocomplete(document.getElementById("myInput"), topics);//si passa come parametro la lista ottenuta come valori dipsonibili per l'autocompletamento
   }
 };
 xmlhttp.open("GET", "includes/temiTot.php", true);//invia richiesta al server per la pagina temiTOT
 console.dir(autocomplete)
 xmlhttp.send();
}
window.onload= GestoreL;