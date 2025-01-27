// Referenca për elementet
const drejtimiDropdown = document.getElementById('drejtimin');
const tekstiElement = document.querySelector('.left-section p');
const fotoElement = document.querySelector('.right img');

drejtimiDropdown.addEventListener('change', () => {
    const drejtimin = drejtimiDropdown.value;
    

    if(drejtimin=='Shkenca natyrore'){
      
            tekstiElement.textContent =`
            Shkencat Natyrore në UBT
Në UBT, Shkencat Natyrore ofrojnë një qasje gjithëpërfshirëse për të eksploruar fenomenet natyrore përmes hulumtimit shkencor dhe 
teknologjisë moderne. Programet tona janë të dizajnuara për të përgatitur studentët me njohuri të thella teorike dhe aftësi praktike 
që janë të aplikueshme në fusha të ndryshme si biokimia, fizika, kimia, biologjia dhe mjedisi.

Në këtë program, studentët përfitojnë:

Njohuri shkencore të avancuara: Përmes moduleve teorike dhe punëve laboratorike, studentët mësojnë të kuptojnë dhe të analizojnë 
fenomenet natyrore dhe proceset që ndikojnë në jetën tonë të përditshme.
Eksperiencë praktike: Në laboratorët më modernë të UBT-së, studentët kanë mundësinë të praktikojnë atë që mësojnë, duke përdorur 
teknologjinë më të fundit për kërkime dhe eksperimente.
Hulumtime inovative: Programi inkurajon studentët të zhvillojnë projekte kërkimore në fusha si bioteknologjia, ekologjia, energjia e 
rinovueshme dhe zhvillimi i materialeve të reja.
Interdisiplinariteti: Përmes kombinimit të disiplinave të ndryshme, studentët zhvillojnë një perspektivë të gjerë dhe aftësi për të 
bashkëpunuar në fusha komplekse.
Përse të zgjedhësh Shkencat Natyrore në UBT?
UBT siguron një ambient frymëzues akademik dhe praktik që u mundëson studentëve të zhvillojnë talentet dhe pasionet e tyre. Me fokus në
 zhvillimin e qëndrueshëm dhe teknologjitë bashkëkohore, ne përgatisim profesionistë të cilët janë të gatshëm të përballen me sfidat globale 
 në fushën e shkencave natyrore.

Të diplomuarit në Shkencat Natyrore në UBT mund të ndjekin karriera në mjekësi, farmaci, mjedis, energji të rinovueshme, kërkime shkencore,
 ose industrinë teknologjike. Me ndihmën e mentorëve të kualifikuar dhe infrastrukturës moderne, ata janë të gatshëm të japin një kontribut 
 të rëndësishëm në komunitetin shkencor dhe përtej tij.

Pasioni për shkencën fillon në UBT – aty ku teoria takon praktikën dhe hulumtimi hap horizonte të reja!
        `;
            fotoElement.src = '../img/programit/natural-science.jpg'; 
            

    }else if(drejtimin=='Shkenca shoqerore'){
            tekstiElement.innerHTML = `
           Shkencat Shoqërore në UBT
Në UBT, programi i Shkencave Shoqërore është i dizajnuar për të ndihmuar studentët të kuptojnë më thellë shoqërinë, marrëdhëniet ndërnjerëzore,
 dhe mënyrën se si strukturat shoqërore ndikojnë në jetën e individëve dhe komuniteteve. Ky drejtim synon t’i përgatisë studentët për të analizuar
  dhe adresuar sfidat komplekse të botës moderne përmes një qasjeje ndërdisiplinore.
 Lëndët e programit përfshijnë sociologjinë, politologjinë, psikologjinë, ekonominë, dhe komunikimin. Ky kombinim ofron një bazë të fuqishme 
 për të kuptuar dinamikën shoqërore dhe zhvillimet globale.
Praktika profesionale: Studentët kanë mundësi të angazhohen në institucione qeveritare, organizata joqeveritare (OJQ), agjenci ndërkombëtare 
dhe sektorin privat për të fituar përvojë të vlefshme praktike.
Hulumtime shkencore dhe projekte praktike: Programi inkurajon studentët të realizojnë projekte që adresojnë çështje të rëndësishme shoqërore 
si varfëria, barazia gjinore, të drejtat e njeriut, dhe politikat publike.
Zhvillimi i aftësive të komunikimit dhe analizës kritike: Përmes studimeve dhe aktiviteteve praktike, studentët zhvillojnë aftësitë për të 
kuptuar dhe artikuluar perspektiva të ndryshme mbi çështjet komplekse shoqërore.

UBT ofron një ambient akademik inovativ dhe gjithëpërfshirës që promovon zhvillimin personal dhe profesional të studentëve. Me mbështetje
 nga profesorë të kualifikuar dhe lidhje me institucione të ndryshme kombëtare dhe ndërkombëtare, programi i Shkencave Shoqërore synon të
  përgatisë liderët e së ardhmes.
Të diplomuarit e këtij drejtimi mund të ndjekin karriera në:

Politika dhe administratë publike
Komunikim dhe marrëdhënie me publikun
Psikologji dhe këshillim
Hulumtime sociale dhe statistika
Menaxhim projektesh dhe zhvillim komunitar
Organizata ndërkombëtare dhe institute kërkimore
Shkencat Shoqërore në UBT ju pajisin me mjetet e duhura për të ndikuar pozitivisht në botën përreth dhe për të bërë ndryshimin që shoqëria 
jonë ka nevojë.
        `;
            fotoElement.src = '../img/programit/shoqeror.png';
          

        }else if(drejtimin=='Mjeksi'){
         tekstiElement.innerHTML = `
           UBT Mjekësi  (UBT) në Kosovë ofron programe studimi në fushën e mjekësisë dhe shkencave shëndetësore.
            Kjo degë u krijua për të adresuar nevojat për profesionistë 
            shëndetësorë të kualifikuar në vend dhe më gjerë.

 Lëndët e mjeksise përfshijnë sociologjinë, politologjinë, psikologjinë, ekonominë, dhe komunikimin. Ky kombinim ofron një bazë të fuqishme
  për të kuptuar dinamikën shoqërore dhe zhvillimet globale.
Praktika profesionale: Studentët kanë mundësi të angazhohen në institucione qeveritare, organizata joqeveritare (OJQ), agjenci ndërkombëtare 
dhe sektorin privat për të fituar përvojë të vlefshme praktike.
Hulumtime shkencore dhe projekte praktike: Programi inkurajon studentët të realizojnë projekte që adresojnë çështje të rëndësishme shoqërore 
si varfëria, barazia gjinore, të drejtat e njeriut, dhe politikat publike.
Zhvillimi i aftësive të komunikimit dhe analizës kritike: Përmes studimeve dhe aktiviteteve praktike, studentët zhvillojnë aftësitë për
 të kuptuar dhe artikuluar perspektiva të ndryshme mbi çështjet komplekse shoqërore.

UBT ofron një ambient akademik inovativ dhe gjithëpërfshirës që promovon zhvillimin personal dhe profesional të studentëve. Me mbështetje 
nga profesorë të kualifikuar dhe lidhje me institucione të ndryshme kombëtare dhe ndërkombëtare, programi i Shkencave Shoqërore synon të 
përgatisë liderët e së ardhmes.



Programi i Mjekësisë në UBT synon të formojë profesionistë të shëndetit që kombinojnë njohuritë teorike dhe praktikat bashkëkohore për të 
përmirësuar mirëqenien e individëve dhe shoqërisë. Me një kurrikulë të fokusuar në zhvillimin e kompetencave mjekësore, kërkimeve shkencore 
dhe kujdesit klinik, programi përgatit studentët për të përballuar sfidat dinamike në fushën e kujdesit shëndetësor.

    `;
            fotoElement.src ='../img/programit/mjeksi1.jpg';
   

           }else if(drejtimin=='Teknologji informacioni'){
         tekstiElement.innerHTML = `
          
              Programi i Teknologjisë së Informacionit në UBT është një mundësi e shkëlqyer për ata që duan të bëhen liderë në fushën
               e teknologjisë dhe 
              të zhvillojnë aftësitë e nevojshme për të punuar me sistemet informatike të sotme dhe të ardhshme. Ky program ka një kurrikulë
               të avancuar 
              që përfshin disa aspekte të rëndësishme të IT-së, si zhvillimi i softuerëve, siguria kibernetike, menaxhimi i sistemeve të
               informacionit dhe
               teknologjitë e reja.
Programi mbulon fushat kyçe të Teknologjisë së Informacionit, duke përfshirë:

Programim dhe zhvillim aplikacionesh
Menaxhimi i bazave të të dhënave
Siguria kibernetike dhe mbrojtja e të dhënave
Inxhinieri softuerike dhe zhvillimi i sistemeve informatike
Inteligjenca artificiale dhe teknologjitë e reja, si IoT (Internet of Things) dhe Big Data
Laboratorë dhe pajisje të avancuara
UBT ofron laboratorë të pajisur me teknologjinë më të fundit për zhvillimin e softuerëve dhe testimin e aplikacioneve, duke mundësuar një
 përvojë praktike të 
thellë dhe përgatitje për tregun e punës.

Projekte praktike dhe mundësi pune
Studentët e programit përfshihen në projekte të zhvillimit të aplikacioneve dhe sistemeve reale, duke bashkëpunuar me kompani dhe organizata
 për të krijuar zgjidhje teknologjike. Po ashtu, ata kanë mundësi për të realizuar praktika profesionale në kompani të teknologjisë, ku zhvillojnë
  aftësitë e tyre dhe përgatiten për karrierën.

Siguria kibernetike dhe mbrojtja e informacionit
Me një rritje të vazhdueshme të kërcënimeve kibernetike, programi përfshin mësime dhe trajnime për të krijuar ekspertë që mund të mbrojnë 
sistemet dhe të dhënat në një botë gjithnjë e më të digjitalizuar.

        `;
            fotoElement.src = '../img/programit/R.jpg';
           
           }else{
 
      
          tekstiElement.innerHTML = `
                Zgjedhni një drejtim për të parë më shumë detaje.`;
            fotoElement.src = '../img/post/post4.png'; 
           
    }
});


document.addEventListener("DOMContentLoaded", () => {
  const toggleButton = document.querySelector('.toggle-button');
  const navbarLinks = document.querySelector('.navbar-links');

  toggleButton.addEventListener('click', () => {
      navbarLinks.classList.toggle('active');
  });
});
