function posalji() {
            var ime = document.getElementById("usernameinput").value;
            var lozinka = document.getElementById("passwordinput").value;
            var ponovljenaLozinka = document.getElementById("passwordagaininput").value;
            var email = document.getElementById("emailinput").value;
            var tel = document.getElementById("numberinput").value;

            if (ime == "") {
                alert("Niste uneli korisnicko ime");
                return;
            }
            if (lozinka == "") {
                alert("Niste uneli lozinku");
                return;
            }
            if (ponovljenaLozinka == "") {
                alert("Niste uneli ponovljenu lozinku");
                return;
            }
            if (email == "") {
                alert("Niste uneli email adresu");
                return;
            }
            if (tel == "") {
                alert("Niste uneli broj telefona");
                return;
            }
            if (lozinka != ponovljenaLozinka)  {
                alert("Lozinke nisu iste");
                return;
            }

            alert(ime + " " + lozinka + " " + email + " " + tel);
        }


