// Fichier JScript
// sources : http://files.codes-sources.com/fichier.aspx?id=43967&f=VerifMotDePasse%5cindex.htm  
// ctl00_ContentPlaceHolder1_btnModifier" disabled="disabled"
var MinCaracteres = 1; // Nombre minimum de caratères du mot de passe
var CaracteresSecurite = 8; // Nombre de caractères correct pour un mot de passe

// images des différents niveaux
var PicSecurite = new Array();
PicSecurite[0] = "scripts/images/NiveauZero.jpg";
PicSecurite[1] = "scripts/images/NiveauFaible.jpg";
PicSecurite[2] = "scripts/images/NiveauMoyen.jpg";
PicSecurite[3] = "scripts/images/NiveauFort.jpg";

var preLoadSecurite = new Array();
for (i = 0; i < 4; i++){
   preLoadSecurite[i] = new Image();
   preLoadSecurite[i].src = PicSecurite[i];
}

function NiveauSecurite()
{ 
    // pwd : Mot de passe à vérifier
    var pwd = document.getElementById("password").value ; 

    if (IsStrong(pwd))
    {
	   document.getElementById("imgNiveauSecurite").src = preLoadSecurite[3].src;
    }
    else if (IsMedium(pwd))
    {
	    document.getElementById("imgNiveauSecurite").src = preLoadSecurite[2].src;

    }
    else if (IsWeak(pwd))
    {
	    document.getElementById("imgNiveauSecurite").src = preLoadSecurite[1].src;
 	    
    }
    else
    {
	    document.getElementById("imgNiveauSecurite").src = preLoadSecurite[0].src;
    }
}

function IsStrong(pwd)
{
// niveau Fort
	if (pwd.length < CaracteresSecurite)
	{
		return false;
	}else{
        if (!SpansAtLeastNCharacterSets(pwd,4))
        {
        	return false;
        }else{
		    return true;
		}
	}	
}

function IsMedium(pwd)
{
// niveau Moyen
	if (pwd.length < CaracteresSecurite)
	{
		return false;
	}else{
        if (!SpansAtLeastNCharacterSets(pwd,2))
        {
        	return false;
        }else{
		    return true;
		}
	}	
}

function IsWeak(pwd)
{
// niveau Faible
	return (pwd.length >= (MinCaracteres));
}

function SpansAtLeastNCharacterSets( word, N)
{
// Calcul les différents types de caractères du mot de passe
// word : mot de passe, N : Nombre minimun de types de caractère différents pour retour à vrai 
	if (word == null)
		return false;
		
	var csets = new Array(false,false,false,false);

	ncs = 0;
	var listeNombre = "0123456789";
	var listeCaractereSpe = "&é'(-è_çà)=*ù!:;,?./§-+<>$£µ%"+'"';
    for (i = 0; i < word.length; i++)
	{
	    c= word.charAt(i);
		if (listeNombre.indexOf(c)>=0)
		{
		// caractère numérique
			if (csets[0] == false)
			{
				csets[0] = true;
				ncs++;
				if (ncs >= N)
					return true;
			}
		}
		else if (listeCaractereSpe.indexOf(c)>=0)
		{
		// caractère spécial
			if (csets[1] == false)
			{
				csets[1] = true;
				ncs++;
				if (ncs >= N)
					return true;
			}
		}
		else if (c.toUpperCase() ==c)
		{
		// caractère en Majuscule
			if (!csets[2])
			{
				csets[2] = true;
				ncs++;
				if (ncs >= N)
					return true;
			}
			continue;
		}
		else if (c.toLowerCase() ==c)
		{
		// caractère en Minuscule
			if (!csets[3])
			{
				csets[3] = true;
				ncs++;
				if (ncs >= N)
					return true;
			}
		}
	}
	return false;
	
}