/***************************************************************
 Codice Esterno, fonte W3C
 ****************************************************/
function autocomplete(inp, arr, p) {
  console.log(p);
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
       a.setAttribute("id", this.id + "-autocomplete-list");
       a.setAttribute("class", "autocomplete-items");
       this.parentNode.appendChild(a);
       /*per ogni elemento dell'array...*/
      if(p == -1){
        console.log(arr);
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
      }else{
        for (i = 0; i < arr.length; i++) {
          if ((arr[i].toUpperCase()).includes(val.toUpperCase())) {
            /*crea un DIV per ogni elemento che matcha:*/ 
            b = document.createElement("DIV"); 
            /*ne inserisce il contenuto all'interno del div:*/ 
            b.innerHTML = arr[i];
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
 ****************************************************************/

function GesAutocmp(param) {
  var post= param.search("P");
  var xmlhttp = new XMLHttpRequest();//si crea un elemento XMLHTTPREQUEST
    
  xmlhttp.onreadystatechange = function() {
//readyState == 4 stabilisce che la richiesta è stata spedita e la risposta è pronta, status==200 significa che tutto è andatoa buon fine 
    if (this.readyState == 4 && this.status == 200) {
//si decodifica con il metodo .parse il testo ottenuto(i nomi dei topic, ottenuti dalla query sulla tabella topics)  
      var lista = JSON.parse(this.responseText);
      //si passa come parametro la lista ottenuta come valori disponibili per l'autocompletamento  
      autocomplete(document.getElementById("myInput"), lista, post);

      }
  };

  var boo = document.getElementById("blog");
  var incl= param.search("U");
  if(incl !== -1){
    if (boo !== null){
      xmlhttp.open("GET", "../includes/list.php?list=" + param +"&blog_id=" +boo.innerHTML, true);
    }else{
      xmlhttp.open("GET", "includes/list.php?list=" + param, true);
    }
  }else{
    xmlhttp.open("GET", "UserRegistrato/includes/list.php?list=" + param, true);
  }
  xmlhttp.send();
}

