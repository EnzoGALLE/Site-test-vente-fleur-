function surligne(champ, erreur){
   if(erreur)
      champ.style.backgroundColor = "#fba";
   else
      champ.style.backgroundColor = "";
}

function veriftext(champ)
{
   if(champ.value.length < 3 || champ.value.length > 25)
   {
      surligne(champ, true);
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}

function verifchiffre(champ)
{
   var prix = parseInt(prix.value);
   if(isNaN(prix) || prix < 1 || prix > 100){
      surligne(champ, true);
      return false;
   }
   else{
      surligne(champ, false);
      return true;
   }
}

function verifForm(f){
   var prixOk = verifchiffre(f.prix);
   var referenceOk = veriftext(f.reference);
   var nomOk = veriftext(f.nom);
   var imageOk = veriftext(f.image);
   if(prixOk && referenceOk && nomOk && imageOK)
      return true;
   else{
      alert("Veuillez remplir correctement tous les champs");
      return false;
   }
}