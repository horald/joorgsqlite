function vers_anfordern() {
  req = new XMLHttpRequest();
  req.open("get","https://raw.githubusercontent.com/horald/joorgsqlite/gh-pages/version.json",true);
  req.onreadystatechange = vers_auswerten;
  req.send();
}

function aboutvers_anfordern() {
  req = new XMLHttpRequest();
  req.open("get","https://raw.githubusercontent.com/horald/joorgsqlite/gh-pages/version.json",true);
  req.onreadystatechange = aboutvers_auswerten;
  req.send();
}

function indexvers_anfordern() {
  req = new XMLHttpRequest();
  req.open("get","https://raw.githubusercontent.com/horald/joorgsqlite/gh-pages/version.json",true);
  req.onreadystatechange = indexvers_auswerten;
  req.send();
}

function vers_auswerten(e) {
  if(e.target.readyState == 4 && e.target.status == 200) {
    var antwort;
    if(window.JSON)
      antwort = JSON.parse(e.target.responseText);
    else
      antwort = eval("(" + e.target.responseText + ")");
      document.body.innerHTML += '<form id="dynForm" action="checkupdate.php" method="post"><input type="hidden" name="versnr" value="'+antwort.versnr+'"></form>';
      document.getElementById("dynForm").submit(); 
  }
}

function aboutvers_auswerten(e) {
  if(e.target.readyState == 4 && e.target.status == 200) {
    var antwort;
    if(window.JSON)
      antwort = JSON.parse(e.target.responseText);
    else
      antwort = eval("(" + e.target.responseText + ")");
      document.body.innerHTML += '<form id="dynForm" action="about.php" method="post"><input type="hidden" name="versnr" value="'+antwort.versnr+'"></form>';
      document.getElementById("dynForm").submit(); 
  }
}

function indexvers_auswerten(e) {
  if(e.target.readyState == 4 && e.target.status == 200) {
    var antwort;
    if(window.JSON)
      antwort = JSON.parse(e.target.responseText);
    else
      antwort = eval("(" + e.target.responseText + ")");
      document.body.innerHTML += '<form id="dynForm" action="index.php" method="post"><input type="hidden" name="versnr" value="'+antwort.versnr+'"></form>';
      document.getElementById("dynForm").submit(); 
  }
}
