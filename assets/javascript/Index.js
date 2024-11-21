//-------------------------Address--------------------------
const adressbtn = document.querySelector('.menu_li_1')
const adressclose = document.querySelector('#adress-close')
const formclose = document.querySelector('.address-container')
adressbtn.addEventListener("click", function () {
    document.querySelector('.address-container').style.display = "block"
})
adressclose.addEventListener("click", function () {
    document.querySelector('.address-container').style.display = "none"
})

var citis = document.getElementById("city");
var districts = document.getElementById("district");
var wards = document.getElementById("ward");
var Parameter = {
  url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
  method: "GET", 
  responseType: "application/json", 
};

var promise = axios(Parameter);
promise.then(function (result) {
  renderCity(result.data);
});

function renderCity(data) {
  for (const x of data) {
    citis.options[citis.options.length] = new Option(x.Name, x.Id);
  }
  citis.onchange = function () {
    district.length = 1;
    ward.length = 1;
    if(this.value != ""){
      const result = data.filter(n => n.Id === this.value);

      for (const k of result[0].Districts) {
        district.options[district.options.length] = new Option(k.Name, k.Id);
      }
    }
  };

  district.onchange = function () {
    ward.length = 1;
    const dataCity = data.filter((n) => n.Id === citis.value);
    if (this.value != "") {
      const dataWards = dataCity[0].Districts.filter(n => n.Id === this.value)[0].Wards;

      for (const w of dataWards) {
        wards.options[wards.options.length] = new Option(w.Name, w.Id);
      }
    }
  };
}
//-----------------------Countdown----------------------------
var countDownDate = new Date("Jan 1, 2100 00:00:00").getTime();
var x = setInterval(function() {

    var now = new Date().getTime();

    var distance = countDownDate - now;

    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
  
    document.getElementById("Hour").innerHTML = hours
    document.getElementById("Minute").innerHTML = minutes
    document.getElementById("Second").innerHTML = seconds
  
    // if (distance < 0) {
    //   clearInterval(x);
    //   document.getElementById("demo").innerHTML = "EXPIRED";
    // }
  }, 1000);
//----------------------------Slideshow----------------------
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("Slideshow_group");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  x[slideIndex-1].style.display = "block";
}

let currentGroup = 0;
const groups = document.querySelectorAll('.Slideshow_group');

function showGroup(index) {
  groups.forEach((group, i) => {
      group.style.display = i === index ? 'block' : 'none';
  });
}

function nextGroup() {
  currentGroup = (currentGroup + 1) % groups.length;
  showGroup(currentGroup);
}

document.addEventListener('DOMContentLoaded', () => {
  showGroup(currentGroup);
  setInterval(nextGroup, 10000);
});

// ------------------------------------------
const btnCart = document.querySelector('#cart')
const btnClose = document.querySelector('#close')

btnCart.addEventListener("click", function () {
    document.querySelector('.order').style.display = "block"
})
btnClose.addEventListener("click", function () {
    document.querySelector('#order').style.display = "none"
})

// --------------------------------------------------------------
