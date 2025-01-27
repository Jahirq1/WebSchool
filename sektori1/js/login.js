const container = document.querySelector('.container');
const registerbtn = document.querySelector('.register-btn');
const loginbtn = document.querySelector('.login-btn');

registerbtn.addEventListener('click', ()=>{
    container.classList.add('active');
});

loginbtn.addEventListener('click', ()=>{
    container.classList.remove('active');
});

//id qe e kam caktuar une
const useerId=3244;
// validimi i login
document.getElementById('login-form').addEventListener('submit', function(event){
  var profesioni = document.getElementById('profesioni').value;
  var userid=document.getElementById('id').value.trim();
  var password = document.getElementById('fjalkalimi').value.trim(); 
   
  if(profesioni === ""){
    alert("ju lutem zgjidhni nje profesion ");
    event.preventDefault();
    return;
  }
  if(userid === "" || isNaN(userid)){
    alert("ju lutem shkruani nje ID te vlefshme ");
    event.preventDefault();
    return;
  }
  if(password.length<8){
    alert("Fjalkalimi duhet te ket te pakten 8 karaktere");
    event.preventDefault(); 
    return; 
}

alert("jeni kyqur me sukses");
}) ;
// validimi i pjeses regjistrimi
document.getElementById("regjistrimi").addEventListener('submit',function(event){
var profesioni=document.getElementById('profesioni-r').value;
var userid=document.getElementById('id-r').value.trim();
var password=document.getElementById('paswordi-r').value.trim();
var passwordconfrim=document.getElementById('paswordi-r1').value.trim();

if(userid !== useerId.toString()){
    alert("ID-ja që keni futur është e gabuar. Ju lutemi provoni përsëri.");
    event.preventDefault();
    return;
}
if(profesioni ===""){
    alert("Ju lutemi zgjidhni një profesion.");
    event.preventDefault();
    return;
}
if (userid === "" || isNaN(userid)) {
    alert("Ju lutemi shkruani një ID të vlefshme.");
    event.preventDefault();
    return;
}

if(password.length<8){
    alert("Fjalëkalimi duhet të ketë të paktën 8 karaktere.");
        event.preventDefault();
        return;
}
if (password !== passwordconfrim ){
    alert("Fjalëkalimi dhe rishkrimi i fjalëkalimit nuk përputhen.");
    event.preventDefault();
   return;
}

alert("Regjistrimi ishte i suksesshëm!");

});


